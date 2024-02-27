<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * limit を主体とした array_slice
 *
 * 「配列の上から/下からN件取りたい」というユースケースがそれなりに多いが、毎回迷う上に1文で書けないので関数化した。
 *
 * $limit が負数の場合は戻って読む。
 * $offset 省略時は $limit の符号で自動で先頭か末尾になる。
 * $offset を指定することは少なく、端的に言えば「$limit が整数なら先頭から、負数なら末尾から $limit 件返す」と考えてもよい。
 * 配列を無限数直線にマッピングし、位置範囲指定で切り取るイメージ。
 * 文章で書くと複雑なので Example を参照。
 *
 * また、「array_slice しても結果が変わらないケース」でコールせずに結果を返すようにしてある。
 * （結果が変わらなくても無駄に呼ばれて速度低下があるため）。
 * 例えば `array_slice($array, 0, 0)` は必ず空配列を返すし `array_slice($array, 0, null)` は必ず元の配列を返すはず。
 * にも関わらず array_slice は愚直に切り取り処理をしているようで、その分岐の有る無しで速度がだいぶ違う。
 *
 * $preserve_keys は array_slice と同じだが、 null を渡すと「通常配列時に true, 連想配列時に false」が動的に決まるようになる。
 * ユースケースとしてはそのような使い方が多いはず。
 * あくまで null 指定の場合のみなのでこの動作が嫌なら明示的に bool を渡せばよい。
 *
 * Example:
 * ```php
 * $array = ['a', 'b', 'c', 'd', 'e'];
 *
 * that(array_limit($array, 3))->isSame(['a', 'b', 'c']);     // シンプルに先頭から3件
 * that(array_limit($array, -3))->isSame(['c', 'd', 'e']);    // シンプルに末尾から3件
 *
 * that(array_limit($array, 3, 1))->isSame(['b', 'c', 'd']);  // 1番目（'b'）から正順に3件
 * that(array_limit($array, -3, 1))->isSame(['a', 'b']);      // 1番目（'b'）から逆順に3件（足りないので結果は2件）
 *
 * that(array_limit($array, 3, 3))->isSame(['d', 'e']);       // 3番目（'d'）から正順に3件（足りないので結果は2件）
 * that(array_limit($array, -3, 3))->isSame(['b', 'c', 'd']); // 3番目（'d'）から逆順に3件
 *
 * that(array_limit($array, 3, -2))->isSame(['a']);           // -2番目（範囲外）から正順に3件（'a'だけがギリギリ範囲に入る）
 * that(array_limit($array, -3, 6))->isSame(['e']);           // 6番目（範囲外）から逆順に3件（'e'だけがギリギリ範囲に入る）
 *
 * that(array_limit($array, 3, -100))->isSame([]);            // -100番目（範囲外）から正順に3件（完全に範囲外なので空）
 * that(array_limit($array, -3, 100))->isSame([]);            // 100番目（範囲外）から逆順に3件（完全に範囲外なので空）
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param int $limit 切り詰めるサイズ
 * @param ?int $offset 開始位置
 * @param ?bool $preserve_keys キーの保存フラグ（null にすると連想配列の時のみ保存される）
 * @return array slice した配列
 */
function array_limit($array, $limit, $offset = null, $preserve_keys = null)
{
    $array = arrayval($array, false);
    $count = count($array);

    // $offset 省略時は $limit の符号に応じて最初か最後
    $offset ??= $limit >= 0 ? 0 : $count - 1;

    // 負から負方向は必ず空
    if ($offset < 0 && $limit < 0) {
        return [];
    }

    // 負数 $limit は戻る方向
    if ($limit < 0) {
        $offset += $limit + 1;
        $limit = -$limit;
    }

    // 負数 $offset は0補正
    if ($offset < 0) {
        $limit += $offset;
        $offset = 0;
    }

    // 完全に範囲外なら slice するまでもなく空
    if ($offset + $limit <= 0 || $count <= $offset) {
        return [];
    }

    // 完全に範囲一致なら slice するまでもなく元の配列
    if ($offset <= 0 && $count <= $limit) {
        return $array;
    }

    return array_slice($array, $offset, $limit, $preserve_keys ?? is_hasharray($array));
}
