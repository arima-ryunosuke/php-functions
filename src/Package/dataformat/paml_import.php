<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_put.php';
require_once __DIR__ . '/../strings/quoteexplode.php';
// @codeCoverageIgnoreEnd

/**
 * paml 的文字列をパースする
 *
 * paml とは yaml を簡易化したような独自フォーマットを指す（Php Array Markup Language）。
 * ざっくりと下記のような特徴がある。
 *
 * - ほとんど yaml と同じだがフロースタイルのみでキーコロンの後のスペースは不要
 * - yaml のアンカーや複数ドキュメントのようなややこしい仕様はすべて未対応
 * - 配列を前提にしているので、トップレベルの `[]` `{}` は不要
 * - `[]` でいわゆる php の配列、 `{}` で stdClass を表す（オプション指定可能）
 * - bare string で php の定数を表す（クラス定数も完全修飾すれば使用可能）
 *
 * 簡易的な設定の注入に使える（yaml は標準で対応していないし、json や php 配列はクオートの必要やケツカンマ問題がある）。
 * なお、かなり緩くパースしてるので基本的にエラーにはならない。
 *
 * 早見表：
 *
 * - php:  `["n" => null, "f" => false, "i" => 123, "d" => 3.14, "s" => "this is string", "a" => [1, 2, "x" => "X"]]`
 *     - ダブルアローとキーのクオートが冗長
 * - json: `{"n":null, "f":false, "i":123, "d":3.14, "s":"this is string", "a":{"0": 1, "1": 2, "x": "X"}}`
 *     - キーのクオートが冗長だしケツカンマ非許容
 * - yaml: `{n: null, f: false, i: 123, d: 3.14, s: "this is string", a: {0: 1, 1: 2, x: X}}`
 *     - 理想に近いが、コロンの後にスペースが必要だし連想配列が少々難。なにより拡張や外部ライブラリが必要
 * - paml: `n:null, f:false, i:123, d:3.14, s:"this is string", a:[1, 2, x:X]`
 *     - シンプルイズベスト
 *
 * Example:
 * ```php
 * // こういったスカラー型はほとんど yaml と一緒だが、コロンの後のスペースは不要（あってもよい）
 * that(paml_import('n:null, f:false, i:123, d:3.14, s:"this is string"'))->isSame([
 *     'n' => null,
 *     'f' => false,
 *     'i' => 123,
 *     'd' => 3.14,
 *     's' => 'this is string',
 * ]);
 * // 配列が使える（キーは連番なら不要）。ネストも可能
 * that(paml_import('a:[1,2,x:X,3], nest:[a:[b:[c:[X]]]]'))->isSame([
 *     'a'    => [1, 2, 'x' => 'X', 3],
 *     'nest' => [
 *         'a' => [
 *             'b' => [
 *                 'c' => ['X']
 *             ],
 *         ],
 *     ],
 * ]);
 * // bare 文字列で定数が使える。::class も特別扱いで定数とみなす
 * that(paml_import('pv:PHP_VERSION, ao:ArrayObject::STD_PROP_LIST, class:ArrayObject::class'))->isSame([
 *     'pv'    => \PHP_VERSION,
 *     'ao'    => \ArrayObject::STD_PROP_LIST,
 *     'class' => \ArrayObject::class,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $pamlstring PAML 文字列
 * @param array $options オプション配列
 * @return array php 配列
 */
function paml_import($pamlstring, $options = [])
{
    $options += [
        'cache'          => true,
        'trailing-comma' => true,
        'stdclass'       => true,
        'expression'     => false,
        'escapers'       => ['"' => '"', "'" => "'", '[' => ']', '{' => '}'],
    ];

    static $caches = [];
    if ($options['cache']) {
        $key = $pamlstring . json_encode($options);
        return $caches[$key] ??= paml_import($pamlstring, ['cache' => false] + $options);
    }

    $resolve = function (&$value) use ($options) {
        $prefix = $value[0] ?? null;
        $suffix = $value[-1] ?? null;

        if (($prefix === '[' && $suffix === ']') || ($prefix === '{' && $suffix === '}')) {
            $values = paml_import(substr($value, 1, -1), $options);
            $value = ($prefix === '[' || !$options['stdclass']) ? (array) $values : (object) $values;
            return true;
        }

        if ($prefix === '"' && $suffix === '"') {
            //$element = stripslashes(substr($element, 1, -1));
            $value = json_decode($value);
            return true;
        }
        if ($prefix === "'" && $suffix === "'") {
            $value = substr($value, 1, -1);
            return true;
        }

        if (ctype_digit(ltrim($value, '+-'))) {
            $value = (int) $value;
            return true;
        }
        if (is_numeric($value)) {
            $value = (double) $value;
            return true;
        }

        if (defined($value)) {
            $value = constant($value);
            return true;
        }
        [$class, $cname] = explode('::', $value, 2) + [1 => ''];
        if (class_exists($class) && strtolower($cname) === 'class') {
            $value = ltrim($class, '\\');
            return true;
        }

        if ($options['expression']) {
            $semicolon = ';';
            if ($prefix === '`' && $suffix === '`') {
                $value = eval("return " . substr($value, 1, -1) . $semicolon);
                return true;
            }
            try {
                $evalue = @eval("return $value$semicolon");
                if ($value !== $evalue) {
                    $value = $evalue;
                    return true;
                }
            }
            catch (\ParseError) {
            }
        }

        return false;
    };

    $values = array_map('trim', quoteexplode(',', $pamlstring, null, $options['escapers']));
    if ($options['trailing-comma'] && end($values) === '') {
        array_pop($values);
    }

    $result = [];
    foreach ($values as $value) {
        $key = null;
        if (!$resolve($value)) {
            $kv = array_map('trim', quoteexplode(':', $value, 2, $options['escapers']));
            if (count($kv) === 2) {
                [$key, $value] = $kv;
                $resolve($value);
            }
        }

        array_put($result, $value, $key);
    }
    return $result;
}
