<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 関数のエイリアスを作成する
 *
 * 単に移譲するだけではなく、参照渡し・参照返しも模倣される。
 * その代わり、単純なエイリアスではなく別定義で吐き出すので「エイリアス」ではなく「処理が同じな別関数」と思ったほうがよい。
 *
 * 静的であればクラスメソッドも呼べる。
 *
 * Example:
 * ```php
 * // trim のエイリアス
 * function_alias('trim', 'trim_alias');
 * that(trim_alias(' abc '))->isSame('abc');
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable $original 元となる関数
 * @param string $alias 関数のエイリアス名
 */
function function_alias($original, $alias)
{
    // クロージャとか __invoke とかは無理なので例外を投げる
    if (is_object($original)) {
        throw new \InvalidArgumentException('$original must not be object.');
    }
    // callname の取得と非静的のチェック
    is_callable($original, true, $calllname);
    $calllname = ltrim($calllname, '\\');
    $ref = reflect_callable($original);
    if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
        throw new \InvalidArgumentException("$calllname is non-static method.");
    }
    // エイリアスが既に存在している
    if (function_exists($alias)) {
        throw new \InvalidArgumentException("$alias is already declared.");
    }

    // キャッシュ指定有りなら読み込むだけで eval しない
    $cachefile = function_configure('cachedir') . '/' . rawurlencode(__FUNCTION__ . '-' . $calllname . '-' . $alias) . '.php';
    if (!file_exists($cachefile)) {
        $parts = explode('\\', ltrim($alias, '\\'));
        $reference = $ref->returnsReference() ? '&' : '';
        $funcname = $reference . array_pop($parts);
        $namespace = implode('\\', $parts);

        $params = function_parameter($ref);
        $prms = implode(', ', array_values($params));
        $args = implode(', ', array_keys($params));
        if ($ref->isInternal()) {
            $args = "array_slice([$args] + func_get_args(), 0, func_num_args())";
        }
        else {
            $args = "[$args]";
        }

        $code = <<<CODE
            namespace $namespace {
                function $funcname($prms) {
                    \$return = $reference \\$calllname(...$args);
                    return \$return;
                }
            }
            CODE;
        file_put_contents($cachefile, "<?php\n" . $code);
    }
    require_once $cachefile;
}
