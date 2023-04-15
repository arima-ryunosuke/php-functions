<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_map_key.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * callable を名前付き引数で呼べるようにしたクロージャを返す
 *
 * callable のデフォルト引数は適用されるが、それ以外にも $default でデフォルト値を与えることができる（部分適用のようなものだと思えば良い）。
 * 最終的な優先順位は下記。上に行くほど優先。
 *
 * 1. 呼び出し時の引数
 * 2. この関数の $default 引数
 * 3. callable のデフォルト引数
 *
 * 引数は n 番目でも引数名でもどちらでも良い。
 * n 番目の場合は引数名に依存しないが、順番に依存してしまう。
 * 引数名の場合は順番に依存しないが、引数名に依存してしまう。
 *
 * 可変引数の場合は 1 と 2 がマージされる。
 * 必須引数が渡されていない or 定義されていない引数が渡された場合は例外を投げる。
 *
 * Example:
 * ```php
 * // ベースとなる関数（引数をそのまま連想配列で返す）
 * $f = fn ($x, $a = 1, $b = 2, ...$other) => get_defined_vars();
 *
 * // x に 'X', a に 9 を与えて名前付きで呼べるクロージャ
 * $f1 = namedcallize($f, [
 *     'x' => 'X',
 *     'a' => 9,
 * ]);
 * // 引数無しで呼ぶと↑で与えた引数が使用される（b は渡されていないのでデフォルト引数の 2 が使用される）
 * that($f1())->isSame([
 *     'x'     => 'X',
 *     'a'     => 9,
 *     'b'     => 2,
 *     'other' => [],
 * ]);
 * // 引数付きで呼ぶとそれが優先される
 * that($f1([
 *     'x'     => 'XXX',
 *     'a'     => 99,
 *     'b'     => 999,
 *     'other' => [1, 2, 3],
 * ]))->isSame([
 *     'x'     => 'XXX',
 *     'a'     => 99,
 *     'b'     => 999,
 *     'other' => [1, 2, 3],
 * ]);
 * // 引数名ではなく、 n 番目指定でも同じ
 * that($f1([
 *     'x' => 'XXX',
 *     1   => 99,
 *     2   => 999,
 *     3   => [1, 2, 3],
 * ]))->isSame([
 *     'x'     => 'XXX',
 *     'a'     => 99,
 *     'b'     => 999,
 *     'other' => [1, 2, 3],
 * ]);
 *
 * // x に 'X', other に [1, 2, 3] を与えて名前付きで呼べるクロージャ
 * $f2 = namedcallize($f, [
 *     'x'     => 'X',
 *     'other' => [1, 2, 3],
 * ]);
 * // other は可変引数なのでマージされる
 * that($f2(['other' => [4, 5, 6]]))->isSame([
 *     'x'     => 'X',
 *     'a'     => 1,
 *     'b'     => 2,
 *     'other' => [1, 2, 3, 4, 5, 6],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $callable
 * @param array $defaults デフォルト引数
 * @return \Closure 名前付き引数で呼べるようにしたクロージャ
 */
function namedcallize($callable, $defaults = [])
{
    static $dummy_arg;
    $dummy_arg ??= new \stdClass();

    /** @var \ReflectionFunctionAbstract $reffunc */
    $reffunc = reflect_callable($callable);
    $refparams = $reffunc->getParameters();

    $defargs = [];
    $argnames = [];
    $variadicname = null;
    foreach ($refparams as $n => $param) {
        $pname = $param->getName();

        $argnames[$n] = $pname;

        // 可変引数は貯めておく
        if ($param->isVariadic()) {
            $variadicname = $pname;
        }

        // ユーザ指定は最優先
        if (array_key_exists($pname, $defaults)) {
            $defargs[$pname] = $defaults[$pname];
        }
        elseif (array_key_exists($n, $defaults)) {
            $defargs[$pname] = $defaults[$n];
        }
        // デフォルト引数があるならそれを
        elseif ($param->isDefaultValueAvailable()) {
            $defargs[$pname] = $param->getDefaultValue();
        }
        // それ以外なら「指定されていない」ことを表すダミー引数を入れておく（あとでチェックに使う）
        else {
            $defargs[$pname] = $param->isVariadic() ? [] : $dummy_arg;
        }
    }

    return function ($params = []) use ($reffunc, $defargs, $argnames, $variadicname, $dummy_arg) {
        $params = array_map_key($params, fn($k) => is_int($k) ? $argnames[$k] : $k);
        $params = array_replace($defargs, $params);

        // 勝手に突っ込んだ $dummy_class がいるのはおかしい。指定されていないと思われる
        if ($dummyargs = array_filter($params, fn($v) => $v === $dummy_arg)) {
            // が、php8 未満では組み込みのデフォルト値は取れないので、除外
            if (!$reffunc->isInternal()) {
                throw new \InvalidArgumentException('missing required arguments(' . implode(', ', array_keys($dummyargs)) . ').');
            }
        }
        // diff って余りが出るのはおかしい。余計なものがあると思われる
        if ($diffargs = array_diff_key($params, $defargs)) {
            throw new \InvalidArgumentException('specified undefined arguments(' . implode(', ', array_keys($diffargs)) . ').');
        }

        // 可変引数はマージする
        if ($variadicname) {
            $params = array_merge($params, $defargs[$variadicname], $params[$variadicname]);
            unset($params[$variadicname]);
        }

        if ($reffunc instanceof \ReflectionMethod && $reffunc->isConstructor()) {
            $object = $reffunc->getDeclaringClass()->newInstanceWithoutConstructor();
            $reffunc->invoke($object, ...array_values($params));
            return $object;
        }
        return $reffunc->invoke(...array_values($params));
    };
}
