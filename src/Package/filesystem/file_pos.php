<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_array.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 範囲指定でファイルを読んで位置を返す
 *
 * $needle に配列を与えると OR 的動作で一つでも見つかった時点の位置を返す。
 * このとき「どれが見つかったか？」は得られない（場合によっては不便なので将来の改修対象）。
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $testpath = sys_get_temp_dir() . '/file_pos.txt';
 * file_put_contents($testpath, "hoge\nfuga\npiyo\nfuga");
 * // fuga の位置を返す
 * that(file_pos($testpath, 'fuga'))->is(5);
 * // 2つ目の fuga の位置を返す
 * that(file_pos($testpath, 'fuga', 6))->is(15);
 * // 見つからない場合は false を返す
 * that(file_pos($testpath, 'hogera'))->is(null);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename ファイル名
 * @param string|array $needle 探す文字列
 * @param int $start 読み込み位置
 * @param int|null $end 読み込むまでの位置。省略時は指定なし（最後まで）。負数は後ろからのインデックス
 * @param int|null $chunksize 読み込みチャンクサイズ。省略時は 4096 の倍数に正規化
 * @return ?int $needle の位置。見つからなかった場合は null
 */
function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null)
{
    if (!is_file($filename)) {
        throw new \InvalidArgumentException("'$filename' is not found.");
    }

    $needle = arrayval($needle, false);
    $maxlength = max(array_map('strlen', $needle));

    if ($start < 0) {
        $start += $filesize ?? $filesize = filesize($filename);
    }
    if ($end === null) {
        $end = $filesize ?? $filesize = filesize($filename);
    }
    if ($end < 0) {
        $end += $filesize ?? $filesize = filesize($filename);
    }
    if ($chunksize === null) {
        $chunksize = 4096 * ($maxlength % 4096 + 1);
    }

    assert(isset($filesize) || !isset($filesize));
    assert($chunksize >= $maxlength);

    $fp = fopen($filename, 'rb');
    try {
        fseek($fp, $start);
        while (!feof($fp)) {
            if ($start > $end) {
                break;
            }
            $last = $part ?? '';
            $part = fread($fp, $chunksize);
            if (($p = strpos_array($part, $needle))) {
                $min = min($p);
                $result = $start + $min;
                return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
            }
            if (($p = strpos_array($last . $part, $needle))) {
                $min = min($p);
                $result = $start + $min - strlen($last);
                return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
            }
            $start += strlen($part);
        }
        return null;
    }
    finally {
        fclose($fp);
    }
}
