<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 自身が死ぬときに指定 callable を呼ぶオブジェクトを返す
 *
 * invoke を実装しているので明示的にも呼べる。
 * 明示的だろうと暗黙的だろうと必ず1回しか呼ばれない。
 *
 * Example:
 * ```php
 * $called = 0;
 * $finalizer = finalize(function()use(&$called){$called++;});
 * that($called)->is(0); // まだ呼ばれていない
 *
 * // コールすると・・・
 * $finalizer();
 * that($called)->is(1); // 呼ばれている
 *
 * // unset（GC）でも呼ばれる
 * unset($finalizer);
 * that($called)->is(1); // が、一度しか呼ばれないので呼ばれない
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param callable $finalizer 実行する php コード
 * @return callable GC 時に $finalizer を実行する callable
 */
function finalize(callable $finalizer)
{
    return new class($finalizer) {
        public function __construct(private $finalizer) { }

        public function __destruct() { $this->__invoke(); }

        public function __invoke()
        {
            if (isset($this->finalizer)) {
                ($this->finalizer)();
                unset($this->finalizer);
                gc_collect_cycles();
            }
        }
    };
}
