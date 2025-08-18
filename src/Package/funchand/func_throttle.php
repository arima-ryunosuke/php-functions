<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * callable の実行間隔を間引いた callable を返す
 *
 * 進捗状況や SSE などで間引きたいケースはある。
 * ループ内で呼んでもいいし、tick に仕込んでもよい。
 * とにかく高頻度で呼ばれ得る状況においてコール回数を減らしたい場合に使う。
 *
 * $leading_arguments を指定するとその引数で初回にコールされる。
 * $trailing_arguments を指定するとその引数で最後にコールされる。
 * ただし $trailing_arguments はデストラクタで実装されており、実行タイミングは不確定なので注意（そもそもあまり使われる想定がない）。
 *
 * 返り値は実行可能オブジェクトであり、本来の返り値を返す。ただし間引かれた場合は null を返す。
 * よって正常系で null を返す callable では返り値は使えない。
 * なお「callable である」という前提以外は置かないこと。
 *
 * Example:
 * ```php
 * $called = 0;
 * $callback = func_throttle(function () use (&$called) { $called++; }, 0.1);
 * // こんなとんでもないループでも数回程度しか呼ばれない
 * for ($i=0; $i<3_000_000; $i++) {
 *     $callback($i);
 * }
 * that($called)->isBetween(1, 9);
 * ```
 *
 * @package ryunosuke\Functions\Package\funchand
 */
function func_throttle(
    /** 実行される callable */ callable $callback,
    /** 間引く間隔 */ float $interval,
    /** 初回実行時の引数 */ ?array $leading_arguments = null,
    /** 最後実行時の引数 */ ?array $trailing_arguments = null,
): /** 間隔が間引かれた callable */ callable
{
    return new class(\Closure::fromCallable($callback), $interval, $leading_arguments, $trailing_arguments) {
        private float $time;

        public function __construct(
            private \Closure $callback,
            private float $interval,
            private ?array $leading_arguments,
            private ?array $trailing_arguments,
        ) {
            if ($this->leading_arguments !== null) {
                ($this->callback)(...$this->leading_arguments);
            }

            $this->time = microtime(true);
        }

        public function __destruct()
        {
            if ($this->trailing_arguments !== null) {
                ($this->callback)(...$this->trailing_arguments);
            }
        }

        public function __invoke(...$arguments): mixed
        {
            $now = microtime(true);
            $elapsed = $now - $this->time;
            if ($elapsed >= $this->interval) {
                $this->time = $now;
                return ($this->callback)(...$arguments);
            }
            return null;
        }
    };
}
