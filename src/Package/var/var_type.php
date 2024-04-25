<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 値の型を取得する
 *
 * get_debug_type を少しだけ特殊化したもの。
 * 「デバッグ用の型」ではなく「コード化したときに埋め込みやすい型」が主目的。
 *
 * - object の場合は必ず \ が付く
 * - resource の場合はカッコ書き無しで 'resource'
 *
 * 無名クラスの場合は extends, implements の優先順位でその名前を使う。
 * 継承も実装もされていない場合は標準の get_class の結果を返す。
 *
 * Example:
 * ```php
 * // プリミティブ型は get_debug_type と同義
 * that(var_type(false))->isSame('bool');
 * that(var_type(123))->isSame('int');
 * that(var_type(3.14))->isSame('float');
 * that(var_type([1, 2, 3]))->isSame('array');
 * // リソースはなんでも resource
 * that(var_type(STDOUT))->isSame('resource');
 * // オブジェクトは型名を返す
 * that(var_type(new \stdClass))->isSame('\\stdClass');
 * that(var_type(new \Exception()))->isSame('\\Exception');
 * // 無名クラスは継承元の型名を返す（インターフェース実装だけのときはインターフェース名）
 * that(var_type(new class extends \Exception{}))->isSame('\\Exception');
 * that(var_type(new class implements \JsonSerializable{
 *     public function jsonSerialize(): string { return ''; }
 * }))->isSame('\\JsonSerializable');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $var 型を取得する値
 * @return string 型名
 */
function var_type($var)
{
    if (is_object($var)) {
        $ref = new \ReflectionObject($var);
        if ($ref->isAnonymous()) {
            if ($pc = $ref->getParentClass()) {
                return '\\' . $pc->name;
            }
            if ($is = $ref->getInterfaceNames()) {
                return '\\' . reset($is);
            }
        }
        return '\\' . get_class($var);
    }
    if (is_resourcable($var)) {
        return 'resource';
    }

    return get_debug_type($var);
}
