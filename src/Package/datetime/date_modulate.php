<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_interval.php';
require_once __DIR__ . '/../datetime/date_parse_format.php';
// @codeCoverageIgnoreEnd

/**
 * 日時を加減算する
 *
 * フォーマットを維持しつつ日時文字列の最小単位でよしなに加算する。
 * 具体的には Example を参照。
 *
 * Example:
 * ```php
 * // 年加算
 * that(date_modulate('2014', 1))->isSame('2015');
 * // 月加算
 * that(date_modulate('2014/12', 1))->isSame('2015/01');
 * // 日加算
 * that(date_modulate('2014/12/24', 1))->isSame('2014/12/25');
 * // 時加算
 * that(date_modulate('2014/12/24 12', 1))->isSame('2014/12/24 13');
 * // 分加算
 * that(date_modulate('2014/12/24 12:34', 1))->isSame('2014/12/24 12:35');
 * // 秒加算
 * that(date_modulate('2014/12/24 12:34:56', 1))->isSame('2014/12/24 12:34:57');
 * // ミリ秒加算
 * that(date_modulate('2014/12/24 12:34:56.789', 1))->isSame('2014/12/24 12:34:56.790');
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string $datetimedata 日時文字列
 * @param int|string|\DateInterval $modify 加減算値
 * @return string 加算された日時文字列
 */
function date_modulate($datetimedata, $modify)
{
    $format = date_parse_format($datetimedata, $parseinfo);
    if ($format === null) {
        throw new \UnexpectedValueException("failed parse date format ($datetimedata)");
    }

    if (is_string($modify) && !ctype_digit(ltrim($modify, '+-'))) {
        $modify = date_interval($modify);
    }

    $dt = new \DateTime();
    $dt->setDate($parseinfo['Y'] ?? 1, $parseinfo['M'] ?? 1, $parseinfo['D'] ?? 1);
    $dt->setTime($parseinfo['h'] ?? 0, $parseinfo['m'] ?? 0, $parseinfo['s'] ?? 0, ($parseinfo['f'] ?? 0) * 1000);
    if ($modify instanceof \DateInterval) {
        $dt->add($modify);
    }
    else {
        $unitmap = [
            'Y' => 'year',
            'M' => 'month',
            'D' => 'day',
            'h' => 'hour',
            'm' => 'minute',
            's' => 'second',
            'f' => 'millisecond',
        ];
        $unit = $unitmap[array_key_last(array_filter($unitmap, fn($key) => $parseinfo[$key] !== null, ARRAY_FILTER_USE_KEY))];
        $dt->modify("$modify $unit");
    }
    return $dt->format($format);
}
