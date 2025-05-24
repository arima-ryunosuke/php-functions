<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../strings/str_resource.php';
require_once __DIR__ . '/../url/query_parse.php';
// @codeCoverageIgnoreEnd

/**
 * multipart/formdata のパース
 *
 * Example:
 * ```php
 * $data = formdata_parse(<<<FORMDATA
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
 * FORMDATA);
 *
 * that($data['n']['e']['s']['t'])->is('nest');
 * that($data['f'])->isInstanceOf(\SplFileInfo::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 */
function formdata_parse(
    /** @var string|resource フォームデータ文字列 */
    $formdata,
    /** バウンダリ文字列。省略時は1行目から推測する */
    ?string $boundary = null,
    /** 値のデコーダだが実質的にファイルの検出に使う（デフォルトでは一時ファイルの SplFileInfo で返す） */
    ?\Closure $decoder = null,
): /** フォームデータ配列 */ array|\Generator
{
    $decoder ??= function ($filename, $mimetype, $contents) {
        if ($filename === null) {
            return stream_get_contents($contents);
        }
        $tmpname = stream_get_meta_data($contents)['uri'];
        $headers = ['filename' => $filename, 'mimetype' => $mimetype];
        return new class($tmpname, $headers) extends \SplFileObject {
            public function __construct(string $filename, private array $headers)
            {
                parent::__construct($filename);
            }

            public function getHeader(string $key): ?string
            {
                return $this->headers[$key] ?? null;
            }
        };
    };

    $is_resource = is_resource($formdata);
    if (!$is_resource) {
        $formdata = str_resource($formdata);
    }

    $generator = (function () use ($formdata, $decoder) {
        $line = fgets($formdata);
        $boundary ??= trim(substr($line, 2));

        $header = [];
        $fields = [];
        $buffer = str_resource('');
        $breaker = null;
        while (($line = fgets($formdata)) !== false) {
            if ($header === [] && $line === $breaker) {
                rewind($buffer);
                $content = stream_get_contents($buffer);

                $header = array_change_key_case(str_array($content, ':', true), CASE_LOWER);
                $fields = array_map(fn($v) => trim($v, '"'), str_array(explode(';', $header['content-disposition']), '=', true));
                if (isset($fields['filename'])) {
                    $buffer = str_resource('', 0, false);
                }
                else {
                    $buffer = str_resource('');
                }
            }
            elseif (str_starts_with($line, "--$boundary")) {
                ftruncate($buffer, ftell($buffer) - strlen($breaker));
                rewind($buffer);

                // name が無いときの挙動は未定義（現状はスキップ実装）
                if (isset($fields['name'])) {
                    yield $fields['name'] => $decoder($fields['filename'] ?? null, $header['content-type'] ?? null, $buffer);
                }
                $header = [];
                $fields = [];
                $buffer = str_resource('');
            }
            else {
                // 仕様上は CRLF だが守られていない実装はあるので蓄えておく
                $breaker = (string) (($p = strrchr($line, "\r\n")) === false ? strrchr($line, "\n") : $p);
                fwrite($buffer, $line);
            }
        }
    })();

    if ($is_resource) {
        return $generator;
    }

    $result = [];
    foreach ($generator as $name => $content) {
        // @todo いい方法が思い浮かばないので富豪的にやっている
        $query = query_parse($name, '&');                               // ここで a[b][c][d] が a:[b:[c:[d:""]]] になる
        array_walk_recursive($query, fn(&$value) => $value = $content); // ここで a:[b:[c:[d:""]]] が a:[b:[c:[d:$body]]] になる
        $result = array_replace_recursive($result, $query);             // 一つの値しかないのでマージすればよい
    }
    return $result;
}
