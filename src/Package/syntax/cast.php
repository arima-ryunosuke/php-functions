<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_typeof.php';
// @codeCoverageIgnoreEnd

/**
 * php の型変換に準じてキャストする
 *
 * 「php の型変換」とは strict_type=0 の時の暗黙の変換を指す（(type)等のキャストではない）。
 * eval で呼び出して判定するため、決して $type に外部入力を渡してはならない。
 *
 * この関数を使うシチュエーションはほぼない。
 * 呼び先のためならそれを普通に呼べば同じエラーになるし、用途が分かっているなら通常のキャストで十分。
 * 「呼び先が型宣言されていない」とか「numeric であることを担保したい」とか、限られた状況でしか使えないし使うべきではない。
 * 通常の(type)キャストが強すぎる（特に int）のため、「エラーになってくれる弱いキャスト」のようなイメージ。
 *
 * Example:
 * ```php
 * # 下記のように変換される
 * that(cast("1", 'int'))->isSame(1);
 * that(cast(1, 'string'))->isSame('1');
 * that(cast(1, 'int|string'))->isSame(1);
 * that(cast([], 'array|ArrayAccess'))->isSame([]);
 * that(cast($ao = new \ArrayObject(), 'ArrayAccess&Countable'))->isSame($ao);
 *
 * # 下記はすべて TypeError になる
 * // cast("hoge", 'int');             // 非数値文字列 は int に変換できない
 * // cast([], 'string');              // array は string に変換できない
 * // cast(new \stdClass(), 'bool');   // object は bool に変換できない
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @param mixed $value 取得される配列・オブジェクト
 * @param string $type 型文字列
 * @param mixed $default 失敗したときのデフォルト値（null も立派な値なので例外を飛ばすためには未指定時にしなければならない）
 * @return mixed キャストされた値
 */
function cast($value, string $type, $default = null)
{
    // 気休め程度だが一応チェック（呼び元の責務なのであんまり厳密にやってもしょうがない）
    if (!preg_match('#^[?\\\\_a-z0-9|&()]+$#i', $type)) {
        throw new \InvalidArgumentException("$type is illegal type");
    }

    // php8.2 の DNF の模倣（8.2 に対応したらまるっと不要）
    if (strpbrk($type, '(&)') !== false) {
        if (!is_typeof($value, $type)) {
            if (func_num_args() === 3) {
                return $default;
            }
            throw new \TypeError(sprintf("must be of type %s, %s given", $type, get_debug_type($type)));
        }
        // ↑でとりあえずマッチすることは保証されたのであとは変換のために | 繋ぎで呼び出せばよい
        $type = implode('|', preg_split('#([?()|&])#', $type, -1, PREG_SPLIT_NO_EMPTY));
    }

    // 緩い変換なので一部は互換型を追加する必要がある
    $types = array_map(fn($type) => trim(trim($type, '\\')), preg_split('#([?()|&])#', $type, -1, PREG_SPLIT_NO_EMPTY));
    if (in_array('Stringable', $types) && !in_array('string', $types)) {
        $types[] = 'string';
    }
    $type = implode('|', $types);

    // 判定・変換が複雑極まるため実際に投げてその値を返すのが最も間違いが少ない
    static $test_functions = [];
    $test_functions[$type] ??= eval("return static fn({$type} \$value) => \$value;");
    try {
        return $test_functions[$type]($value);
    }
    catch (\TypeError $e) {
        if (func_num_args() === 3) {
            return $default;
        }
        throw $e;
    }
}
