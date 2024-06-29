<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * マルチバイト対応 preg_split
 *
 * preg_split の PREG_SPLIT_NO_EMPTY, PREG_SPLIT_DELIM_CAPTURE, PREG_SPLIT_OFFSET_CAPTURE も使用できる。
 *
 * Example:
 * ```php
 * # 下記のようにすべて preg_split と合わせてある
 * // limit:2
 * that(mb_ereg_split(",", "a,b,c", 2))->is(['a', 'b,c']);
 * // flags:PREG_SPLIT_NO_EMPTY
 * that(mb_ereg_split(",", ",a,,b,,c,", -1, PREG_SPLIT_NO_EMPTY))->is(['a', 'b', 'c']);
 * // flags:PREG_SPLIT_DELIM_CAPTURE
 * that(mb_ereg_split("(,)", "a,c", -1, PREG_SPLIT_DELIM_CAPTURE))->is(['a', ',', 'c']);
 * // flags:PREG_SPLIT_OFFSET_CAPTURE
 * that(mb_ereg_split(",", "a,b,c", -1, PREG_SPLIT_OFFSET_CAPTURE))->is([['a', 0], ['b', 2], ['c', 4]]);
 * # 他の preg_split 特有の動きも同じ
 * // 例えば limit は PREG_SPLIT_DELIM_CAPTURE には作用しない
 * that(mb_ereg_split("(,)", "a,b,c", 2, PREG_SPLIT_DELIM_CAPTURE))->is(['a', ',', 'b,c']);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $pattern パターン文字列
 * @param string $subject 対象文字列
 * @param int $limit 分割数
 * @param int $flags フラグ
 * @return ?array 分割された文字列
 */
function mb_ereg_split(?string $pattern, ?string $subject, $limit = -1, $flags = 0)
{
    // 是正（奇妙だが preg_split は 0, -1 以外は特別扱いしないようだ（個数が負数になることはないので実質的に 1 指定と同じ））
    if (-1 <= $limit && $limit <= 0) {
        $limit = PHP_INT_MAX;
    }

    // フラグに応じて追加するクロージャ
    $SPLIT_NO_EMPTY = !!($flags & PREG_SPLIT_NO_EMPTY);
    $SPLIT_DELIM_CAPTURE = !!($flags & PREG_SPLIT_DELIM_CAPTURE);
    $SPLIT_OFFSET_CAPTURE = !!($flags & PREG_SPLIT_OFFSET_CAPTURE);
    $result = [];
    $append = function ($part, $offset, $delim) use (&$result, $SPLIT_NO_EMPTY, $SPLIT_DELIM_CAPTURE, $SPLIT_OFFSET_CAPTURE) {
        if ($SPLIT_NO_EMPTY && !strlen($part)) {
            return false;
        }
        if (!$SPLIT_DELIM_CAPTURE && $delim) {
            return false;
        }
        if ($SPLIT_OFFSET_CAPTURE) {
            $result[] = [$part, $offset];
        }
        else {
            $result[] = $part;
        }
        return true;
    };

    // 超特別扱い（mb_ereg は空パターンを許容せず、文字境界での分割ができない。.でバラしてさらに消費しないようにする）
    $empty_pattern = !strlen($pattern);
    if ($empty_pattern) {
        $pattern = '.';
    }

    // 不正ならそこで終わり
    if (!mb_ereg_search_init($subject, $pattern)) {
        return null;
    }

    // マッチしなくなるまでループ（ただし $length を超えた場合は無駄なので break）
    $offset = 0;
    $length = 0;
    while (($pos = mb_ereg_search_pos()) !== false && $length < $limit - 1) {
        // PREG_SPLIT_NO_EMPTY は空文字をカウントしない（極論全て空文字なら最後まで読む）
        $part = substr($subject, $offset, $pos[0] - $offset);
        if ($append($part, $offset, false)) {
            $length++;
        }

        // 空パターンは区切り文字自体は計上しない
        if ($empty_pattern) {
            $offset = $pos[0];
        }
        // 空じゃなければ計上する
        else {
            $offset = $pos[0] + $pos[1];
        }

        // キャプチャパターンも入れておく
        $regs = mb_ereg_search_getregs();
        $all = array_shift($regs);
        $offset2 = $pos[0];
        foreach ($regs as $reg) {
            $append($reg, $offset2, true);
            $offset2 += strlen($reg);
        }

        // マッチしてない場合無限ループになるので強制的に進める（かなりやっつけ。もっといい方法はあるはず）
        if ($all === '') {
            for ($i = 1; $i < strlen($subject); $i++) {
                $c = substr($subject, $offset, $i);
                if ($c === '') {
                    break 2;
                }
                if (mb_ord($c) !== false && mb_ereg_search_setpos($offset + $i)) {
                    break;
                }
            }
        }
    }

    // 打ち切った場合にまだ残っていることがある
    $part = substr($subject, $offset);
    $append($part, $offset, false);

    // 空パターンの場合、境界で区切るので preg_split と合わせるため空文字が必要
    if ($empty_pattern) {
        $append("", $offset + strlen($part), false);
    }

    return $result;
}
