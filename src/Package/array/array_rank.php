<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * 配列をランク付けしてその順番でN件返す
 *
 * 同ランクはすべて返す。
 * つまり $length=10 でも10件以上を返すこともある。
 *
 * $length が負数の場合、降順ソートして後ろから取り出す。
 * 端的に言えば
 *
 * - 正数: 下位N件
 * - 負数: 上位N件
 *
 * という動作になる。
 *
 * ソートの型は最初の要素で決まる。
 * 文字列なら SORT_STRING で、違うなら SORT_NUMERIC
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param iterable $array 対象配列
 * @param int $length 取り出す件数
 * @param ?callable $rankfunction ランク付けクロージャ
 * @return array 上位N件の配列
 */
function array_rank($array, $length, $rankfunction = null)
{
    $array = arrayval($array, false);

    $ranks = $array;
    if ($rankfunction !== null) {
        $n = 0;
        foreach ($ranks as $k => $v) {
            $ranks[$k] = $rankfunction($v, $k, $n++);
        }
    }

    $type = null;
    $buckets = [];
    foreach ($ranks as $k => $v) {
        if (!isset($type)) {
            $type = gettype($v);
        }
        $buckets[(string) $v][$k] = $array[$k];
    }

    if ($length < 0) {
        $length = -$length;
        krsort($buckets, $type === 'string' ? SORT_STRING : SORT_NUMERIC);
    }
    else {
        ksort($buckets, $type === 'string' ? SORT_STRING : SORT_NUMERIC);
    }

    $result = [];
    foreach ($buckets as $bucket) {
        if (count($result) >= $length) {
            break;
        }
        foreach ($bucket as $k => $v) {
            $result[$k] = $v;
        }
    }
    return $result;
}
