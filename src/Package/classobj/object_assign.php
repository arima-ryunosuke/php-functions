<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * オブジェクトのプロパティを完全コピーする
 *
 * private/protected/public もすべて含める。
 * 言い換えれば「serialize/get_mangled_object_vars の結果が同じになるようにコピー」する。
 *
 * 用途はかなり限定的で、大抵のケースでは clone で事足りる。
 * この関数は言うなれば「既にオブジェクトが出来上がっている状態で clone 的なことがしたい」に近い。
 *
 * 未初期化プロパティはコピーしない（できない）。
 * readonly はいかなる手段でも書き換えられないので、現状はスルーする。
 * もちろん static も対象外。
 *
 * なお、シグネチャは js の Object.assign に意図的に似せてある。
 * ただし、sources は target の下位互換であるような型でなければならない。
 * 型が異なると例外を投げる。
 *
 * Example:
 * ```php
 * # 事前クラス定義はしんどいので組み込みの Exception による簡易的な例
 * $source = new \Exception('message', 123);
 * $target = new \Exception('');
 *
 * // $target を返し、その全プロパティは $source のもので上書きされている
 * $target = object_assign($target, $source);
 *
 * // この辺は分かりやすい
 * that($target->getMessage())->is($source->getMessage());
 * that($target->getCode())->is($source->getCode());
 * // この辺も同じになっている
 * that($target->getFile())->is($source->getFile());
 * that($target->getLine())->is($source->getLine());
 * // もっと端的に言えば serialize 表現が完全一致する
 * that(serialize($target))->is(serialize($source));
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @template T of object
 * @param T $target コピー先オブジェクト
 * @param T ...$sources コピー元オブジェクト
 * @return T $target
 */
function object_assign(object $target, object ...$sources): object
{
    for ($ref = new \ReflectionClass($target); $ref !== false; $ref = $ref->getParentClass()) {
        foreach ($sources as $source) {
            foreach ($ref->getProperties() as $property) {
                $property->setAccessible(true);
                if (!$property->isStatic() && $property->isInitialized($source) && !(method_exists($property, 'isReadOnly') && $property->isReadOnly())) {
                    $property->setValue($target, $property->getValue($source));
                }
            }
        }
    }

    return $target;
}
