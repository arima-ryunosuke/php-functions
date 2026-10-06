<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find_first.php';
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../reflection/function_parameter.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../reflection/reflect_type_resolve.php';
// @codeCoverageIgnoreEnd

/**
 * callable のコードブロックを返す
 *
 * 返り値は3値の配列。0番目の要素が定義部、1番目の要素が処理部、2番目の要素が属性の配列を表す。
 *
 * Example:
 * ```php
 * list($meta, $body, $attrs) = callable_code(#[Attr1]#[Attr2]function (...$args) {return true;});
 * that($meta)->isSame('function (...$args)');
 * that($body)->isSame('{return true;}');
 * that($attrs)->isSame(['#[Attr1]', '#[Attr2]']);
 *
 * // ReflectionFunctionAbstract を渡しても動作する
 * list($meta, $body, $attrs) = callable_code(new \ReflectionFunction(#[Attr1]#[Attr2]function (...$args) {return true;}));
 * that($meta)->isSame('function (...$args)');
 * that($body)->isSame('{return true;}');
 * that($attrs)->isSame(['#[Attr1]', '#[Attr2]']);
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
        $static = $ref->isStatic() ? 'static ' : '';
        $reference = $ref->returnsReference() ? '&' : '';
        $return = reflect_type_resolve($ref->getReturnType()) ?? 'void';
        $params = function_parameter($ref);
        $keys = implode(', ', array_map(fn($v) => ltrim($v, '&'), array_keys($params)));
        $vals = implode(', ', $params);
        return ["{$static}fn$reference($vals): $return", "\\$ref->name($keys)", []];
    }

    // リフレクションの getStartLine で得られるのは function/fn の始まりであり、属性はその前に配置されている可能性があるので全体をパースせざるを得ない
    $tokens = php_tokens(file_get_contents($ref->getFileName()));
    $first = array_find_first($tokens, function ($token) use ($ref) {
        if ($token->line === $ref->getStartLine() && ($token->is([T_FUNCTION, T_FN]))) {
            return $token;
        }
    }, false);

    // メソッドは修飾子があり単純ではないので分岐
    if ($ref instanceof \ReflectionMethod) {
        // function method(){} という修飾子なしが許容されている以上、キーワードでの検索は不可能で、「前の終わり」でやるしかない
        $prev = $first->prev(['{', '}', ';']);
        $first = $prev->next([T_FUNCTION, T_FINAL, T_ABSTRACT, T_STATIC, T_PRIVATE, T_PROTECTED, T_PUBLIC]);
    }
    else {
        // static は直前のみ可
        $static = $first->prev()->is(T_STATIC);
        if ($static) {
            $first = $first->prev();
        }
    }

    // 属性は直前のみ
    $attrs = [];
    $attr_end = $first->prev();
    while ($attr_end->is(']')) {
        $attr_begin = $attr_end->prev(T_ATTRIBUTE);
        $attrs[] = array_slice($tokens, $attr_begin->index, $attr_end->index - $attr_begin->index + 1);
        $attr_end = $attr_begin->prev();
    }
    $attrs = array_reverse($attrs);
    assert(count($ref->getAttributes()) === count($attrs), "The function/fn line does not match the attribute line");

    $begin = $first;
    $close = $begin->next(['{', T_DOUBLE_ARROW, '[']);
    if ($close->is('[')) {
        $close = $close->end()->next(['{', T_DOUBLE_ARROW]);
    }

    if ($begin->is([T_FN]) || $begin->next()->is(T_FN)) {
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
        return [$meta, $body, $attrs];
    }

    return [
        trim(implode('', array_column($meta, 'text'))),
        trim(implode('', array_column($body, 'text'))),
        array_map(fn($attr) => trim(implode('', array_column($attr, 'text'))), $attrs),
    ];
}
