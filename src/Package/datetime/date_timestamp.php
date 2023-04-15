<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * 日時的なものをよしなにタイムスタンプに変換する
 *
 * マイクロ秒にも対応している。つまり返り値は int か float になる。
 * また、相対指定の +1 month の月末問題は起きないようにしてある。
 *
 * かなり適当に和暦にも対応している。
 * さらに必要に迫られてかなり特殊な対応を行っているので Example を参照。
 *
 * Example:
 * ```php
 * // 普通の日時文字列
 * that(date_timestamp('2014/12/24 12:34:56'))->isSame(strtotime('2014/12/24 12:34:56'));
 * // 和暦
 * that(date_timestamp('昭和31年12月24日 12時34分56秒'))->isSame(strtotime('1956/12/24 12:34:56'));
 * // 相対指定
 * that(date_timestamp('2012/01/31 +1 month'))->isSame(strtotime('2012/02/29'));
 * that(date_timestamp('2012/03/31 -1 month'))->isSame(strtotime('2012/02/29'));
 * // マイクロ秒
 * that(date_timestamp('2014/12/24 12:34:56.789'))->isSame(1419392096.789);
 *
 * // ベース日時
 * $baseTimestamp = strtotime('2012/01/31');
 * // ベース日時の25日（strtotime の序数日付は first/last しか対応していないが、この関数は対応している）
 * that(date_timestamp('25th of this month', $baseTimestamp))->isSame(strtotime('2012/01/25'));
 * // ベース日時の第2月曜（strtotime の序数曜日は 1st のような表記に対応していないが、この関数は対応している）
 * that(date_timestamp('2nd monday of this month', $baseTimestamp))->isSame(strtotime('2012/01/09'));
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string|int|float|\DateTimeInterface $datetimedata 日時データ
 * @param int|null $baseTimestamp 日時データ
 * @return int|float|null タイムスタンプ。パース失敗時は null
 */
function date_timestamp($datetimedata, $baseTimestamp = null)
{
    if ($datetimedata instanceof \DateTimeInterface) {
        return $datetimedata->getTimestamp() + $datetimedata->format('u') / 1000 / 1000;
    }

    $DAY1 = 60 * 60 * 24;
    $ORDINAL_WORDS = [
        '1st'  => 'first',
        '2nd'  => 'second',
        '3rd'  => 'third',
        '4th'  => 'fourth',
        '5th'  => 'fifth',
        '6th'  => 'sixth',
        '7th'  => 'seventh',
        '8th'  => 'eighth',
        '9th'  => 'ninth',
        '10th' => 'tenth',
        '11th' => 'eleventh',
        '12th' => 'twelfth',
    ];

    $ordinal_day = null;
    $oddeven = null;
    if (is_string($datetimedata) || (is_object($datetimedata) && method_exists($datetimedata, '__toString'))) {
        // 全角を含めた trim
        $chars = "[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]";
        $datetimedata = preg_replace("/\A{$chars}++|{$chars}++\z/u", '', $datetimedata);

        // 和暦を西暦に置換
        $jpnames = array_merge(array_column(JP_ERA, 'name'), array_column(JP_ERA, 'abbr'));
        $datetimedata = preg_replace_callback('/^(' . implode('|', $jpnames) . ')(\d{1,2}|元)/u', function ($matches) {
            [, $era, $year] = $matches;
            $eratime = array_find(JP_ERA, function ($v) use ($era) {
                if (in_array($era, [$v['name'], $v['abbr']], true)) {
                    return $v['since'];
                }
            }, false);
            return idate('Y', $eratime) + ($year === '元' ? 1 : $year) - 1;
        }, $datetimedata);

        // 単位文字列を置換
        $datetimedata = strtr($datetimedata, [
            '　'    => ' ',
            '西暦' => '',
            '年'   => '/',
            '月'   => '/',
            '日'   => ' ',
            '時'   => ':',
            '分'   => ':',
            '秒'   => '',
        ]);
        $datetimedata = trim($datetimedata, " \t\n\r\0\x0B:/");

        // 1st, 2nd, 3rd, 4th dayname の対応
        $datetimedata = preg_replace_callback('#((\d{1,2})(st|nd|rd|th))(\s+(sun|mon|tues?|wed(nes)?|thu(rs)?|fri|sat(ur)?)day)#u', function ($matches) use ($ORDINAL_WORDS) {
            if (!isset($ORDINAL_WORDS[$matches[1]])) {
                return $matches[0];
            }

            return $ORDINAL_WORDS[$matches[1]] . $matches[4];
        }, $datetimedata);

        // 1st, 2nd, 3rd, 4th day の対応
        $datetimedata = preg_replace_callback('#((\d{1,2})(st|nd|rd|th))(\s+day)?#ui', function ($matches) use (&$ordinal_day) {
            if ($matches[1] !== (new \NumberFormatter('en', \NumberFormatter::ORDINAL))->format($matches[2])) {
                return $matches[0];
            }

            $ordinal_day = $matches[2];
            return 'first day';
        }, $datetimedata);

        // odd, even の対応
        $datetimedata = preg_replace_callback('#(odd|even)\s+#ui', function ($matches) use (&$oddeven) {
            $oddeven = $matches[1];
            return 'this ';
        }, $datetimedata);
    }

    // 数値4桁は年と解釈されるように
    if (preg_match('/^[0-9]{4}$/', $datetimedata)) {
        $datetimedata .= '-01-01';
    }

    // 数値系はタイムスタンプとみなす
    if (ctype_digit("$datetimedata")) {
        return (int) $datetimedata;
    }
    if (is_numeric($datetimedata)) {
        return (float) $datetimedata;
    }

    // strtotime と date_parse の合せ技で変換
    $baseTimestamp ??= time();
    $timestamp = strtotime($datetimedata, $baseTimestamp);
    $parts = date_parse($datetimedata);
    if ($timestamp === false || $parts['error_count']) {
        return null;
    }

    if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
        if (!isset($parts['relative'])) {
            return null;
        }
        $parts['year'] = idate('Y', $baseTimestamp);
        $parts['month'] = idate('m', $baseTimestamp);
        $parts['day'] = idate('d', $baseTimestamp);
    }

    if ($ordinal_day) {
        $timestamp += ($ordinal_day - 1) * $DAY1;
    }

    if ($oddeven !== null) {
        $idateW2 = idate('W', $timestamp) % 2;
        if (($oddeven === 'odd' && $idateW2 === 0) || ($oddeven === 'even' && $idateW2 === 1)) {
            $timestamp += $DAY1 * 7;
        }
    }

    $relative = $parts['relative'] ?? [];
    if (($relative['month'] ?? false)
        && !isset($relative['weekday'])            // 週指定があるとかなり特殊で初日末日が意味を為さない
        && !isset($relative['first_day_of_month']) // first day 指定があるなら初日確定
        && !isset($relative['last_day_of_month'])  // last day 指定があるなら末日確定
    ) {
        $parts['month'] += $relative['month'];
        $parts['year'] += intdiv($parts['month'], 12);
        $parts['month'] %= 12;
        $parts['month'] += $parts['month'] <= 0 ? 12 : 0;

        if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
            $timestamp = strtotime(date('Y-m-t H:i:s', $timestamp - $DAY1 * 4));
        }
    }

    if ($parts['fraction']) {
        $timestamp += ($timestamp >= 0 ? +$parts['fraction'] : -$parts['fraction']);
    }
    return $timestamp;
}
