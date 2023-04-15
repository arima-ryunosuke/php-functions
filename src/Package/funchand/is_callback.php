<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * callable のうち、関数文字列を false で返す
 *
 * 歴史的な経緯で php の callable は多岐に渡る。
 *
 * 1. 単純なコールバック: `"strtolower"`
 * 2. staticメソッドのコール: `["ClassName", "method"]`
 * 3. オブジェクトメソッドのコール: `[$object, "method"]`
 * 4. staticメソッドのコール: `"ClassName::method"`
 * 5. 相対指定によるstaticメソッドのコール: `["ClassName", "parent::method"]`
 * 6. __invoke実装オブジェクト: `$object`
 * 7. クロージャ: `fn() => something()`
 *
 * 上記のうち 1 を callable とはみなさず false を返す。
 * 現代的には `Closure::fromCallable`, `$object->method(...)` などで callable == Closure という概念が浸透しているが、そうでないこともある。
 * 本ライブラリでも `preg_splice` や `array_sprintf` などで頻出しているので関数として定義する。
 *
 * 副作用はなく、クラスのロードや関数の存在チェックなどは行わない。あくまで型と形式で判定する。
 * 引数は callable でなくても構わない。その場合単に false を返す。
 *
 * @package ryunosuke\Functions\Package\funchand
 *
 * @param mixed $callable 対象 callable
 * @return bool 関数呼び出しの callable なら false
 */
function is_callback($callable)
{
    // 大前提（不要に思えるが invoke や配列 [1, 2, 3] などを考慮すると必要）
    if (!is_callable($callable, true)) {
        return false;
    }

    // 変なオブジェクト・配列は↑で除かれている
    if (is_object($callable) || is_array($callable)) {
        return true;
    }

    // 文字列で :: を含んだら関数呼び出しではない
    if (is_string($callable) && strpos($callable, '::') !== false) {
        return true;
    }

    return false;
}
