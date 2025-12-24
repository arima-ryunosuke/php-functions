<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * Countable#count, Serializable#serialize などの「ネイティブ由来かメソッド由来か」を判定して返す
 *
 * Countable#count, Serializable#serialize のように「インターフェースのメソッド名」と「ネイティブ関数名」が一致している必要がある。
 *
 * Example:
 * ```php
 * class CountClass implements \Countable
 * {
 *     public function count(): int {
 *         // count 経由なら 1 を、メソッド経由なら 0 を返す
 *         return (int) by_builtin($this, 'count');
 *     }
 * }
 * $counter = new CountClass();
 * that(count($counter))->isSame(1);
 * that($counter->count())->isSame(0);
 * ```
 *
 * のように判定できる。
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param object|string $class
 * @param string $function
 * @return bool ネイティブなら true
 */
function by_builtin($class, $function)
{
    $class = is_object($class) ? get_class($class) : $class;

    // 特殊な方法でコールされる名前達(コールスタックの大文字小文字は正規化されるので気にする必要はない)
    $invoker = [
        'call_user_func'       => true,
        'call_user_func_array' => true,
        'invoke'               => true,
        'invokeArgs'           => true,
    ];

    $traces = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3));
    foreach ($traces as $trace) {
        if (isset($trace['class'], $trace['function']) && $trace['class'] === $class && $trace['function'] === $function) {
            // for $object->func()
            if (isset($trace['file'], $trace['line'])) {
                return false;
            }
            // for call_user_func([$object, 'func']), (new ReflectionMethod($object, 'func'))->invoke($object)
            elseif (isset($last['function']) && isset($invoker[$last['function']])) {
                return false;
            }
            // for func($object)
            elseif (isset($last['function']) && $last['function'] === $function) {
                return true;
            }
        }
        $last = $trace;
    }
    throw new \RuntimeException('failed to search backtrace.');
}
