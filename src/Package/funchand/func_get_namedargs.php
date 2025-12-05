<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 呼び出し元の名前付き引数を返す
 *
 * 意外にも標準関数には存在しないし、get_defined_vars が近いが、使う場所や use 等で事故りやすい。
 * この関数を使うと本当の名前付き引数を得ることができる。
 * ただし、debug_backtrace + Reflection を使用しているので get_defined_vars に比べて猛烈に遅いことに注意。
 *
 * また、クロージャの直接呼出しは対応していない（call_user_func や $c->__invoke 等で呼び出す必要がある）。
 * 呼び元に依存する上、かなりややこしいことになるが言語仕様上不可能なのでしょうがない。
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param bool $variadic_folding 可変引数を1つにまとめるか
 * @param bool $default_contain デフォルト引数を含めるか
 * @return array 名前付き引数
 */
function func_get_namedargs(bool $variadic_folding = false, bool $default_contain = false): array
{
    $traces = debug_backtrace(limit: 3);
    $argsuments = $traces[1]['args'];

    $ref = (function () use ($traces) {
        $trace = $traces[1];
        if (!str_ends_with($trace['function'], '{closure}')) {
            return isset($trace['class']) ? new \ReflectionMethod($trace['class'], $trace['function']) : new \ReflectionFunction($trace['function']);
        }

        $trace = $traces[2];
        if (!isset($trace['class'])) {
            $closures = array_filter($trace['args'] ?? [], fn($v) => $v instanceof \Closure);
            if (count($closures) === 1) {
                return new \ReflectionFunction(reset($closures));
            }
        }
        elseif ($trace['class'] === \Closure::class) {
            return new \ReflectionFunction($trace['object']);
        }
        elseif ($trace['class'] === \ReflectionFunction::class) {
            return new \ReflectionFunction($trace['object']->getClosure());
        }
        throw new \DomainException("can't detect named argument at {$trace['function']}");
    })();

    $n = 0;
    $parameters = [];
    foreach ($ref->getParameters() as $param) {
        $pos = $param->getPosition();
        $nam = $param->getName();

        if ($param->isVariadic()) {
            $restargs = array_slice($argsuments, $n, null, true);
            if ($variadic_folding) {
                $parameters[$nam] = $restargs;
            }
            else {
                $parameters = array_replace($parameters, $restargs);
            }
        }
        elseif (array_key_exists($pos, $argsuments)) {
            $n++;
            if ($default_contain || !($param->isDefaultValueAvailable() && $argsuments[$pos] === $param->getDefaultValue())) {
                $parameters[$nam] = $argsuments[$pos];
            }
        }
        else {
            if ($default_contain) {
                $parameters[$nam] = $param->getDefaultValue();
            }
        }
    }
    return $parameters;
}
