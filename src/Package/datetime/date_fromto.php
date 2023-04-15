<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_convert.php';
// @codeCoverageIgnoreEnd

/**
 * 日時っぽい文字列とフォーマットを与えると取りうる範囲を返す
 *
 * 与えられた日時の最大の切り捨て日時と最小の切り上げ日時の配列を返す。
 * 日付文字列はある程度よしなに補完される（例えば "2014/12" は"2014年12月01日" と解釈されるし "12/24" は "今年12月24日" と解釈される）。
 *
 * Example:
 * ```php
 * that(date_fromto('Y/m/d H:i:s', '2010/11'))->isSame(["2010/11/01 00:00:00", "2010/12/01 00:00:00"]);
 * that(date_fromto('Y/m/d H:i:s', '2010/11/24'))->isSame(["2010/11/24 00:00:00", "2010/11/25 00:00:00"]);
 * that(date_fromto('Y/m/d H:i:s', '2010/11/24 13'))->isSame(["2010/11/24 13:00:00", "2010/11/24 14:00:00"]);
 * that(date_fromto('Y/m/d H:i:s', '2010/11/24 13:24'))->isSame(["2010/11/24 13:24:00", "2010/11/24 13:25:00"]);
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string $format フォーマット。 null を与えるとタイムスタンプで返す
 * @param string $datetimestring 日時データ
 * @return array|null [from ～ to] な配列。解釈できない場合は null
 */
function date_fromto($format, $datetimestring)
{
    $parsed = date_parse($datetimestring);
    if (true
        && $parsed['year'] === false
        && $parsed['month'] === false
        && $parsed['day'] === false
        && $parsed['hour'] === false
        && $parsed['minute'] === false
        && $parsed['second'] === false) {
        return null;
    }

    [$date, $time] = preg_split('#[T\s　]#u', $datetimestring, -1, PREG_SPLIT_NO_EMPTY) + [0 => '', 1 => ''];
    [$y, $m, $d] = preg_split('#[^\d]+#u', $date, -1, PREG_SPLIT_NO_EMPTY) + [0 => null, 1 => null, 2 => null];
    [$h, $i, $s] = preg_split('#[^\d]+#u', $time, -1, PREG_SPLIT_NO_EMPTY) + [0 => null, 1 => null, 2 => null];

    // "2014/12" と "12/24" の区別はつかないので字数で判断
    if (strlen($y ?? '') <= 2) {
        [$y, $m, $d] = [null, $y, $m];
    }
    // 時刻区切りなし
    if (strlen($h ?? '') > 2) {
        [$h, $i, $s] = str_split($h, 2) + [0 => null, 1 => null, 2 => null];
    }

    // 文字列表現で妥当性を検証
    $strtime = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $y ?? 1000, $m ?? 1, $d ?? 1, $h ?? 1, $i ?? 1, $s ?? 1);
    $datetime = date_create_from_format('Y-m-d H:i:s', $strtime);
    if (!$datetime || $datetime->format('Y-m-d H:i:s') !== $strtime) {
        return null;
    }

    $y ??= idate('Y');
    $ld = $d ?? idate('t', mktime(0, 0, 0, $m ?? 12, 1, $y));

    $min = mktime($h ?? 0, $i ?? 0, $s ?? 0, $m ?? 1, $d ?? 1, $y) + $parsed['fraction'];
    $max = mktime($h ?? 23, $i ?? 59, $s ?? 59, $m ?? 12, $d ?? $ld, $y) + 1;
    if ($format === null) {
        return [$min, $max];
    }
    return [date_convert($format, $min), date_convert($format, $max)];
}
