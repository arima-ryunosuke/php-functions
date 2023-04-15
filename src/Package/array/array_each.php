<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../reflection/reflect_callable.php';
// @codeCoverageIgnoreEnd

/**
 * array_reduce の参照版（のようなもの）
 *
 * 配列をループで回し、その途中経過、値、キー、連番をコールバック引数で渡して最終的な結果を返り値として返す。
 * array_reduce と少し似てるが、下記の点が異なる。
 *
 * - いわゆる $carry は返り値で表すのではなく、参照引数で表す
 * - 値だけでなくキー、連番も渡ってくる
 * - 巨大配列の場合でも速度劣化が少ない（array_reduce に巨大配列を渡すと実用にならないレベルで遅くなる）
 *
 * $callback の引数は `($value, $key, $n)` （$n はキーとは関係がない 0 ～ 要素数-1 の通し連番）。
 *
 * 返り値ではなく参照引数なので return する必要はない（ワンライナーが書きやすくなる）。
 * 返り値が空くのでループ制御に用いる。
 * 今のところ $callback が false を返すとそこで break するのみ。
 *
 * 第3引数を省略した場合、**クロージャの第1引数のデフォルト値が使われる**。
 * これは特筆すべき動作で、不格好な第3引数を完全に省略することができる（サンプルコードを参照）。
 * ただし「php の文法違反（今のところエラーにはならないし、全てにデフォルト値をつければ一応回避可能）」「リフレクションを使う（ほんの少し遅くなる）」などの弊害が有るので推奨はしない。
 * （ただ、「意図していることをコードで表す」といった観点ではこの記法の方が正しいとも思う）。
 *
 * Example:
 * ```php
 * // 全要素を文字列的に足し合わせる
 * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) {$carry .= $v;}, ''))->isSame('12345');
 * // 値をキーにして要素を2乗値にする
 * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) {$carry[$v] = $v * $v;}, []))->isSame([
 *     1 => 1,
 *     2 => 4,
 *     3 => 9,
 *     4 => 16,
 *     5 => 25,
 * ]);
 * // 上記と同じ。ただし、3 で break する
 * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v, $k){
 *     if ($k === 3) return false;
 *     $carry[$v] = $v * $v;
 * }, []))->isSame([
 *     1 => 1,
 *     2 => 4,
 *     3 => 9,
 * ]);
 *
 * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
 * that(array_each([1, 2, 3], function (&$carry = [], $v = null) {
 *         $carry[$v] = $v * $v;
 *     }))->isSame(array_each([1, 2, 3], function (&$carry, $v) {
 *         $carry[$v] = $v * $v;
 *     }, [])
 *     // 個人的に↑のようなぶら下がり引数があまり好きではない（クロージャを最後の引数にしたい）
 * );
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param callable $callback 評価クロージャ。(&$carry, $key, $value) を受ける
 * @param mixed $default ループの最初や空の場合に適用される値
 * @return mixed each した結果
 */
function array_each($array, $callback, $default = null)
{
    if (func_num_args() === 2) {
        /** @var \ReflectionFunction $ref */
        $ref = reflect_callable($callback);
        $params = $ref->getParameters();
        if ($params[0]->isDefaultValueAvailable()) {
            $default = $params[0]->getDefaultValue();
        }
    }

    $n = 0;
    foreach ($array as $k => $v) {
        $return = $callback($default, $v, $k, $n++);
        if ($return === false) {
            break;
        }
    }
    return $default;
}
