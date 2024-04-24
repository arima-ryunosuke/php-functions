<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/parameter_length.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
 *
 * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
 *
 * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
 *
 * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
 *
 * Example:
 * ```php
 * // strlen に2つの引数を渡してもエラーにならない
 * $strlen = func_user_func_array('strlen');
 * that($strlen('abc', null))->isSame(3);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param callable|null $callback 呼び出すクロージャ
 * @return callable 引数ぴったりで呼び出すクロージャ
 */
function func_user_func_array($callback)
{
    // null は第1引数を返す特殊仕様
    if ($callback === null) {
        return fn($v) => $v;
    }
    // クロージャはユーザ定義しかありえないので調べる必要がない
    if ($callback instanceof \Closure) {
        // と思ったが、\Closure::fromCallable で作成されたクロージャは内部属性が伝播されるようなので除外
        if (reflect_callable($callback)->isUserDefined()) {
            return $callback;
        }
    }

    // 上記以外は「引数ぴったりで削ぎ落としてコールするクロージャ」を返す
    $plength = parameter_length($callback, true, true);
    return function (...$args) use ($callback, $plength) {
        if (is_infinite($plength)) {
            return $callback(...$args);
        }
        return $callback(...array_slice($args, 0, $plength));
    };
}
