<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 数値キーを削除する http_build_query
 *
 * php の世界において配列のクエリ表現は `var[]=1&var[]=2` で事足りる。
 * しかし http_build_query では数値キーでも必ず `var[0]=1&var[1]=2` になる。
 * それはそれで正しいし、他言語との連携が必要な場合はそうせざるを得ない状況もあるが、単純に php だけで配列を表したい場合は邪魔だし文字長が長くなる。
 * この関数を使うと数値キーを削除し、`var[]=1&var[]=2` のようなクエリ文字列を生成できる。
 *
 * シグネチャは http_build_query と同じで、 $numeric_prefix に数値的文字列を与えたときのみ動作が変化する。
 * （$numeric_prefix の意味を考えればこの引数に数値的文字列を与える意味は皆無だろうので流用している）。
 *
 * - 1 を与えると最前列を残して [] (%5B%5D) が置換される
 * - 2 を与えると最前列とその右を残して [] (%5B%5D) が置換される
 * - 要するに正数を与えると「abs(n) 個を残して [] (%5B%5D) を置換する」という指定になる
 * - -1 を与えると最後尾の [] (%5B%5D) が置換される
 * - -2 を与えると最後尾とその左の [] (%5B%5D) が置換される
 * - 要するに負数を与えると「右から abs(n) 個の [] (%5B%5D) を置換する」という指定になる
 *
 * この仕様は `v[][]=1&v[][]=2` のようなときにおいしくないためである。
 * これは `$v=[[1], [2]]` のような値になるが、この場合 `$v=[[1, 2]]` という値が欲しい、という事が多い。
 * そのためには `v[0][]=1&v[0][]=2` のようにする必要があるための数値指定である。
 *
 * $brackets で配列ブラケット文字を指定できるが、現実的には下記の3択だろう。
 * - ['%5B','%5D']: デフォルトのパーセントエンコーディング文字
 * - ['[', ']']: [] のままにする（ブラケットは必ずしもパーセントエンコーディングが必須ではない）
 * - ['', '']: ブラケットを削除する（他言語のために配列パラメータを抑止したいことがある）
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param array|object $data クエリデータ
 * @param string|int|null $numeric_prefix 数値キープレフィックス
 * @param string|null $arg_separator クエリセパレータ
 * @param int $encoding_type エンコードタイプ
 * @param string[]|string|null $brackets 配列ブラケット文字
 * @return string クエリ文字列
 */
function query_build($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = \PHP_QUERY_RFC1738, $brackets = null)
{
    $data = arrayval($data, false);
    if (!$data) {
        return '';
    }

    $arg_separator ??= ini_get('arg_separator.output');
    $brackets ??= ['%5B', '%5D'];

    if (!is_array($brackets)) {
        $brackets = [$brackets, ''];
    }
    $brackets = array_values($brackets);

    $REGEX = '%5B\d+%5D';
    $NOSEQ = implode('', $brackets);
    if ($numeric_prefix === null || ctype_digit(trim($numeric_prefix, '-+'))) {
        $queries = explode($arg_separator, http_build_query($data, '', $arg_separator, $encoding_type));
    }
    else {
        $queries = explode($arg_separator, http_build_query($data, $numeric_prefix, $arg_separator, $encoding_type));
    }
    foreach ($queries as &$q) {
        [$k, $v] = explode('=', $q, 2);

        // 0は置換しないを意味する
        if ($numeric_prefix === 0) {
            // do nothing
            assert($numeric_prefix === 0);
        }
        // null は無制限置換
        elseif ($numeric_prefix === null) {
            $k = preg_replace("#$REGEX#u", $NOSEQ, $k);
        }
        else {
            $count = $numeric_prefix > 0 ? 0 : -preg_match_all("#$REGEX#u", $k);
            $k = preg_replace_callback("#$REGEX#u", function ($m) use (&$count, $numeric_prefix, $NOSEQ) {
                return $count++ >= $numeric_prefix ? $NOSEQ : $m[0];
            }, $k);
        }

        $k = str_replace(['%5B', '%5D'], $brackets, $k);

        $q = "$k=$v";
    }

    return implode($arg_separator, $queries);
}
