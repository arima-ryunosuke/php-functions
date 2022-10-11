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
     * 日時的なものをよしなにタイムスタンプに変換する
     *
     * マイクロ秒にも対応している。つまり返り値は int か float になる。
     * また、相対指定の +1 month の月末問題は起きないようにしてある。
     *
     * かなり適当に和暦にも対応している。
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
     * ```
     *
     * @param string|int|float $datetimedata 日時データ
     * @param int|null $baseTimestamp 日時データ
     * @return int|float|null タイムスタンプ。パース失敗時は null
     */
    public static function date_timestamp($datetimedata, $baseTimestamp = null)
    {
        if ($datetimedata instanceof \DateTimeInterface) {
            return (float) $datetimedata->format('U.u');
        }

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
                '　'  => ' ',
                '西暦' => '',
                '年'  => '/',
                '月'  => '/',
                '日'  => ' ',
                '時'  => ':',
                '分'  => ':',
                '秒'  => '',
            ]);
            $datetimedata = trim($datetimedata, " \t\n\r\0\x0B:/");
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

        // date_parse してみる
        $parts = date_parse($datetimedata);
        if (!$parts) {
            // ドキュメントに「成功した場合に日付情報を含む配列、失敗した場合に FALSE を返します」とあるが、失敗する気配がない
            return null; // @codeCoverageIgnore
        }
        if ($parts['error_count']) {
            return null;
        }

        if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
            if (!isset($parts['relative'])) {
                return null;
            }
            $baseTimestamp ??= time();
            $parts['year'] = idate('Y', $baseTimestamp);
            $parts['month'] = idate('m', $baseTimestamp);
            $parts['day'] = idate('d', $baseTimestamp);
        }

        if (isset($parts['relative'])) {
            $relative = $parts['relative'];
            $parts['year'] += $relative['year'];
            $parts['month'] += $relative['month'];
            // php の相対指定は割と腐っているので補正する（末日を超えても月は変わらないようにする）
            if ($parts['month'] > 12) {
                $parts['year'] += intdiv($parts['month'], 12);
                $parts['month'] = $parts['month'] % 12;
            }
            if ($parts['month'] < 1) {
                $parts['year'] += intdiv(-12 + $parts['month'], 12);
                $parts['month'] = 12 + $parts['month'] % 12;
            }
            if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
                $parts['day'] = idate('t', mktime(12, 12, 12, $parts['month'], 1, $parts['year']));
            }
            $parts['day'] += $relative['day'];
            $parts['hour'] += $relative['hour'];
            $parts['minute'] += $relative['minute'];
            $parts['second'] += $relative['second'];
        }

        $offset = 0;
        $timezone = null;
        if ($parts['is_localtime']) {
            if ($parts['zone_type'] === 1) {
                $timezone = new \DateTimeZone('UTC');
                $offset = $parts['zone'];
            }
            elseif ($parts['zone_type'] === 2) {
                $timezone = new \DateTimeZone($parts['tz_abbr']);
            }
            elseif ($parts['zone_type'] === 3) {
                $timezone = new \DateTimeZone($parts['tz_id']);
            }
        }

        $dt = new \DateTime('', $timezone);
        $dt->setDate($parts['year'], $parts['month'], $parts['day']);
        $dt->setTime($parts['hour'], $parts['minute'], $parts['second'] - $offset, ($parts['fraction'] ?: 0) * 1000 * 1000);
        return $parts['fraction'] ? (float) $dt->format('U.u') : $dt->getTimestamp();
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
     * that(date_convert('Y/m/d H:i:s.u', $now))->isSame('2009/02/14 08:31:30.123000');
     * ```
     *
     * @param string $format フォーマット
     * @param string|int|float|\DateTime|null $datetimedata 日時データ。省略時は microtime
     * @return string 日時文字列
     */
    public static function date_convert($format, $datetimedata = null)
    {
        // 省略時は microtime
        if ($datetimedata === null) {
            $timestamp = microtime(true);
        }
        elseif ($datetimedata instanceof \DateTimeInterface) {
            // @fixme DateTime オブジェクトって timestamp を float で得られないの？
            $timestamp = (float) $datetimedata->format('U.u');
        }
        else {
            $timestamp = Date::date_timestamp($datetimedata);
            if ($timestamp === null) {
                throw new \InvalidArgumentException("parse failed '$datetimedata'");
            }
        }

        $replace = function ($string, $char, $replace) {
            $string = preg_replace('/(?<!\\\)' . $char . '/', '${1}' . $replace, $string);
            return preg_replace('/\\\\' . $char . '/', $char, preg_replace('/(?<!\\\)' . $char . '/', '${1}' . $replace, $string));
        };

        if (preg_match('/[JbKk]/', $format)) {
            $era = Arrays::array_find(Date::JP_ERA, function ($v) use ($timestamp) {
                if ($v['since'] <= $timestamp) {
                    return $v;
                }
            }, false);
            if ($era === false) {
                throw new \InvalidArgumentException("notfound JP_ERA '$datetimedata'");
            }

            $y = idate('Y', (int) $timestamp) - idate('Y', $era['since']) + 1;
            $format = $replace($format, 'J', $era['name']);
            $format = $replace($format, 'b', $era['abbr']);
            $format = $replace($format, 'K', $y === 1 ? '元' : $y);
            $format = $replace($format, 'k', $y);
        }

        $format = $replace($format, 'x', ['日', '月', '火', '水', '木', '金', '土'][idate('w', (int) $timestamp)]);

        if (is_float($timestamp)) {
            // datetime パラメータが UNIX タイムスタンプ (例: 946684800) だったり、タイムゾーンを含んでいたり (例: 2010-01-28T15:00:00+02:00) する場合は、 timezone パラメータや現在のタイムゾーンは無視します
            static $dtz = null;
            $dtz ??= new \DateTimeZone(date_default_timezone_get());
            return \DateTime::createFromFormat('U.u', sprintf('%f', $timestamp))->setTimezone($dtz)->format($format);
        }
        return date($format, $timestamp);
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
        /** @noinspection PhpUndefinedFieldInspection */
        {
            $interval = new \DateInterval('PT1S');
            $interval->c = $limit < $map['c'] ? 0 : (int) $centurys % 1000;
            $interval->y = $limit < $map['y'] ? 0 : (int) ($limit === $map['y'] ? $years : (int) $years % 100);
            $interval->m = $limit < $map['m'] ? 0 : (int) ($limit === $map['m'] ? $months : (int) $months % 12);
            $interval->d = $limit < $map['d'] ? 0 : (int) ($limit === $map['d'] ? $days : (int) ((int) ($days * 100000000) % (int) (365 / 12 * 100000000) / 100000000));
            $interval->h = $limit < $map['h'] ? 0 : (int) ($limit === $map['h'] ? $hours : (int) $hours % 24);
            $interval->i = $limit < $map['i'] ? 0 : (int) ($limit === $map['i'] ? $minutes : (int) $minutes % 60);
            $interval->s = $limit < $map['s'] ? 0 : (int) ($limit === $map['s'] ? $seconds : (int) $seconds % 60);
            $interval->v = $mills % 1000;
        }

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

        {
            $format = preg_replace('#(^|[^%])%c#u', '${1}' . $interval->c, $format);
            $format = preg_replace('#(^|[^%])%v#u', '${1}' . $interval->v, $format);
        }
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
