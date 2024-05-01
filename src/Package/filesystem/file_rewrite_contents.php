<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ファイルを読み込んで内容をコールバックに渡して書き込む
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $testpath = sys_get_temp_dir() . '/rewrite.txt';
 * file_put_contents($testpath, 'hoge');
 * // 前後に 'pre-', '-fix' を付与する
 * file_rewrite_contents($testpath, fn($contents, $fp) => "pre-$contents-fix");
 * that($testpath)->fileEquals('pre-hoge-fix');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename 読み書きするファイル名
 * @param callable $callback 書き込む内容。引数で $contents, $fp が渡ってくる
 * @param int $operation ロック定数（LOCL_SH, LOCK_EX, LOCK_NB）
 * @return int 書き込まれたバイト数
 */
function file_rewrite_contents($filename, $callback, $operation = 0)
{
    /** @var resource $fp */
    try {
        // 開いて
        $fp = fopen($filename, 'c+b') ?: throw new \UnexpectedValueException('failed to fopen.');
        if ($operation) {
            flock($fp, $operation) ?: throw new \UnexpectedValueException('failed to flock.');
        }

        // 読み込んで
        rewind($fp) ?: throw new \UnexpectedValueException('failed to rewind.');
        $contents = false !== ($t = stream_get_contents($fp)) ? $t : throw new \UnexpectedValueException('failed to stream_get_contents.');

        // 変更して
        rewind($fp) ?: throw new \UnexpectedValueException('failed to rewind.');
        ftruncate($fp, 0) ?: throw new \UnexpectedValueException('failed to ftruncate.');
        $contents = $callback($contents, $fp);

        // 書き込んで
        $return = ($r = fwrite($fp, $contents)) !== false ? $r : throw new \UnexpectedValueException('failed to fwrite.');
        fflush($fp) ?: throw new \UnexpectedValueException('failed to fflush.');

        // 閉じて
        if ($operation) {
            flock($fp, LOCK_UN) ?: throw new \UnexpectedValueException('failed to flock.');
        }
        fclose($fp) ?: throw new \UnexpectedValueException('failed to fclose.');

        // 返す
        return $return;
    }
    catch (\Exception $ex) {
        if (isset($fp)) {
            if ($operation) {
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
        throw $ex;
    }
}
