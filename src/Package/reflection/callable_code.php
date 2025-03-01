<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/last_key.php';
require_once __DIR__ . '/../misc/php_parse.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * callable のコードブロックを返す
 *
 * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
 *
 * Example:
 * ```php
 * list($meta, $body) = callable_code(function (...$args) {return true;});
 * that($meta)->isSame('function (...$args)');
 * that($body)->isSame('{return true;}');
 *
 * // ReflectionFunctionAbstract を渡しても動作する
 * list($meta, $body) = callable_code(new \ReflectionFunction(function (...$args) {return true;}));
 * that($meta)->isSame('function (...$args)');
 * that($body)->isSame('{return true;}');
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable|\ReflectionFunctionAbstract $callable コードを取得する callable
 * @param bool $return_token true にすると生のトークン配列で返す
 * @return array ['定義部分', '{処理コード}']
 */
function callable_code($callable, bool $return_token = false)
{
    $ref = $callable instanceof \ReflectionFunctionAbstract ? $callable : reflect_callable($callable);
    $contents = file($ref->getFileName());
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();
    $codeblock = implode('', array_slice($contents, $start - 1, $end - $start + 1));

    $meta = php_parse("<?php $codeblock", [
        'begin' => [T_FN, T_FUNCTION],
        'end'   => ['{', T_DOUBLE_ARROW],
    ]);
    $end = array_pop($meta);

    if ($end->id === T_DOUBLE_ARROW) {
        $body = php_parse("<?php $codeblock", [
            'begin'  => T_DOUBLE_ARROW,
            'end'    => [';', ',', ')', ']'],
            'offset' => last_key($meta),
            'greedy' => true,
        ]);
        $body = array_slice($body, 1, -1);
    }
    else {
        $body = php_parse("<?php $codeblock", [
            'begin'  => '{',
            'end'    => '}',
            'offset' => last_key($meta),
        ]);
    }

    if ($return_token) {
        return [$meta, $body];
    }

    return [trim(implode('', array_column($meta, 'text'))), trim(implode('', array_column($body, 'text')))];
}
