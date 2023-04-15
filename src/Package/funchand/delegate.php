<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/evaluate.php';
require_once __DIR__ . '/../reflection/parameter_length.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * 指定 callable を指定クロージャで実行するクロージャを返す
 *
 * ほぼ内部向けで外から呼ぶことはあまり想定していない。
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
 * @param callable $callable 最終的に実行したいクロージャ
 * @param ?int $arity 引数の数
 * @return callable $callable を実行するクロージャ
 */
function delegate($invoker, $callable, $arity = null)
{
    $arity ??= parameter_length($callable, true, true);

    if (reflect_callable($callable)->isInternal()) {
        static $cache = [];
        $cache[(string) $arity] ??= evaluate('return new class()
            {
                private $invoker, $callable;

                public function spawn($invoker, $callable)
                {
                    $that = clone($this);
                    $that->invoker = $invoker;
                    $that->callable = $callable;
                    return $that;
                }

                public function __invoke(' . implode(',', is_infinite($arity)
                ? ['...$_']
                : array_map(fn($v) => '$_' . $v, array_keys(array_fill(1, $arity, null)))
            ) . ')
                {
                    return ($this->invoker)($this->callable, func_get_args());
                }
            };');
        return $cache[(string) $arity]->spawn($invoker, $callable);
    }

    switch (true) {
        case $arity === 0:
            return fn() => $invoker($callable, func_get_args());
        case $arity === 1:
            return fn($_1) => $invoker($callable, func_get_args());
        case $arity === 2:
            return fn($_1, $_2) => $invoker($callable, func_get_args());
        case $arity === 3:
            return fn($_1, $_2, $_3) => $invoker($callable, func_get_args());
        case $arity === 4:
            return fn($_1, $_2, $_3, $_4) => $invoker($callable, func_get_args());
        case $arity === 5:
            return fn($_1, $_2, $_3, $_4, $_5) => $invoker($callable, func_get_args());
        case is_infinite($arity):
            return fn(...$_) => $invoker($callable, func_get_args());
        default:
            $args = implode(',', array_map(fn($v) => '$_' . $v, array_keys(array_fill(1, $arity, null))));
            $stmt = 'return function (' . $args . ') use ($invoker, $callable) { return $invoker($callable, func_get_args()); };';
            return eval($stmt);
    }
}
