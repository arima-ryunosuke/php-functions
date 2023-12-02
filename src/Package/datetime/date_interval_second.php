<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_convert.php';
require_once __DIR__ . '/../datetime/date_interval.php';
require_once __DIR__ . '/../datetime/date_timestamp.php';
require_once __DIR__ . '/../var/is_decimal.php';
// @codeCoverageIgnoreEnd

/**
 * DateInterval を秒に変換する
 *
 * 1ヶ月の間隔は時期によって異なるため、 $basetime 次第で結果が変わることがあるので注意。
 * $interval は DateInterval だけでなく ISO8601 文字列も与えることができる。
 * その際、下記の拡張仕様がある。
 * - 先頭の正負記号（-+）を受け入れる（DateInterval->invert で表現される）
 * - 秒だけは小数表記を受け入れる（DateInterval->f で表現される。元々 ISO8601 の仕様だが DateInterval は対応していないっぽい）
 *
 * Example:
 * ```php
 * // 1分30秒は90秒
 * that(date_interval_second('PT1M30S'))->isSame(90);
 * // 負数が使える
 * that(date_interval_second('-PT1M30S'))->isSame(-90);
 * // 秒は小数が使える
 * that(date_interval_second('-PT1M30.5S'))->isSame(-90.5);
 *
 * // 1980/01/01 からの3ヶ月は 7862400 秒（うるう年なので 91 日）
 * that(date_interval_second('P3M', '1980/01/01'))->isSame(7862400);
 * // 1981/01/01 からの3ヶ月は 7776000 秒（うるう年じゃないので 90 日）
 * that(date_interval_second('P3M', '1981/01/01'))->isSame(7776000);
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param \DateInterval|string|float|int $interval DateInterval インスタンスか間隔を表す ISO8601 文字列
 * @param string|float|int $basetime 基準日時（省略時 1970/01/01 00:00:00）
 * @return float|int 秒（$interval->f を含んでいるとき float で返す）
 */
function date_interval_second($interval, $basetime = 0)
{
    if (is_decimal($interval)) {
        return $interval + 0;
    }

    if (!$interval instanceof \DateInterval) {
        $interval = date_interval($interval);
    }

    $datetime = date_convert(\DateTimeImmutable::class, $basetime);
    $difftime = $datetime->add($interval);

    return date_timestamp($difftime) - date_timestamp($datetime);
}
