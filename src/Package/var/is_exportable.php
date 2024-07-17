<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_recursive.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 値が var_export で出力可能か検査する
 *
 * 「出力可能」とは「意味のある出力」を意味する。
 * 例えば set_state のないオブジェクトはエラーなく set_state コール形式で出力されるが意味のある出力ではない。
 * リソース型はエラーなく NULL で出力されるが意味のある出力ではない。
 * 循環参照は出力できるものの warning が出てかつ循環は切れるため意味のある出力ではない。
 *
 * Example:
 * ```php
 * that(is_primitive(null))->isTrue();
 * that(is_primitive(false))->isTrue();
 * that(is_primitive(123))->isTrue();
 * that(is_primitive(STDIN))->isTrue();
 * that(is_primitive(new \stdClass))->isFalse();
 * that(is_primitive(['array']))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 調べる値
 * @return bool 出力可能なら true
 */
function is_exportable($var): bool
{
    // スカラー/NULL は OK
    if (is_scalar($var) || is_null($var)) {
        return true;
    }

    // リソース型の変数は、この関数ではエクスポートする事ができません
    if (is_resourcable($var)) {
        return false;
    }

    // var_export() では循環参照を扱うことができません
    if (is_recursive($var)) {
        return false;
    }

    // 配列に制限はない。それゆえに全要素を再帰的に見なければならない
    if (is_array($var)) {
        foreach ($var as $v) {
            if (!is_exportable($v)) {
                return false;
            }
        }
        return true;
    }

    if (is_object($var)) {
        // 無名クラスは非常に特殊で、出力は class@anonymous{filename}:123$456::__set_state(...) のようになる
        // set_state さえ実装してれば復元可能に思えるが php コードとして不正なのでそのまま実行するとシンタックスエラーになる
        // 'class@anonymous{filename}:123$456'::__set_state(...) のようにクオートすれば実行可能になるが、それは標準 var_export の動作ではない
        // 復元する側がクオートして読み込み…とすれば復元可能だが、そもそもクラスがロードされている保証もない
        // これらのことを考慮するなら「意味のある出力」ではないとみなした方が手っ取り早い
        if ((new \ReflectionClass($var))->isAnonymous()) {
            return false;
        }
        // var_export() が生成する PHP を評価できるようにするためには、処理対象のすべてのオブジェクトがマジックメソッド __set_state を実装している必要があります
        if (method_exists($var, '__set_state')) {
            return true;
        }
        // これの唯一の例外は stdClass です。 stdClass は、配列をオブジェクトにキャストした形でエクスポートされます
        if (get_class($var) === \stdClass::class) {
            return true;
        }
        // マニュアルに記載はないが enum は export できる
        if ($var instanceof \UnitEnum) {
            return true;
        }
        return false;
    }
}
