<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
 *
 * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
 *
 * NullObject は 基本的に null を返すが、return type が規約されている場合は null 以外を返すこともある。
 * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
 * __set のような明らかに設定が意図されているものは例外が飛ぶ。
 *
 * Example:
 * ```php
 * // null を返すかもしれないステートメント
 * $getobject = fn () => null;
 * // メソッド呼び出しは null を返す
 * that(optional($getobject())->method())->isSame(null);
 * // プロパティアクセスは null を返す
 * that(optional($getobject())->property)->isSame(null);
 * // empty は true を返す
 * that(empty(optional($getobject())->nothing))->isSame(true);
 * // __isset は false を返す
 * that(isset(optional($getobject())->nothing))->isSame(false);
 * // __toString は '' を返す
 * that(strval(optional($getobject())))->isSame('');
 * // __invoke は null を返す
 * that(call_user_func(optional($getobject())))->isSame(null);
 * // 配列アクセスは null を返す
 * that(optional($getobject())['hoge'])->isSame(null);
 * // 空イテレータを返す
 * that(iterator_to_array(optional($getobject())))->isSame([]);
 *
 * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
 * that(optional(new \ArrayObject([1]), 'stdClass')->count())->is(0);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @template T
 * @param T|null $object オブジェクト
 * @param null|string|T $expected 期待するクラス名。指定した場合は is_a される
 * @return T $object がオブジェクトならそのまま返し、違うなら NullObject を返す
 */
function optional($object, $expected = null)
{
    if (is_object($object)) {
        if ($expected === null || is_a($object, $expected)) {
            return $object;
        }
    }

    static $nullobject = null;
    if ($nullobject === null) {
        $nullobject = new class implements \Countable, \ArrayAccess, \IteratorAggregate, \JsonSerializable {
            // @formatter:off
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function count(): int { return 0; }
                public function offsetExists($offset): bool { return false; }
                public function offsetGet($offset): ?string { return null; }
                public function offsetSet($offset, $value): void { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset): void { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator(): \Traversable { return new \ArrayIterator([]); }
                public function jsonSerialize(): \stdClass { return (object)[]; }
                // @formatter:on
        };
    }
    return $nullobject;
}
