<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_each.php';
require_once __DIR__ . '/../reflection/callable_code.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * $callable の本体・引数・返り値の DocComment を返す
 *
 * 下記のような配列を返す（仕様上 Example が書けない）。
 *
 * ```
 * [
 *     "" => "本体の DocComment",
 *     0  => "引数1の DocComment",
 *     1  => "引数2の DocComment",
 *     // ...他の引数
 *     -1 => "返り値の DocComment",
 * ];
 * ```
 *
 * それぞれ存在しない場合はキー自体が抜け落ちる（null で入ったりはしない）。
 * 非常に雑に実装しているので、配列や new(8.1以降)の引数に反応することがある。
 *
 * 本体の DocComment は ReflectionFunctionAbstract::getDocComment と同等である。
 * 引数の DocComment は必ず型宣言の直前（ない場合は引数名の直前）に記述しなければならない。
 * 返り値の DocComment は必ず型宣言の直前（ない場合は{の直前）に記述しなければならない。
 *
 * @package ryunosuke\Functions\Package\reflection
 */
function function_doccomments(
    /** 対象 callable */
    \ReflectionFunctionAbstract|callable $callable,
): /** 本体・引数・返り値の DocComment 配列 */ array
{
    $ref = $callable instanceof \ReflectionFunctionAbstract ? $callable : reflect_callable($callable);
    $parameters = array_each($ref->getParameters(), function (&$carry, $v) {
        $carry[$v->getName()] = $v;
    }, []);

    $result = [];
    if ($ref->getDocComment() !== false) {
        $result[''] = $ref->getDocComment();
    }

    $doccomment = null;
    $tokens = callable_code($ref, true)[0];
    foreach ($tokens as $token) {
        if ($token->is(T_DOC_COMMENT)) {
            $doccomment = $token;
        }

        if ($token->is(T_VARIABLE)) {
            $varname = substr($token->text, 1);
            if ($doccomment && isset($parameters[$varname])) {
                $result[$parameters[$varname]->getPosition()] = $doccomment->text;
            }
            $doccomment = null;
        }
        if ($token->is([T_NEW])) {
            $doccomment = null; // @codeCoverageIgnore for php8.1
        }
    }

    if ($doccomment) {
        $result[-1] = $doccomment->text;
    }

    return $result;
}
