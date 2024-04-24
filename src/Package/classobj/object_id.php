<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 重複しない spl_object_id
 *
 * 内部でオブジェクト自体は保持しない。
 * つまり、そのオブジェクトは GC の対象になる。
 *
 * オブジェクトを与えると一意な整数を返す。
 * 内部で連番を保持するので PHP_INT_MAX まで生成できる。
 * PHP_INT_MAX を超えた場合の挙動は未定義（まぁまずありえないだろう）。
 * null は特別扱いとして必ず 0 を返す。
 *
 * 逆に整数を与えると対応したオブジェクトを返す。
 * 設定していないか既に GC されている場合は null を返す。
 * 0 は特別扱いとして必ず null を返す。
 *
 * Example:
 * ```php
 * // spl_object_id は容易に重複するが・・・
 * that(spl_object_id(new \stdClass()) === spl_object_id(new \stdClass()))->isTrue();
 * // この object_id 関数は重複しない
 * that(object_id(new \stdClass()) === object_id(new \stdClass()))->isFalse();
 *
 * $o = new \stdClass();
 * // オブジェクトを与えると固有IDを返す
 * that($id = object_id($o))->isInt();
 * // そのIDを与えると元のオブジェクトが得られる
 * that($o === object_id($id))->isTrue();
 * // 参照を握っているわけではないので GC されていると null を返す
 * unset($o);
 * that(null === object_id($id))->isTrue();
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param null|object|int $objectOrId 対象オブジェクト or オブジェクトID
 * @return null|int|object オブジェクトID or 対象オブジェクト
 */
function object_id($objectOrId)
{
    if (is_string($objectOrId) && ctype_digit($objectOrId)) {
        $objectOrId = (int) $objectOrId;
    }

    assert(is_null($objectOrId) || is_object($objectOrId) || is_int($objectOrId));

    if ($objectOrId === null) {
        return 0;
    }
    if ($objectOrId === 0) {
        return null;
    }

    /** @var array<\WeakReference> $idmap */
    static $idmap = [];

    if (is_int($objectOrId)) {
        if (!isset($idmap[$objectOrId])) {
            return null;
        }
        $result = $idmap[$objectOrId]->get();
        if ($result === null) {
            unset($idmap[$objectOrId]);
        }
        return $result;
    }

    static $lastid = 0;
    static $references = null;
    $references ??= new \WeakMap();

    $references[$objectOrId] ??= [\WeakReference::create($objectOrId), ++$lastid];
    $idmap[$references[$objectOrId][1]] = $references[$objectOrId][0];
    return $references[$objectOrId][1];
}
