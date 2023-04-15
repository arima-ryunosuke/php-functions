<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 値の型を取得する（gettype + get_class）
 *
 * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
 * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
 * また、 $valid_name を true にするとタイプヒントとして正当な名前を返す（integer -> int, double -> float など）。
 * 互換性のためデフォルト false になっているが、将来的にこの引数は削除されるかデフォルト true に変更される。
 *
 * 無名クラスの場合は extends, implements の優先順位でその名前を使う。
 * 継承も実装もされていない場合は標準の get_class の結果を返す。
 *
 * Example:
 * ```php
 * // プリミティブ型は gettype と同義
 * that(var_type(false))->isSame('boolean');
 * that(var_type(123))->isSame('integer');
 * that(var_type(3.14))->isSame('double');
 * that(var_type([1, 2, 3]))->isSame('array');
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
 * @param bool $valid_name タイプヒントとして有効な名前を返すか
 * @return string 型名
 */
function var_type($var, $valid_name = false)
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
    $type = gettype($var);
    if (!$valid_name) {
        return $type;
    }
    switch ($type) {
        default:
            return $type;
        case 'NULL':
            return 'null';
        case 'boolean':
            return 'bool';
        case 'integer':
            return 'int';
        case 'double':
            return 'float';
    }
}
