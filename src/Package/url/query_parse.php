<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/multiexplode.php';
// @codeCoverageIgnoreEnd

/**
 * parse_str の返り値版
 *
 * 標準の parse_str は参照で受ける謎シグネチャなのでそれを返り値に変更したもの。
 * と同時に parse_str はドットやスペースをアンダースコアに置換するため、それを避ける独自実装がある。
 * $arg_separator や $encoding_type を指定すると独自実装で動きかつその引数の挙動でパースされる。
 *
 * Example:
 * ```php
 * // 普通に使えばネイティブの返り値版
 * that(query_parse('a.b=ab&x[y][z]=xyz'))->is([
 *     'a_b' => 'ab',
 *     'x'   => ['y' => ['z' => 'xyz']],
 * ]);
 * // パラメータを渡せば独自実装（& 以外を指定できたり . を維持できたりする）
 * that(query_parse('a.b=ab|x[y][z]=xyz', '|'))->is([
 *     'a.b' => 'ab',
 *     'x'   => ['y' => ['z' => 'xyz']],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $query クエリ文字列
 * @param ?string $arg_separator クエリ文字列
 * @param ?int $encoding_type クエリ文字列
 * @return array クエリのパース結果配列
 */
function query_parse($query, $arg_separator = null, $encoding_type = null)
{
    // 指定されていないなら php ネイティブ
    if ($arg_separator === null && $encoding_type === null) {
        parse_str($query, $result);
        return $result;
    }

    $arg_separator ??= ini_get('arg_separator.input');
    $encoding_type ??= PHP_QUERY_RFC1738;

    $params = multiexplode(str_split($arg_separator), $query);
    $result = [];
    foreach ($params as $param) {
        [$name, $value] = explode("=", trim($param), 2) + [1 => ''];
        if ($name === '') {
            continue;
        }
        if ($encoding_type === PHP_QUERY_RFC1738) {
            $name = urldecode($name);
            $value = urldecode($value);
        }
        elseif ($encoding_type === PHP_QUERY_RFC3986) {
            $name = rawurldecode($name);
            $value = rawurldecode($value);
        }

        if (preg_match_all('#\[([^]]*)\]#mu', $name, $matches, PREG_OFFSET_CAPTURE)) {
            $name = substr($name, 0, $matches[0][0][1]);
            $keys = array_column($matches[1], 0);

            $receiver = &$result[$name];
            foreach ($keys as $key) {
                if (strlen($key) === 0) {
                    if (!is_array($receiver)) {
                        $receiver = [];
                    }
                    $key = max(array_filter(array_keys($receiver ?? []), 'is_int') ?: [-1]) + 1;
                }
                $receiver = &$receiver[$key];
            }
        }
        else {
            $receiver = &$result[$name];
        }

        $receiver = $value;
    }
    return $result;
}
