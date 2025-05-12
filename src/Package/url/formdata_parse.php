<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/tmpname.php';
require_once __DIR__ . '/../strings/str_array.php';
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
    /** フォームデータ文字列 */
    string $formdata,
    /** バウンダリ文字列。省略時は1行目から推測する */
    ?string $boundary = null,
    /** 値のデコーダだが実質的にファイルの検出に使う（デフォルトでは一時ファイルの SplFileInfo で返す） */
    ?\Closure $decoder = null,
): /** フォームデータ配列 */ array
{
    $decoder ??= function ($filename, $mimetype, $contents) {
        if ($filename === null) {
            return $contents;
        }
        $fname = tmpname('FD');
        file_put_contents($fname, $contents);
        return new \SplFileInfo($fname);
    };

    // バウンダリで分割
    $boundary ??= substr(preg_split('#\R#u', $formdata, 2)[0], 2);
    $boundary = preg_quote($boundary, '#');
    $contents = preg_split("#\R?--$boundary(--)?\R?#u", $formdata, -1, PREG_SPLIT_NO_EMPTY);

    $result = [];
    foreach ($contents as $content) {
        // ヘッダとボディに分割
        [$header, $body] = preg_split("#\R{2}#u", $content, 2);

        // ヘッダを連想配列に変換
        $headers = array_change_key_case(str_array($header, ':', true), CASE_LOWER);
        $fields = str_array(explode(';', $headers['content-disposition']), '=', true);

        // name が無いときの挙動は未定義（現状はスキップ実装）
        if (isset($fields['name'])) {
            $body = $decoder($fields['filename'] ?? null, $headers['content-type'] ?? null, $body);

            // @todo いい方法が思い浮かばないので富豪的にやっている
            $query = query_parse(trim($fields['name'], '"'), '&');       // ここで a[b][c][d] が a:[b:[c:[d:""]]] になる
            array_walk_recursive($query, fn(&$value) => $value = $body); // ここで a:[b:[c:[d:""]]] が a:[b:[c:[d:$body]]] になる
            $result = array_replace_recursive($result, $query);          // 一つの値しかないのでマージすればよい
        }
    }
    return ($result);
}
