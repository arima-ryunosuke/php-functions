<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ファイルを少しずつ読む Generator を返す
 *
 * $stopper で読み込み単位を指定できる
 * - null: fgets で1行読み込み
 * - int: fread でサイズ指定
 * - string: stream_get_line で特定文字列指定
 *
 * $stopper が文字列の場合、$with_stopper でその文字列自体を含むかを指定できる。
 * というよりも stream_get_line だとデフォルトで含まないので、含むようにするフラグに近い。
 * 処理を合わせるためデフォルトは true になっている。
 *
 * Generator は返り値として「返した文字列長の合計」を返す。
 * 区切り文字を捨てる場合、単純なファイルサイズとは一致しないので注意。
 *
 * Example:
 * ```php
 * // 適当にファイルを用意
 * $testpath = sys_get_temp_dir() . '/file_generator.txt';
 * file_put_contents($testpath, "hoge\n---\nhogefuga\n---\nhogefugapiyo\n");
 * // 改行で generator
 * that(file_generator($testpath))->is(["hoge\n", "---\n", "hogefuga\n", "---\n", "hogefugapiyo\n"]);
 * // 3文字で generator
 * that(file_generator($testpath, 3))->is(["hog", "e\n-", "--\n", "hog", "efu", "ga\n", "---", "\nho", "gef", "uga", "piy", "o\n"]);
 * // 区切り文字で generator
 * that(file_generator($testpath, "---\n"))->is(["hoge\n---\n", "hogefuga\n---\n", "hogefugapiyo\n"]);
 * // 区切り文字で generator（そのものを含まない）
 * that(file_generator($testpath, "---\n", false))->is(["hoge\n", "hogefuga\n", "hogefugapiyo\n"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 */
function file_generator(
    /** @var string|resource ファイル名|リソース */ $filename,
    /** チャンク/区切り文字 */ null|int|string $stopper = null,
    /** 区切り文字を含めるか */ bool $with_stopper = true,
): \Generator {
    $fp = is_resource($filename) ? $filename : fopen($filename, 'rb');

    try {
        $result = 0;
        while (!feof($fp)) {
            $buffer = match (true) {
                is_null($stopper)   => fgets($fp),
                is_int($stopper)    => fread($fp, $stopper),
                is_string($stopper) => stream_get_line($fp, PHP_INT_MAX, $stopper),
            };
            if ($buffer === false) {
                break;
            }

            if (is_string($stopper) && $with_stopper) {
                // 読み込み途中なら $stopper で終了したと言える（stream_get_line はそのものを含まないので付け足す）
                if (!feof($fp)) {
                    $buffer .= $stopper;
                }
            }

            $result += strlen($buffer);
            yield $buffer;
        }
        return $result;
    }
    finally {
        fclose($fp);
    }
}
