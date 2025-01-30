<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * opcache を減らす
 *
 * 生存期間が $thresholdLifetime 以上で hits が $thresholdHits 以下の opcache を消す。
 * cli で呼んでも意味がないので health check script あたりで呼ぶといいかもしれない。
 *
 * $deletedFile は存在しない場合に消す。
 * 存在しないファイルは validate_timestamp で次読み込み時に自動で無効になるが、それが無効だったり今すぐ消したいときに使う。
 * ので実質的に false 指定することはない（実ファイル無しで opcache のみで運用しているような特殊なケースでしか意味はない）。
 *
 * $modifiedFile は更新された場合に消す。
 * 消えたか変更されたかの違いで挙動自体は $deletedFile と同じ（次回無効になるのではなく今すぐ無効化したい場合に使う）。
 *
 * $includeCondition を指定すると必ず維持される。例えば vendor を維持するなど。
 * $excludeCondition を指定すると必ず除去される。例えば php cache を除去するなど。
 *
 * なお、opcache_invalidate しても無効化されるだけで opcache_get_status のエントリには残る（次回アクセス時に再コンパイルされる）。
 * つまり一向に opcache_get_status から消えないのは正常動作。
 * （メモリ使用量にはちゃんと換算されているが、スクリプト数には換算されない。おそらくネガティブキャッシュみたいなものなんだろう）。
 * この時 opcache.max_accelerated_files を超えていても残り続けるので以後新しいファイルもコンパイルされない。
 * 基本的に「opcache_reload の前段でコールして無用なキャッシュを保存されないようにする」くらいの用途しかない。
 *
 * この関数は互換性を考慮しない。
 *
 * @package ryunosuke\Functions\Package\opcache
 */
function opcache_gc(
    /** 生存期間が指定以上を対象にする */ int $thresholdLifetime = 24 * 3600,
    /** ヒット数が指定以下を対象にする */ int $thresholdHits = 0,
    /** 元ファイルが存在しないものを対象にする */ bool $deletedFile = true,
    /** 元ファイルが変更されたものを対象にする */ bool $modifiedFile = true,
    /** 強制的に維持する条件クロージャ */ ?\Closure $includeCondition = null,
    /** 強制的に除去する条件クロージャ */ ?\Closure $excludeCondition = null,
): /** gc したファイル配列 */ array
{
    $result = [];
    foreach (opcache_get_status()['scripts'] ?? [] as $key => $script) {
        // 無効になってもエントリは消えずに timestamp=0 で残るっぽい？
        if ($script['timestamp'] === 0) {
            continue;
        }

        if ($includeCondition && $includeCondition($script)) {
            continue;
        }

        if (
            ($excludeCondition && $excludeCondition($script)) ||
            ($deletedFile && !file_exists($script['full_path'])) ||
            ($modifiedFile && file_exists($script['full_path']) && filemtime($script['full_path']) > $script['timestamp']) ||
            ($script['hits'] <= $thresholdHits && (time() - $script['last_used_timestamp']) >= $thresholdLifetime)
        ) {
            opcache_invalidate($script['full_path'], true);
            $result[$key] = $script;
        }
    }
    return $result;
}
