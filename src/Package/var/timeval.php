<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * float（秒）を int[秒, マイクロ秒] に変換する
 *
 * stream_select のような(秒, マイクロ秒)を要求してくる関数があるので、ササっと呼び出したい時に使う非常にニッチな関数。
 * いわゆる timeval 構造体を返す（ただし、連想配列ではなく通常配列）。
 *
 * Example:
 * ```php
 * // 1.5 秒を 1 と 500000 に分離
 * that(timeval(1.5))->isSame([1, 500_000]);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @return int[] [秒, マイクロ秒]
 */
function timeval(float|int $seconds): array
{
    $tv_sec = (int) $seconds;
    $tv_usec = (int) (($seconds - $tv_sec) * 1000000);
    return [$tv_sec, $tv_usec];
}
