<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/file_list.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルが同じ内容か返す
 *
 * ファイルサイズで比較して一致したら更に内容を読んで判定する。
 * ディレクトリ同士の場合は直下のファイル群を内容とみなして判定する。
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $testpath1 = sys_get_temp_dir() . '/file_equals1.txt';
 * $testpath2 = sys_get_temp_dir() . '/file_equals2.txt';
 * $testpath3 = sys_get_temp_dir() . '/file_equals3.txt';
 * file_put_contents($testpath1, "hoge");
 * file_put_contents($testpath2, "foo");
 * file_put_contents($testpath3, "hoge");
 * // 異なるなら false
 * that(file_equals($testpath1, $testpath2))->isFalse();
 * // 同じなら true
 * that(file_equals($testpath1, $testpath3))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $file1 ファイル名1
 * @param string $file2 ファイル名2
 * @param ?int $chunk_size 読み込みチャンクサイズ
 * @return bool ファイルが同じ内容なら true
 */
function file_equals($file1, $file2, $chunk_size = null)
{
    $chunk_size ??= 4096;

    if (!file_exists($file1) || !file_exists($file2)) {
        $files = array_filter([$file1, $file2], 'file_exists');
        throw new \InvalidArgumentException(implode(',', $files) . " does not exist.");
    }

    if (is_dir($file1) xor is_dir($file2)) {
        return false;
    }

    if (is_dir($file1) && is_dir($file2)) {
        $opt = ['relative' => true, 'recursive' => false];
        return file_list($file1, $opt) === file_list($file2, $opt);
    }

    // ファイルサイズが異なるなら異なるファイルなのは間違いない
    if (filesize($file1) !== filesize($file2)) {
        return false;
    }

    // 結局ファイルをすべて読むし衝突の可能性もなくはないのでハッシュ比較は不採用
    //return sha1_file($file1) === sha1_file($file2);

    // 少しづつ読んで比較する
    try {
        $fp1 = fopen($file1, 'r');
        $fp2 = fopen($file2, 'r');

        while (!(feof($fp1) || feof($fp2))) {
            $line1 = fread($fp1, $chunk_size);
            $line2 = fread($fp2, $chunk_size);
            if ($line1 !== $line2) {
                return false;
            }
        }
        return true;
    }
    finally {
        if (isset($fp1)) {
            fclose($fp1);
        }
        if (isset($fp2)) {
            fclose($fp2);
        }
    }
}
