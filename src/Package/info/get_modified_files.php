<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/fnmatch_or.php';
// @codeCoverageIgnoreEnd

/**
 * 初回読み込み時から変更のあったファイル配列を返す
 *
 * 初回呼び出し時は必ず空配列を返し、以後の呼び出しで変更のあったファイルを返す。
 * 削除されたファイルも変更とみなす。
 *
 * 用途的には「php で書かれたデーモンで、変更感知して自動で再起動する（systemd に任せる）」がある。
 *
 * Example:
 * ```php
 * // 別プロセスで3秒後に自分自身を触る
 * $p = process_async(PHP_BINARY, ['-r' => 'sleep(3);touch($argv[1]);', __FILE__]);
 *
 * $time = microtime(true);
 * foreach (range(1, 10) as $i) {
 *     // 何らかのデーモン（完全に wait する系ではなく時々処理が戻ってくる必要がある）
 *     sleep(1);
 *
 *     // 自身の変更を感知したら break なり exit なりで抜ける（大抵はそのまま終了する。起動は systemd に丸投げする）
 *     if (get_modified_files(__FILE__)) {
 *         break;
 *     }
 * }
 * // 全ループすると10秒かかるが、大体3秒程度で抜けているはず
 * that(microtime(true) - $time)->break()->lt(3.9);
 * unset($p);
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param string|array $target_pattern 対象ファイルパターン（マッチしないものは無視される）
 * @param string|array $ignore_pattern 除外ファイルパターン（マッチしたものは無視される）
 * @return array 変更のあったファイル名配列
 */
function get_modified_files($target_pattern = '*.php', $ignore_pattern = '*.phtml')
{
    static $file_mtimes = [];

    $modified = [];
    foreach (get_included_files() as $filename) {
        $mtime = file_exists($filename) ? filemtime($filename) : time();

        // 対象外でも引数違いの呼び出しのために入れておかなければならない
        if (!fnmatch_or($target_pattern, $filename, FNM_NOESCAPE) || fnmatch_or($ignore_pattern, $filename, FNM_NOESCAPE)) {
            $file_mtimes[$filename] ??= $mtime;
            continue;
        }

        if (!isset($file_mtimes[$filename])) {
            $file_mtimes[$filename] = $mtime;
        }
        elseif ($mtime > $file_mtimes[$filename]) {
            $modified[] = $filename;
        }
    }

    return $modified;
}
