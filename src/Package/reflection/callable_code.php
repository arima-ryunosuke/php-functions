<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
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
    if ($ref->getFileName() === false) {
        $reference = $ref->returnsReference() ? '&' : '';
        $return = reflect_type_resolve($ref->getReturnType()) ?? 'void';
        $params = function_parameter($ref);
        $keys = implode(', ', array_map(fn($v) => ltrim($v, '&'), array_keys($params)));
        $vals = implode(', ', $params);
        return ["fn$reference($vals): $return", "\\$ref->name($keys)"];
    }

    $contents = file($ref->getFileName());
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();
    $codeblock = implode('', array_slice($contents, $start - 1, $end - $start + 1));

    $tokens = php_tokens("<?php $codeblock");

    $begin = $tokens[0]->next([T_FUNCTION, T_FN]);
    $close = $begin->next(['{', T_DOUBLE_ARROW, '[']);
    if ($close->is('[')) {
        $close = $close->end()->next(['{', T_DOUBLE_ARROW]);
    }

    if ($begin->is(T_FN)) {
        $meta = array_slice($tokens, $begin->index, $close->prev()->index - $begin->index + 1);
        $temp = $close->find([';', ',', T_CLOSE_TAG]);
        // アロー関数は終了トークンが明確ではない
        // - $x = fn() => 123;         // セミコロン
        // - $x = fn() => [123];       // セミコロンであって ] ではない
        // - $x = [fn() => 123, null]; // こうだとカンマになるし
        // - $x = [fn() => 123];       // こうだと ] になる
        // しっかり実装できなくもないが、（多分）戻り読みが必要なのでここでは構文チェックをパスするまでループする実装とした
        while ($temp) {
            $test = array_slice($tokens, $close->next()->index, $temp->index - $close->next()->index);
            $text = implode('', array_column($test, 'text'));
            try {
                /** @noinspection PhpExpressionResultUnusedInspection */
                token_get_all("<?php $text;", TOKEN_PARSE);
                break;
            }
            catch (\Throwable) {
                $temp = $temp->prev();
            }
        }
        $body = array_slice($tokens, $close->next()->index, $temp ? $temp->index - $close->next()->index : null);
    }
    else {
        $meta = array_slice($tokens, $begin->index, $close->index - $begin->index);
        $body = $close->end();
        $body = array_slice($tokens, $close->index, $body->index - $close->index + 1);
    }

    if ($return_token) {
        return [$meta, $body];
    }

    return [trim(implode('', array_column($meta, 'text'))), trim(implode('', array_column($body, 'text')))];
}
