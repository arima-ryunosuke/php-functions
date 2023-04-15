<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../funchand/func_user_func_array.php';
// @codeCoverageIgnoreEnd

/**
 * 指定キーの要素で array_filter する
 *
 * array_column があるなら array_where があってもいいはず。
 *
 * $column はコールバックに渡ってくる配列のキー名を渡す。null を与えると行全体が渡ってくる。
 * $callback は絞り込み条件を渡す。null を与えると true 相当の値でフィルタする。
 * つまり $column も $callback も省略した場合、実質的に array_filter と同じ動作になる。
 *
 * $column は配列を受け入れる。配列を渡した場合その値の共通項がコールバックに渡る。
 * 連想配列の場合は「キーのカラム == 値」で filter する（それぞれで AND。厳密かどうかは $callback で指定。説明が難しいので Example を参照）。
 *
 * $callback が要求するならキーも渡ってくる。
 *
 * Example:
 * ```php
 * $array = [
 *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
 *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
 *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ];
 * // 'flag' が true 相当のものだけ返す
 * that(array_where($array, 'flag'))->isSame([
 *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
 * ]);
 * // 'name' に 'h' を含むものだけ返す
 * $contain_h = fn($name) => strpos($name, 'h') !== false;
 * that(array_where($array, 'name', $contain_h))->isSame([
 *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
 * ]);
 * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
 * $equal_2 = fn($row, $key) => $key === 2;
 * that(array_where($array, null, $equal_2))->isSame([
 *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ]);
 * // $column に配列を渡すと共通項が渡ってくる
 * $idname_is_2fuga = fn($idname) => ($idname['id'] . $idname['name']) === '2fuga';
 * that(array_where($array, ['id', 'name'], $idname_is_2fuga))->isSame([
 *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
 * ]);
 * // $column に連想配列を渡すと「キーのカラム == 値」で filter する（要するに「name が piyo かつ flag が false」で filter）
 * that(array_where($array, ['name' => 'piyo', 'flag' => false]))->isSame([
 *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ]);
 * // 上記において値に配列を渡すと in_array で判定される
 * that(array_where($array, ['id' => [2, 3]]))->isSame([
 *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
 *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ]);
 * // $column の連想配列の値にはコールバックが渡せる（それぞれで AND）
 * that(array_where($array, [
 *     'id'   => fn($id) => $id >= 3,                       // id が 3 以上
 *     'name' => fn($name) => strpos($name, 'o') !== false, // name に o を含む
 * ]))->isSame([
 *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param string|array|null $column キー名
 * @param ?callable $callback 評価クロージャ
 * @return array $where が真を返した新しい配列
 */
function array_where($array, $column = null, $callback = null)
{
    if ($column instanceof \Closure) {
        $callback = $column;
        $column = null;
    }

    $is_array = is_array($column);
    if ($is_array) {
        if (is_hasharray($column)) {
            if ($callback !== null && !is_bool($callback)) {
                throw new \InvalidArgumentException('if hash array $column, $callback must be bool.');
            }
            $callbacks = array_map(function ($c) use ($callback) {
                if ($c instanceof \Closure) {
                    return $c;
                }
                if ($callback) {
                    return fn($v) => $v === $c;
                }
                else {
                    return fn($v) => is_array($c) ? in_array($v, $c) : $v == $c;
                }
            }, $column);
            $callback = function ($vv, $k, $v) use ($callbacks) {
                foreach ($callbacks as $c => $callback) {
                    if (!$callback($vv[$c], $k)) {
                        return false;
                    }
                }
                return true;
            };
        }
        else {
            $column = array_flip($column);
        }
    }

    $callback = func_user_func_array($callback);

    $result = [];
    foreach ($array as $k => $v) {
        if ($column === null) {
            $vv = $v;
        }
        elseif ($is_array) {
            $vv = array_intersect_key($v, $column);
        }
        else {
            $vv = $v[$column];
        }

        if ($callback($vv, $k, $v)) {
            $result[$k] = $v;
        }
    }
    return $result;
}
