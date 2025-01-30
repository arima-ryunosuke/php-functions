<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../filesystem/fnmatch_or.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * opcache の保存兼ウォームアップ
 *
 * コールすると現在キャッシュされている opcache のリストを保存しつつ、必要であれば再コンパイルする。
 * 動的な preload として使用することを想定しているので定期的に呼ぶ必要がある。
 * cli で呼んでも意味がないので health check script あたりで呼ぶといいかもしれない。
 *
 * health check script で呼ぶ時は $reset に注意。
 * true にすると opcache_reset が呼ばれるので再コンパイルが終わるまで処理が遅くなる可能性がある。
 * この引数は「ネガティブキャッシュもクリーンにしたい」という状況のためで、logrotate 等で reload してしまえば原則的に指定不要。
 *
 * preload は強力だが運用が難しく、「動的に育てつつある程度キャッシュできれば構わない」というゆるふわな運用が難しい。
 * この関数を呼ぶ script を systemd start 等で叩けばそれだけで簡易ウォームアップとなる。
 * 様々な理由でそのリクエストは失敗するかもしれないが、本運用には何も影響しない。
 * あるいは preload に設定してもよい。少なくともエラーにはならないようにしてある。
 *
 * この関数は互換性を考慮しない。
 *
 * @package ryunosuke\Functions\Package\opcache
 */
function opcache_reload(
    /** 対象パターン */ array $includePatterns = [],
    /** 除外パターン */ array $excludePatterns = [],
    /** reset を伴うか */ bool $reset = false,
    /** エラーを無視するか（null なら SAPI に応じて自動） */ ?bool $ignoreErrors = null,
    /** キャッシュファイル名（原則としてテスト用） */ ?string $cachefile = null,
): /** キャッシュ結果配列 */ array
{
    $ignoreErrors ??= isset($_SERVER['PHP_SELF']);
    $cachefile ??= function_configure('storagedir') . '/' . rawurlencode(__FUNCTION__) . '.json';

    // リスト読み込み
    $filelist = [];
    $original = null;
    if (file_exists($cachefile)) {
        $filelist = @json_decode(file_get_contents($cachefile), true) ?? [];
        $original = $filelist;
    }

    // リスト更新
    $filelist = array_replace($filelist, (function () {
        $result = [];
        foreach (opcache_get_status()['scripts'] ?? [] as $key => $script) {
            unset($script['full_path']);           // キーと同じ
            unset($script['hits']);                // キャッシュ時点での hits に価値はない
            unset($script['last_used_timestamp']); // 同上
            unset($script['last_used']);           // 値としては last_used_timestamp と実質同じ
            $result[$key] = $script;
        }
        return $result;
    })());

    // preload のコンテキストで2回読もうとすると即死することがあるのでチェック用
    $included_files = array_flip(get_included_files());

    // fpm のコンテキストではログが汚れるので無視したい（ちなみにエラーは内部で発生するみたいで抑制する手段がない）
    // preload のコンテキストでは不審死したときに原因が分からないのでログりたい
    if ($ignoreErrors) {
        $log_errors = ini_set('log_errors', 'off');
    }

    // 再コンパイル
    if ($reset) {
        opcache_reset();
    }
    $result = [];
    try {
        foreach ($filelist as $file => $script) {
            if ($script['timestamp'] > 0 && file_exists($file)) {
                if ((!$includePatterns || fnmatch_or($includePatterns, $file)) && (!$excludePatterns || !fnmatch_or($excludePatterns, $file))) {
                    try {
                        // opcache_compile_file は結構容易にコケるが、あくまで warmup が目的なのでエラーはスルーする
                        if (!isset($included_files[$file]) && !opcache_is_script_cached($file)) {
                            $result[$file] = 'compile';
                            @opcache_compile_file($file);
                        }
                    }
                    catch (\Throwable $t) {
                        $result[$file] = 'error: ' . $t->getMessage();
                        unset($filelist[$file]);
                    }
                }
                else {
                    // 引数依存で保存されてしまうので unset はしない
                    $result[$file] = 'ignore';
                }
            }
            else {
                $result[$file] = 'invalidate';
                opcache_invalidate($file, true);
                unset($filelist[$file]);
            }
        }
        return $result;
    }
    finally {
        if (isset($log_errors)) {
            ini_set('log_errors', $log_errors);
        }

        if ($original !== $filelist) {
            file_set_contents($cachefile, json_encode($filelist, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }
}
