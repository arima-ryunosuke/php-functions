<?php

namespace ryunosuke\Functions\Package;


/**
 * 日付・時刻関連のユーティリティ
 */
class Date
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
     * 日時文字列をよしなにタイムスタンプに変換する
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
     * @return int|float|null タイムスタンプ。パース失敗時は null
     */
    public static function date_timestamp($datetimedata)
    {
        // 全角を含めた trim
        $chars = "[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]";
        $datetimedata = preg_replace("/\A{$chars}++|{$chars}++\z/u", '', $datetimedata);

        // 和暦を西暦に置換
        $jpnames = array_merge(array_column(JP_ERA, 'name'), array_column(JP_ERA, 'abbr'));
        $datetimedata = preg_replace_callback('/^(' . implode('|', $jpnames) . ')(\d{1,2}|元)/u', function ($matches) {
            list(, $era, $year) = $matches;
            $eratime = (array_find)(JP_ERA, function ($v) use ($era) {
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
            '年'  => '-',
            '月'  => '-',
            '日'  => ' ',
            '時'  => ':',
            '分'  => ':',
            '秒'  => '',
        ]);
        $datetimedata = trim($datetimedata, " \t\n\r\0\x0B:-");

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
            return null;
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

        // ドキュメントに「引数が不正な場合、 この関数は FALSE を返します」とあるが、 date_parse の結果を与える分には失敗しないはず
        $time = mktime($parts['hour'], $parts['minute'], $parts['second'], $parts['month'], $parts['day'], $parts['year']);
        if ($parts['fraction']) {
            // 1970 以前なら減算、以降なら加算じゃないと帳尻が合わなくなる
            $time += $time >= 0 ? $parts['fraction'] : -$parts['fraction'];
        }

        return $time;
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
     * @param string|int|float|\DateTime $datetimedata 日時データ。省略時は microtime
     * @return string 日時文字列
     */
    public static function date_convert($format, $datetimedata = null)
    {
        // 省略時は microtime
        if ($datetimedata === null) {
            $timestamp = microtime(true);
        }
        elseif ($datetimedata instanceof \DateTime) {
            // @fixme DateTime オブジェクトって timestamp を float で得られないの？
            $timestamp = (float) $datetimedata->format('U.u');
        }
        else {
            $timestamp = (date_timestamp)($datetimedata);
            if ($timestamp === null) {
                throw new \InvalidArgumentException("parse failed '$datetimedata'");
            }
        }

        $replace = function ($string, $char, $replace) {
            $string = preg_replace('/(?<!\\\)' . $char . '/', '${1}' . $replace, $string);
            return preg_replace('/\\\\' . $char . '/', $char, $string);
        };

        if (preg_match('/[JbKk]/', $format)) {
            $era = (array_find)(JP_ERA, function ($v) use ($timestamp) {
                if ($v['since'] <= $timestamp) {
                    return $v;
                }
            }, false);
            if ($era === false) {
                throw new \InvalidArgumentException("notfound JP_ERA '$datetimedata'");
            }

            $y = idate('Y', $timestamp) - idate('Y', $era['since']) + 1;
            $format = $replace($format, 'J', $era['name']);
            $format = $replace($format, 'b', $era['abbr']);
            $format = $replace($format, 'K', $y === 1 ? '元' : $y);
            $format = $replace($format, 'k', $y);
        }

        $format = $replace($format, 'x', ['日', '月', '火', '水', '木', '金', '土'][idate('w', $timestamp)]);

        if (is_float($timestamp)) {
            list($second, $micro) = explode('.', $timestamp) + [1 => '000000'];
            $datetime = \DateTime::createFromFormat('Y/m/d H:i:s.u', date('Y/m/d H:i:s.', $second) . $micro);
            return $datetime->format($format);
        }
        return date($format, $timestamp);
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
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, function(){return implode(',', func_get_args());}))->isSame('678,45,25,3,18,5,2,0');
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
     * @param string|array $format 時刻フォーマット
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
            $limit = $map[$limit_type] ?? (throws)(new \InvalidArgumentException("limit_type:$limit_type is undefined."));
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
            $interval->c = $limit < $map['c'] ? 0 : $centurys % 1000;
            $interval->y = $limit < $map['y'] ? 0 : ($limit === $map['y'] ? $years : $years % 100);
            $interval->m = $limit < $map['m'] ? 0 : ($limit === $map['m'] ? $months : $months % 12);
            $interval->d = $limit < $map['d'] ? 0 : ($limit === $map['d'] ? $days : intval(($days * 100000000) % (365 / 12 * 100000000) / 100000000));
            $interval->h = $limit < $map['h'] ? 0 : ($limit === $map['h'] ? $hours : $hours % 24);
            $interval->i = $limit < $map['i'] ? 0 : ($limit === $map['i'] ? $minutes : $minutes % 60);
            $interval->s = $limit < $map['s'] ? 0 : ($limit === $map['s'] ? $seconds : $seconds % 60);
            $interval->v = $mills % 1000;
        }

        // null は DateInterval をそのまま返す
        if ($format === null) {
            return $interval;
        }

        // クロージャはコールバックする
        if ($format instanceof \Closure) {
            /** @noinspection PhpUndefinedFieldInspection */
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
                                if (($p = (array_pos_key)($format, $ymdhisv[$n + $i], -1)) >= 0) {
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
                    $fmt = (arrayize)($fmt);
                    $fmt = (switchs)(count($fmt), [
                        1 => static function () use ($fmt) { return ['', $fmt[0], '']; },
                        2 => static function () use ($fmt) { return ['', $fmt[0], $fmt[1]]; },
                        3 => static function () use ($fmt) { return array_values($fmt); },
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
                $tmp2 = array_merge($tmp2, (arrayize)($fmt));
            }
            $format = implode('', $tmp2);
        }

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $format = preg_replace('#(^|[^%])%c#u', '${1}' . $interval->c, $format);
            $format = preg_replace('#(^|[^%])%v#u', '${1}' . $interval->v, $format);
        }
        return $interval->format($format);
    }
}
