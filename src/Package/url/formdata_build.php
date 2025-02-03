<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_walk_recursive2.php';
require_once __DIR__ . '/../random/random_string.php';
// @codeCoverageIgnoreEnd

/**
 * multipart/formdata の構築
 *
 * $boundary 未指定時はランダム文字列が生成され、衝突した場合は無限にリトライされる。
 * SplFileInfo はファイルとみなされるが $encoder を指定すれば CURLFile なども活用可能。
 *
 * Example:
 * ```php
 * $file = sys_get_temp_dir() . '/upload.txt';
 * file_put_contents($file, 'plain');
 *
 * $boundary = 'hogefugapiyo';
 * that(formdata_build([
 *     'n' => ['e' => ['s' => ['t' => 'nest']]],
 *     'f' => new \SplFileInfo($file),
 * ], $boundary))->is(strtr(<<<FORMDATA
 * --hogefugapiyo
 * Content-Disposition: form-data; name="n[e][s][t]"
 *
 * nest
 * --hogefugapiyo
 * Content-Disposition: form-data; name="f"; filename="upload.txt"
 * Content-Type: text/plain
 *
 * plain
 * --hogefugapiyo--
 * FORMDATA, ["\n" => "\r\n"]));
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 */
function formdata_build(
    /** フォームデータ配列 */
    array $formdata,
    /** バウンダリ文字列初期値兼レシーバ引数 */
    ?string &$boundary = null,
    /** 値のエンコーダだが実質的にファイルの検出に使う（デフォルトでは SplFileInfo がファイルと認識される） */
    ?\Closure $encoder = null,
): /** フォームデータ文字列 */ string
{
    $encoder ??= function ($v) {
        if ($v instanceof \SplFileInfo) {
            return [
                'filename' => rawurlencode($v->getBasename()),
                'mimetype' => mime_content_type($v->getRealPath()),
                'contents' => file_get_contents($v->getRealPath()),
            ];
        }
        return $v;
    };
    $escaper = fn($v) => strtr($v, [
        '"'    => '%22',
        "\r\n" => "%0D%0A",
        "\r"   => "%0D%0A",
        "\n"   => "%0D%0A",
    ]);

    while (true) {
        try {
            $boundary ??= '----' . random_string(64);

            $result = "";
            array_walk_recursive2($formdata, function ($v, $key, $array, $keys) use (&$result, $escaper, $boundary, $encoder) {
                // http_build_query に倣って null はスルーする
                if ($v === null) {
                    return;
                }

                // name を生成（エスケープはどうすればいいか分からなかったので chrome の挙動を真似た）
                $keys[] = $key;
                $name = array_shift($keys) . implode('', array_map(fn($k) => "[$k]", $keys));
                $name = $escaper($name);

                // ファイルとスカラーの判定・分岐
                $body = $encoder($v);
                if (is_array($body)) {
                    $header = implode("\r\n", [
                        sprintf('Content-Disposition: form-data; name="%s"; filename="%s"', $name, $body['filename']),
                        sprintf('Content-Type: %s', $body['mimetype']),
                    ]);
                    $body = $body['contents'];
                }
                else {
                    $header = implode("\r\n", [
                        sprintf('Content-Disposition: form-data; name="%s"', $name),
                    ]);
                }

                // バウンダリの衝突チェック
                if (str_contains($body, $boundary) !== false) {
                    throw new \DomainException('boundary collision');
                }

                // 構築（埋め込みや一時結合はできるだけ避けた方が良いと思う）
                $result .= "--$boundary\r\n";
                $result .= "$header\r\n\r\n";
                $result .= $body;
                $result .= "\r\n";
            });

            if (strlen($result)) {
                $result .= "--$boundary--";
            }
            return $result;
        }
        catch (\Throwable $t) {
            if ($t->getMessage() !== 'boundary collision') {
                throw $t;
            }
            $boundary = null;
        }
    }
}
