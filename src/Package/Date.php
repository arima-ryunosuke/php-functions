<?php

namespace ryunosuke\Functions\Package;

/**
 * 日付・時刻関連のユーティリティ
 */
class Date implements Interfaces\Date
{
    /** 和暦 */
    const JP_ERA = [
        ['name' => '令和', 'abbr' => 'R', 'since' => +1556636400], // 2019-05-01
        ['name' => '平成', 'abbr' => 'H', 'since' => +600188400],  // 1989-01-08
        ['name' => '昭和', 'abbr' => 'S', 'since' => -1357635600], // 1926-12-25
        ['name' => '大正', 'abbr' => 'T', 'since' => -1812186000], // 1912-07-30
        ['name' => '明治', 'abbr' => 'M', 'since' => -3216790800], // 1868-01-25
    ];

    /**
     * 日時文字列のバリデーション
     *
     * 存在しない日付・時刻・相対指定などは全て不可。
     * あくまで「2014/12/24 12:34:56」のような形式と妥当性だけでチェックする。
     * $overhour 引数で 27:00 のような拡張時刻も許容させることができる（6 を指定すればいわゆる30時間制になる）。
     *
     * 日時形式は結構複雑なので「正しいはずだがなぜか false になる」という事象が頻発する。
     * その時、調査が大変（どの段階で false になっているか分からない）なので＠で抑制しつつも内部的には user_error を投げている。
     * このエラーは error_get_last で取得可能だが、行儀の悪い（＠抑制を見ない）エラーハンドラが設定されていると例外として送出されることがあるので注意。
     *
     * @param string $datetime_string 日付形式の文字列
     * @param string $format フォーマット文字列
     * @param int $overhour 24時以降をどこまで許すか
     * @return bool valid な日時なら true
     */
    public static function date_validate($datetime_string, $format = 'Y/m/d H:i:s', $overhour = 0)
    {
        $inrange = fn($value, $min, $max) => $min <= $value && $value <= $max;

        try {
            $parsed = date_parse_from_format($format, $datetime_string);

            if ($parsed['error_count']) {
                throw new \ErrorException(Arrays::array_sprintf($parsed['errors'], '#%2$s %1$s', "\n"));
            }

            ['year' => $year, 'month' => $month, 'day' => $day] = $parsed;

            if ($year !== false && $month !== false && $day !== false && !checkdate($month, $day, $year)) {
                throw new \ErrorException("invalid date '$year-$month-$day'");
            }
            elseif ($year !== false && !$inrange($year, 0, 9999)) {
                // 現状のパラメ－タで 0~9999 以外の年が来ることはない
                throw new \ErrorException("invalid year '$year'"); // @codeCoverageIgnore
            }
            elseif ($month !== false && !$inrange($month, 1, 12)) {
                throw new \ErrorException("invalid month '$month'");
            }
            elseif ($day !== false && !$inrange($day, 1, 31)) {
                throw new \ErrorException("invalid day '$day'");
            }

            ['hour' => $hour, 'minute' => $minute, 'second' => $second] = $parsed;

            if ($hour !== false && !$inrange($hour, 0, 23 + $overhour)) {
                throw new \ErrorException("invalid hour '$hour'");
            }
            elseif ($minute !== false && !$inrange($minute, 0, 59)) {
                throw new \ErrorException("invalid minute '$minute'");
            }
            elseif ($second !== false && !$inrange($second, 0, 59)) {
                throw new \ErrorException("invalid second '$second'");
            }

            return true;
        }
        catch (\Throwable $t) {
            @trigger_error($t->getMessage());
            return false;
        }
    }

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
     * @param string|int|float|\DateTimeInterface $datetimedata 日時データ
     * @param int|null $baseTimestamp 日時データ
     * @return int|float|null タイムスタンプ。パース失敗時は null
     */
    public static function date_timestamp($datetimedata, $baseTimestamp = null)
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
            $jpnames = array_merge(array_column(Date::JP_ERA, 'name'), array_column(Date::JP_ERA, 'abbr'));
            $datetimedata = preg_replace_callback('/^(' . implode('|', $jpnames) . ')(\d{1,2}|元)/u', function ($matches) {
                [, $era, $year] = $matches;
                $eratime = Arrays::array_find(Date::JP_ERA, function ($v) use ($era) {
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

        return $parts['fraction'] ? $timestamp + $parts['fraction'] : $timestamp;
    }

    /**
     * 日時文字列をよしなに別のフォーマットに変換する
     *
     * マイクロ秒にも対応している。
     * かなり適当に和暦にも対応している。
     *
     * Example:
     * ```php
     * // 和暦を Y/m/d H:i:s に変換
     * that(date_convert('Y/m/d H:i:s', '昭和31年12月24日 12時34分56秒'))->isSame('1956/12/24 12:34:56');
     * // 単純に「マイクロ秒が使える date」としても使える
     * $now = 1234567890.123; // テストがしづらいので固定時刻にする
     * that(date_convert('Y/m/d H:i:s.u', $now))->isSame('2009/02/14 08:31:30.122999');
     * // $format に DateTimeInterface 実装クラス名を与えるとそのインスタンスを返す
     * that(date_convert(\DateTimeImmutable::class, $now))->isInstanceOf(\DateTimeImmutable::class);
     * // null は DateTime を意味する
     * that(date_convert(null, $now))->isInstanceOf(\DateTime::class);
     * ```
     *
     * @todo 引数を入れ替えたほうが自然な気がする
     *
     * @param ?string $format フォーマット
     * @param string|int|float|\DateTimeInterface|null $datetimedata 日時データ。省略時は microtime
     * @return string|\DateTimeInterface 日時文字列。$format が null の場合は DateTime
     */
    public static function date_convert($format, $datetimedata = null)
    {
        $format ??= \DateTime::class;
        $return_object = class_exists($format) && is_subclass_of($format, \DateTimeInterface::class);

        if ($return_object && $datetimedata instanceof \DateTimeInterface) {
            return $datetimedata;
        }

        // 省略時は microtime
        if ($datetimedata === null) {
            $timestamp = microtime(true);
        }
        else {
            $timestamp = Date::date_timestamp($datetimedata);
            if ($timestamp === null) {
                throw new \InvalidArgumentException("parse failed '$datetimedata'");
            }
        }

        if (!$return_object) {
            $era = Arrays::array_find(Date::JP_ERA, function ($era) use ($timestamp) {
                if ($era['since'] <= $timestamp) {
                    $era['year'] = idate('Y', (int) $timestamp) - idate('Y', $era['since']) + 1;
                    $era['gann'] = $era['year'] === 1 ? '元' : $era['year'];
                    return $era;
                }
            }, false);
            $format = Strings::strtr_escaped($format, [
                'J' => fn() => $era ? $era['name'] : Syntax::throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
                'b' => fn() => $era ? $era['abbr'] : Syntax::throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
                'k' => fn() => $era ? $era['year'] : Syntax::throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
                'K' => fn() => $era ? $era['gann'] : Syntax::throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
                'x' => fn() => ['日', '月', '火', '水', '木', '金', '土'][idate('w', (int) $timestamp)],
            ], '\\');
        }

        if (is_int($timestamp) && !$return_object) {
            return date($format, $timestamp);
        }

        $class = $return_object ? $format : \DateTime::class;
        $dt = new $class();
        $dt = $dt->setTimestamp((int) $timestamp);

        if (is_float($timestamp)) {
            $diff = (int) (($timestamp - (int) $timestamp) * 1000 * 1000);
            $dt = $dt->modify("$diff microsecond");
        }

        if ($return_object) {
            return $dt;
        }
        return $dt->format($format);
    }

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
     * @param string $format フォーマット。 null を与えるとタイムスタンプで返す
     * @param string $datetimestring 日時データ
     * @return array|null [from ～ to] な配列。解釈できない場合は null
     */
    public static function date_fromto($format, $datetimestring)
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
        return [Date::date_convert($format, $min), Date::date_convert($format, $max)];
    }

    /**
     * 秒を世紀・年・月・日・時間・分・秒・ミリ秒の各要素に分解する
     *
     * 例えば `60 * 60 * 24 * 900 + 12345.678` （約900日12345秒）は・・・
     *
     * - 2 年（約900日なので）
     * - 5 ヶ月（約(900 - 365 * 2 = 170)日なので）
     * - 18 日（約(170 - 30.416 * 5 = 18)日なので）
     * - 3 時間（約12345秒なので）
     * - 25 分（約(12345 - 3600 * 3 = 1545)秒なので）
     * - 45 秒（約(1545 - 60 * 25 = 45)秒なので）
     * - 678 ミリ秒（.678 部分そのまま）
     *
     * となる（年はうるう年未考慮で365日、月は30.41666666日で換算）。
     *
     * $format を与えると DateInterval::format して文字列で返す。与えないと DateInterval をそのまま返す。
     * $format はクロージャを与えることができる。クロージャを与えた場合、各要素を引数としてコールバックされる。
     * $format は配列で与えることができる。配列で与えた場合、 0 になる要素は省かれる。
     * セパレータを与えたり、pre/suffix を与えたりできるが、難解なので省略する。
     *
     * $limit_type で換算のリミットを指定できる。例えば 'y' を指定すると「2年5ヶ月」となるが、 'm' を指定すると「29ヶ月」となる。
     * 数値を与えるとその範囲でオートスケールする。例えば 3 を指定すると値が大きいとき `ymd` の表示になり、年が 0 になると `mdh` の表示に切り替わるようになる。
     *
     * Example:
     * ```php
     * // 書式文字列指定（%vはミリ秒）
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v'))->isSame('02/05/18 03:25:45.678');
     *
     * // 書式にクロージャを与えるとコールバックされる（引数はスケールの小さい方から）
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, fn() => implode(',', func_get_args())))->isSame('678,45,25,3,18,5,2,0');
     *
     * // リミットを指定（month までしか計算しないので year は 0 になり month は 29になる）
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'))->isSame('00/29/18 03:25:45.678');
     *
     * // 書式に配列を与えてリミットに数値を与えるとその範囲でオートスケールする
     * $format = [
     *     'y' => '%y年',
     *     'm' => '%mヶ月',
     *     'd' => '%d日',
     *     ' ',
     *     'h' => '%h時間',
     *     'i' => '%i分',
     *     's' => '%s秒',
     * ];
     * // 数が大きいので年・月・日の3要素のみ
     * that(date_interval(60 * 60 * 24 * 900 + 12345, $format, 3))->isSame('2年5ヶ月18日');
     * // 数がそこそこだと日・時間・分の3要素に切り替わる
     * that(date_interval(60 * 60 * 24 * 20 + 12345, $format, 3))->isSame('20日 3時間25分');
     * // どんなに数が小さくても3要素以下にはならない
     * that(date_interval(1234, $format, 3))->isSame('0時間20分34秒');
     *
     * // 書式指定なし（DateInterval を返す）
     * that(date_interval(123.456))->isInstanceOf(\DateInterval::class);
     * ```
     *
     * @param int|float $sec タイムスタンプ
     * @param string|array|null $format 時刻フォーマット
     * @param string|int $limit_type どこまで換算するか（[c|y|m|d|h|i|s]）
     * @return string|\DateInterval 時間差文字列 or DateInterval オブジェクト
     */
    public static function date_interval($sec, $format = null, $limit_type = 'y')
    {
        $ymdhisv = ['c', 'y', 'm', 'd', 'h', 'i', 's', 'v'];
        $map = ['c' => 7, 'y' => 6, 'm' => 5, 'd' => 4, 'h' => 3, 'i' => 2, 's' => 1];
        if (ctype_digit("$limit_type")) {
            $limit = $map['c'];
            $limit_type = (int) $limit_type;
            if (!is_array($format) && !is_null($format)) {
                throw new \UnexpectedValueException('$format must be array if $limit_type is digit.');
            }
        }
        else {
            $limit = $map[$limit_type] ?? Syntax::throws(new \InvalidArgumentException("limit_type:$limit_type is undefined."));
        }

        // 各単位を導出
        $mills = $sec * 1000;
        $seconds = $sec;
        $minutes = $seconds / 60;
        $hours = $minutes / 60;
        $days = $hours / 24;
        $months = $days / (365 / 12);
        $years = $days / 365;
        $centurys = $years / 100;

        // $limit に従って値を切り捨てて DateInterval を作成
        $interval = new \DateInterval('PT1S');
        $interval->c = $limit < $map['c'] ? 0 : (int) $centurys % 1000;
        $interval->y = $limit < $map['y'] ? 0 : (int) ($limit === $map['y'] ? $years : (int) $years % 100);
        $interval->m = $limit < $map['m'] ? 0 : (int) ($limit === $map['m'] ? $months : (int) $months % 12);
        $interval->d = $limit < $map['d'] ? 0 : (int) ($limit === $map['d'] ? $days : (int) ((int) ($days * 100000000) % (int) (365 / 12 * 100000000) / 100000000));
        $interval->h = $limit < $map['h'] ? 0 : (int) ($limit === $map['h'] ? $hours : (int) $hours % 24);
        $interval->i = $limit < $map['i'] ? 0 : (int) ($limit === $map['i'] ? $minutes : (int) $minutes % 60);
        $interval->s = $limit < $map['s'] ? 0 : (int) ($limit === $map['s'] ? $seconds : (int) $seconds % 60);
        $interval->v = $mills % 1000;

        // null は DateInterval をそのまま返す
        if ($format === null) {
            return $interval;
        }

        // クロージャはコールバックする
        if ($format instanceof \Closure) {
            return $format($interval->v, $interval->s, $interval->i, $interval->h, $interval->d, $interval->m, $interval->y, $interval->c);
        }

        // 配列はいろいろとフィルタする
        if (is_array($format)) {
            // 数値ならその範囲でオートスケール
            if (is_int($limit_type)) {
                // 配列を回して値があるやつ + $limit_type の範囲とする
                foreach ($ymdhisv as $n => $key) {
                    // 最低 $limit_type は保持するために isset する
                    if ($interval->$key > 0 || !isset($ymdhisv[$n + $limit_type + 1])) {
                        $pos = [];
                        for ($i = 0; $i < $limit_type; $i++) {
                            if (isset($ymdhisv[$n + $i])) {
                                if (($p = Arrays::array_pos_key($format, $ymdhisv[$n + $i], -1)) >= 0) {
                                    $pos[] = $p;
                                }
                            }
                        }
                        if (!$pos) {
                            throw new \UnexpectedValueException('$format is empty.');
                        }
                        // 順不同なので min/max から slice しなければならない
                        $min = min($pos);
                        $max = max($pos);
                        $format = array_slice($format, $min, $max - $min + 1);
                        break;
                    }
                }
            }

            // 来ている $format を正規化（日時文字列は配列にするかつ値がないならフィルタ）
            $tmp = [];
            foreach ($format as $key => $fmt) {
                if (isset($interval->$key)) {
                    if (!is_int($limit_type) && $interval->$key === 0) {
                        $tmp[] = ['', '', ''];
                        continue;
                    }
                    $fmt = Arrays::arrayize($fmt);
                    $fmt = Syntax::switchs(count($fmt), [
                        1 => static fn() => ['', $fmt[0], ''],
                        2 => static fn() => ['', $fmt[0], $fmt[1]],
                        3 => static fn() => array_values($fmt),
                    ]);
                }
                $tmp[] = $fmt;
            }
            // さらに前後の値がないならフィルタ
            $tmp2 = [];
            foreach ($tmp as $n => $fmt) {
                $prevempty = true;
                for ($i = $n - 1; $i >= 0; $i--) {
                    if (!is_array($tmp[$i])) {
                        break;
                    }
                    if (strlen($tmp[$i][1])) {
                        $prevempty = false;
                        break;
                    }
                }
                $nextempty = true;
                for ($i = $n + 1, $l = count($tmp); $i < $l; $i++) {
                    if (!is_array($tmp[$i])) {
                        break;
                    }
                    if (strlen($tmp[$i][1])) {
                        $nextempty = false;
                        break;
                    }
                }

                if (is_array($fmt)) {
                    if ($prevempty) {
                        $fmt[0] = '';
                    }
                    if ($nextempty) {
                        $fmt[2] = '';
                    }
                }
                elseif ($prevempty || $nextempty) {
                    $fmt = '';
                }
                $tmp2 = array_merge($tmp2, Arrays::arrayize($fmt));
            }
            $format = implode('', $tmp2);
        }

        $format = Strings::strtr_escaped($format, [
            '%c' => $interval->c,
            '%v' => $interval->v,
        ], '%');
        return $interval->format($format);
    }

    /**
     * 日付を除外日リストに基づいてずらす
     *
     * 典型的には「祝日前の営業日」「祝日後の営業日」のような代理日を返すイメージ。
     * $follow_count に応じて下記のように返す。
     *
     * - null: 除外日でもずらさないでそのまま返す
     * - -N: 除外日なら最大N日分前倒しした日付を返す
     * - +N: 除外日なら最大N日分先送りした日付を返す
     * - 0: 除外日でもずらさないで null を返す
     *
     * @param string|int|\DateTimeInterface $datetime 調べる日付
     * @param array $excluded_dates 除外日（いわゆる祝休日リスト）
     * @param ?int $follow_count ずらす範囲
     * @param string $format 日付フォーマット（$excluded_dates の形式＋返り値の形式）
     * @return string|null 代替日。除外日 null
     */
    public static function date_alter($datetime, $excluded_dates, $follow_count, $format = 'Y-m-d')
    {
        $timestamp = Date::date_timestamp($datetime);
        if (!array_key_exists($date = date($format, $timestamp), $excluded_dates)) {
            return $date;
        }
        if ($follow_count === null) {
            return $date;
        }
        $follow_count = (int) $follow_count;
        if ($follow_count < 0) {
            return Date::date_alter($timestamp - 24 * 3600, $excluded_dates, $follow_count + 1, $format);
        }
        if ($follow_count > 0) {
            return Date::date_alter($timestamp + 24 * 3600, $excluded_dates, $follow_count - 1, $format);
        }
        return null;
    }
}
