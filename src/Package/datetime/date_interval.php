<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ISO8601継続時間文字列を DateInterval に変換する
 *
 * 各要素には負数を与えることができる。
 * 秒にはミリ秒を与えることもできる。
 *
 * Example:
 * ```php
 * // 普通のISO8601継続時間
 * that(date_interval('P1Y2M3DT4H5M6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.0');
 * // 負数が使える
 * that(date_interval('P1Y2M3DT4H5M-6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:-6.0');
 * // ミリ秒が使える
 * that(date_interval('P1Y2M3DT4H5M6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.788999');
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string $interval ISO8601継続時間文字列か相対表記
 * @return \DateInterval DateInterval オブジェクト
 */
function date_interval($interval)
{
    if (preg_match('#^(?P<S>[\-+])?P((?P<Y>-?\d+)Y)?((?P<M>-?\d+)M)?((?P<D>-?\d+)D)?(T((?P<h>-?\d+)H)?((?P<m>-?\d+)M)?((?P<s>-?\d+(\.\d+)?)S)?)?$#', $interval, $matches, PREG_UNMATCHED_AS_NULL)) {
        $interval = new \DateInterval('P0Y');
        $interval->y = (int) $matches['Y'];
        $interval->m = (int) $matches['M'];
        $interval->d = (int) $matches['D'];
        $interval->h = (int) $matches['h'];
        $interval->i = (int) $matches['m'];
        $interval->s = (int) $matches['s'];
        $interval->f = (float) $matches['s'] - $interval->s;

        if ($matches['S'] === '-') {
            $interval->y = -$interval->y;
            $interval->m = -$interval->m;
            $interval->d = -$interval->d;
            $interval->h = -$interval->h;
            $interval->i = -$interval->i;
            $interval->s = -$interval->s;
            $interval->f = -$interval->f;
        }
    }
    else {
        $parsed = date_parse($interval);
        if ($parsed['errors'] || !$parsed['relative']) {
            throw new \InvalidArgumentException("$interval is invalid DateInterval string");
        }
        $interval = new \DateInterval('P0Y');
        $interval->y = $parsed['relative']['year'];
        $interval->m = $parsed['relative']['month'];
        $interval->d = $parsed['relative']['day'];
        $interval->h = $parsed['relative']['hour'];
        $interval->i = $parsed['relative']['minute'];
        $interval->s = $parsed['relative']['second'];
    }

    $now = new \DateTimeImmutable();
    if ($now > $now->add($interval)) {
        $interval->invert = 1;
        $interval->y = -$interval->y;
        $interval->m = -$interval->m;
        $interval->d = -$interval->d;
        $interval->h = -$interval->h;
        $interval->i = -$interval->i;
        $interval->s = -$interval->s;
        $interval->f = -$interval->f;
    }
    return $interval;
}
