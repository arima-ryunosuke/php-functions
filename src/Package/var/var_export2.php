<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_all.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../classobj/get_object_properties.php';
require_once __DIR__ . '/../var/is_primitive.php';
// @codeCoverageIgnoreEnd

/**
 * 組み込みの var_export をいい感じにしたもの
 *
 * 下記の点が異なる。
 *
 * - 配列は 5.4 以降のショートシンタックス（[]）で出力
 * - インデントは 4 固定
 * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
 * - 文字列はダブルクオート
 * - null は null（小文字）
 * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
 * - 配列の再帰構造の出力が異なる（Example参照）
 *
 * Example:
 * ```php
 * // 単純なエクスポート
 * that(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true))->isSame('[
 *     "array" => [1, 2, 3],
 *     "hash"  => [
 *         "a" => "A",
 *         "b" => "B",
 *         "c" => "C",
 *     ],
 * ]');
 * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
 * $rarray = [];
 * $rarray['a']['b']['c'] = &$rarray;
 * $robject = new \stdClass();
 * $robject->a = new \stdClass();
 * $robject->a->b = new \stdClass();
 * $robject->a->b->c = $robject;
 * that(var_export2(compact('rarray', 'robject'), true))->isSame('[
 *     "rarray"  => [
 *         "a" => [
 *             "b" => [
 *                 "c" => "*RECURSION*",
 *             ],
 *         ],
 *     ],
 *     "robject" => (object) [
 *         "a" => (object) [
 *             "b" => (object) [
 *                 "c" => "*RECURSION*",
 *             ],
 *         ],
 *     ],
 * ]');
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $value 出力する値
 * @param bool $return 返すなら true 出すなら false
 * @return string|null $return=true の場合は出力せず結果を返す
 */
function var_export2($value, $return = false)
{
    // インデントの空白数
    $INDENT = 4;

    // 再帰用クロージャ
    $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT) {
        // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
        foreach ($parents as $parent) {
            if ($parent === $value) {
                return $export('*RECURSION*');
            }
        }
        // 配列は連想判定したり再帰したり色々
        if (is_array($value)) {
            $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
            $spacer2 = str_repeat(' ', $nest * $INDENT);

            $hashed = is_hasharray($value);

            // スカラー値のみで構成されているならシンプルな再帰
            if (!$hashed && array_all($value, fn(...$args) => is_primitive(...$args))) {
                return '[' . implode(', ', array_map($export, $value)) . ']';
            }

            // 連想配列はキーを含めて桁あわせ
            if ($hashed) {
                $keys = array_map($export, array_combine($keys = array_keys($value), $keys));
                $maxlen = max(array_map('strlen', $keys));
            }
            $kvl = '';
            $parents[] = $value;
            foreach ($value as $k => $v) {
                $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                $kvl .= $spacer1 . $keystr . $export($v, $nest + 1, $parents) . ",\n";
            }
            return "[\n{$kvl}{$spacer2}]";
        }
        // オブジェクトは単にプロパティを __set_state する文字列を出力する
        elseif (is_object($value)) {
            $parents[] = $value;
            $classname = get_class($value);
            if ($classname === \stdClass::class) {
                return '(object) ' . $export((array) $value, $nest, $parents);
            }
            return $classname . '::__set_state(' . $export(get_object_properties($value), $nest, $parents) . ')';
        }
        // 文字列はダブルクオート
        elseif (is_string($value)) {
            return '"' . addcslashes($value, "\$\"\0\\") . '"';
        }
        // null は小文字で居て欲しい
        elseif (is_null($value)) {
            return 'null';
        }
        // それ以外は標準に従う
        else {
            return var_export($value, true);
        }
    };

    // 結果を返したり出力したり
    $result = $export($value);
    if ($return) {
        return $result;
    }
    echo $result, "\n";
}
