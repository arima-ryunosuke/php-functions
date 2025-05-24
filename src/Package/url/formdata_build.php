<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
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
 * @return string|(iterable&\Countable)
 */
function formdata_build(
    /** フォームデータ配列 */
    iterable $formdata,
    /** バウンダリ文字列初期値兼レシーバ引数 */
    ?string &$boundary = null,
    /** 値のエンコーダだが実質的にファイルの検出に使う（デフォルトでは SplFileInfo がファイルと認識される） */
    ?\Closure $encoder = null,
): /** フォームデータ文字列 */ string|iterable|\Countable
{
    $encoder ??= function ($v) {
        if ($v instanceof \SplFileInfo) {
            return [
                'filename' => rawurlencode($v->getBasename()),
                'mimetype' => mime_content_type($v->getRealPath()),
                'contents' => fn() => yield from $v instanceof \SplFileObject ? $v : new \SplFileObject($v->getRealPath()),
            ];
        }
        return fn() => yield $v;
    };
    $escaper = fn($v) => strtr($v, [
        '"'    => '%22',
        "\r\n" => "%0D%0A",
        "\r"   => "%0D%0A",
        "\n"   => "%0D%0A",
    ]);

    // generator を利用しているのはファイルの読み込みのためであって引数自体にまずいのは来ないので配列に正規化してしまってよい
    $formdata2 = is_array($formdata) ? $formdata : iterator_to_array($formdata);

    while (true) {
        try {
            $boundary ??= '----' . random_string(64);

            $main = function ($array, $keys, $meta, $callback) use (&$main, $boundary) {
                $result = false;
                foreach ($array as $k => $v) {
                    if (is_array($v)) {
                        $g = $main($v, array_merge($keys, [$k]), $meta, $callback);
                    }
                    else {
                        $g = $callback($v, $k, $keys, $meta);
                    }
                    yield from $g;
                    $result = $g->getReturn() || $result;
                }

                if ($keys === [] && $result) {
                    yield "--$boundary--";
                }
                return $result;
            };
            $callback = function ($v, $key, $keys, $meta) use ($escaper, $boundary, $encoder) {
                // http_build_query に倣って null はスルーする
                if ($v === null) {
                    return false;
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

                // 構築（埋め込みや一時結合はできるだけ避けた方が良いと思う）
                yield "--$boundary\r\n";
                yield "$header\r\n\r\n";
                if ($meta) {
                    if ($v instanceof \SplFileInfo) {
                        yield $v->getSize();
                    }
                    else {
                        yield strlen($v);
                    }
                }
                else {
                    foreach ($body() as $part) {
                        // バウンダリの衝突チェック
                        if (str_contains($part, $boundary) !== false) {
                            throw new \DomainException('boundary collision');
                        }
                        yield $part;
                    }
                }
                yield "\r\n";
                return true;
            };
            $generator = $main($formdata2, [], false, $callback);

            if (!is_array($formdata)) {
                $length = 0;
                foreach ($main($formdata2, [], true, $callback) as $string_or_size) {
                    $length += is_int($string_or_size) ? $string_or_size : strlen($string_or_size);
                }
                return new class($generator, $length) implements \IteratorAggregate, \Countable {
                    public function __construct(private iterable $generator, private int $length) { }

                    public function getIterator(): \Generator
                    {
                        yield from $this->generator;
                    }

                    public function count(): int
                    {
                        return $this->length;
                    }
                };
            }

            $result = implode('', iterator_to_array($generator, false));
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
