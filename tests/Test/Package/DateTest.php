<?php

namespace ryunosuke\Test\Package;

class DateTest extends AbstractTestCase
{
    function test_date_timestamp()
    {
        // テストがコケてタイムスタンプが出力されても分かりにくすぎるので文字列化してテストする
        $test = function ($val, $base = null) {
            $timestamp = (date_timestamp)($val, $base);
            if ($timestamp === null) {
                return null;
            }
            [$second, $micro] = explode('.', $timestamp) + [1 => '000000'];
            return date('Y/m/d H:i:s', $second) . ".$micro";
        };

        // 割と普通のやつ
        that($test('2014/12/24 12:34:56'))->is('2014/12/24 12:34:56.000000');
        that($test('2014/12/24'))->is('2014/12/24 00:00:00.000000');
        // 日本語
        that($test('西暦2014年12月24日12時34分56秒'))->is('2014/12/24 12:34:56.000000');
        that($test('西暦2014年12月24日'))->is('2014/12/24 00:00:00.000000');
        // 西暦なし
        that($test('2014年12月24日12時34分56秒'))->is('2014/12/24 12:34:56.000000');
        that($test('2014年12月24日'))->is('2014/12/24 00:00:00.000000');
        // 和暦
        that($test('昭和31年12月24日 12時34分56秒'))->is('1956/12/24 12:34:56.000000');
        that($test('昭和31年12月24日'))->is('1956/12/24 00:00:00.000000');
        that($test('令和元年12月24日 12時34分56秒'))->is('2019/12/24 12:34:56.000000');
        that($test('令和元年12月24日'))->is('2019/12/24 00:00:00.000000');
        // 数値X桁
        that($test('2014'))->is('2014/01/01 00:00:00.000000');
        that($test('西暦2014'))->is('2014/01/01 00:00:00.000000');
        that($test('平成26'))->is('2014/01/01 00:00:00.000000');
        that($test('2014年'))->is('2014/01/01 00:00:00.000000');
        that($test('西暦2014年'))->is('2014/01/01 00:00:00.000000');
        that($test('平成26年'))->is('2014/01/01 00:00:00.000000');
        // マイクロ秒
        that($test(1234567890))->is('2009/02/14 08:31:30.000000');
        that($test('1234567890'))->is('2009/02/14 08:31:30.000000');
        that($test(1234567890.789))->is('2009/02/14 08:31:30.789');
        that($test('1234567890.789'))->is('2009/02/14 08:31:30.789');
        that($test('2014/12/24 12:34:56.789'))->is('2014/12/24 12:34:56.789');
        that($test('昭和31年12月24日 12時34分56.789秒'))->is('1956/12/24 12:34:56.789');
        // 相対指定（ベース指定）
        that($test('+1 month'))->is($test('+1 month', time()));
        that($test('+1 month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/29 00:00:00.000000');
        that($test('+1 month', strtotime('2012/02/28 12:34:56.000000')))->is('2012/03/28 00:00:00.000000');
        that($test('-1 month', strtotime('2012/01/31 12:34:56.000000')))->is('2011/12/31 00:00:00.000000');
        that($test('-1 month', strtotime('2012/02/28 12:34:56.000000')))->is('2012/01/28 00:00:00.000000');
        // 相対指定
        that($test('2012/01/28 12:34:56 +1 month'))->is('2012/02/28 12:34:56.000000');
        that($test('2012/01/29 12:34:56 +1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/01/30 12:34:56 +1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/01/31 12:34:56 +1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/02/01 12:34:56 +1 month'))->is('2012/03/01 12:34:56.000000');
        that($test('2011/12/28 12:34:56 +2 month'))->is('2012/02/28 12:34:56.000000');
        that($test('2011/12/29 12:34:56 +2 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2011/12/30 12:34:56 +2 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/01/01 12:34:56 +2 month'))->is('2012/03/01 12:34:56.000000');
        that($test('2012/04/01 12:34:56 -1 month'))->is('2012/03/01 12:34:56.000000');
        that($test('2012/03/31 12:34:56 -1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/03/30 12:34:56 -1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/03/29 12:34:56 -1 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/03/28 12:34:56 -1 month'))->is('2012/02/28 12:34:56.000000');
        that($test('2012/05/01 12:34:56 -2 month'))->is('2012/03/01 12:34:56.000000');
        that($test('2012/04/30 12:34:56 -2 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/04/29 12:34:56 -2 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2012/04/28 12:34:56 -2 month'))->is('2012/02/28 12:34:56.000000');
        that($test('2011/04/28 12:34:56 +12 month'))->is('2012/04/28 12:34:56.000000');
        that($test('2011/01/31 12:34:56 +13 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2013/04/28 12:34:56 -12 month'))->is('2012/04/28 12:34:56.000000');
        that($test('2013/03/31 12:34:56 -13 month'))->is('2012/02/29 12:34:56.000000');
        that($test('2011/04/28 12:34:56 +120 month'))->is('2021/04/28 12:34:56.000000');
        that($test('2011/01/31 12:34:56 +132 month'))->is('2022/01/31 12:34:56.000000');
        that($test('2013/04/28 12:34:56 -120 month'))->is('2003/04/28 12:34:56.000000');
        that($test('2013/03/31 12:34:56 -132 month'))->is('2002/03/31 12:34:56.000000');
        // 月がメインなのでほかはさっと流す
        that($test('2011/12/24 12:34:56 +1 year'))->is('2012/12/24 12:34:56.000000');
        that($test('2013/12/24 12:34:56 -1 year'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/23 12:34:56 +1 day'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/25 12:34:56 -1 day'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 11:34:56 +1 hour'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 13:34:56 -1 hour'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 12:33:56 +1 minute'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 12:35:56 -1 minute'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 12:34:55 +1 second'))->is('2012/12/24 12:34:56.000000');
        that($test('2012/12/24 12:34:57 -1 second'))->is('2012/12/24 12:34:56.000000');
        // 不正系
        that($test('hogera'))->is(null);               // 明らかにヤバイ1
        that($test('9999/99/99'))->is(null);           // 明らかにヤバイ2
        that($test('2014/2/29'))->is(null);            // 閏日でない
        that($test('2014/12/24 12:34:70'))->is(null);  // 秒が不正
    }

    function test_date_convert()
    {
        that((date_convert)('Y/m/d H:i:s', 1234567890))->is('2009/02/14 08:31:30');
        that((date_convert)('Y/m/d H:i:s', 1234567890.123))->is('2009/02/14 08:31:30');
        that((date_convert)('Y/m/d H:i:s.u', 1234567890))->is('2009/02/14 08:31:30.000000');
        that((date_convert)('Y/m/d H:i:s.u', 1234567890.123))->is('2009/02/14 08:31:30.123000');
        that((date_convert)('Y/m/d H:i:s.u', "1234567890.000"))->is('2009/02/14 08:31:30.000000');
        that((date_convert)('Y/m/d H:i:s.u', '2014/12/24 12:34:56.123'))->is('2014/12/24 12:34:56.123000');
        that((date_convert)('Y/m/d H:i:s.u', '令和元年12月24日 12時34分56.123秒'))->is('2019/12/24 12:34:56.123000');
        that((date_convert)('Y/m/d H:i:s.u', \DateTime::createFromFormat('Y/m/d H:i:s.u', '2019/12/24 12:34:56.123')))->is('2019/12/24 12:34:56.123000');
        that((date_convert)('Y/m/d H:i:s.u', \DateTimeImmutable::createFromFormat('Y/m/d H:i:s.u', '2019/12/24 12:34:56.123')))->is('2019/12/24 12:34:56.123000');

        that((date_convert)('Y/m/d H:i:s'))->is(date('Y/m/d H:i:s')); // microtime はテストがつらすぎるので u を付けない

        that((date_convert)('Jk年m月d日', '1908/12/24'))->is('明治41年12月24日');
        that((date_convert)('Jk年m月d日', '1923/12/24'))->is('大正12年12月24日');
        that((date_convert)('Jk年m月d日', '1962/12/24'))->is('昭和37年12月24日');
        that((date_convert)('JK年m月d日', '1989/12/24'))->is('平成元年12月24日');
        that((date_convert)('bK年m月d日', '2019/12/24'))->is('R元年12月24日');
        that((date_convert)('Jk年m月d日（x曜日）', '2019/12/24'))->is('令和1年12月24日（火曜日）');
        that((date_convert)('x曜日', '2019/12/24 00:00:00'))->is('火曜日');
        that((date_convert)('x曜日', '2019/12/24 00:00:00 -1 second'))->is('月曜日');
        that((date_convert)('\\Y\\J\\K\\k\\b\\x', '2019/12/24'))->is('YJKkbx');

        that(date_convert)('Y/m/d H:i:s.u', 'hogera')->wasThrown('parse failed');
        that(date_convert)('JY/m/d H:i:s.u', '1200/12/23')->wasThrown('notfound JP_ERA');
    }

    function test_date_fromto()
    {
        that((date_fromto)('Y/m/d H:i:s', '1999'))->is(['1999/01/01 00:00:00', '2000/01/01 00:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '1999/9'))->is(['1999/09/01 00:00:00', '1999/10/01 00:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '1999/9/10'))->is(['1999/09/10 00:00:00', '1999/09/11 00:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '1999/9/10 11'))->is(['1999/09/10 11:00:00', '1999/09/10 12:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '1999/9/10 11:22'))->is(['1999/09/10 11:22:00', '1999/09/10 11:23:00']);
        that((date_fromto)('Y/m/d H:i:s', '1999/9/10 11:22:33'))->is(['1999/09/10 11:22:33', '1999/09/10 11:22:34']);

        that((date_fromto)('Y/m/d H:i:s', '2000/2'))->is(['2000/02/01 00:00:00', '2000/03/01 00:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '9/10'))->is([idate('Y') . '/09/10 00:00:00', idate('Y') . '/09/11 00:00:00']);
        that((date_fromto)('Y/m/d H:i:s', '999/12/23 123456'))->is(['0999/12/23 12:34:56', '0999/12/23 12:34:57']);

        that((date_fromto)('Y-m-d', '2000/2'))->is(['2000-02-01', '2000-03-01']);
        that((date_fromto)(null, '2000/2'))->is([949330800, 951836400]);

        that((date_fromto)('Y/m/d H:i:s', 'hogehoge'))->is(null);
        that((date_fromto)('Y/m/d H:i:s', '/h/o/g/e/'))->is(null);
        that((date_fromto)('Y/m/d H:i:s', '2012/23/56'))->is(null);
    }

    function test_date_interval()
    {
        $HOUR_1 = 60 * 60;
        $DAY_1 = $HOUR_1 * 24;
        $MONTH_1 = $DAY_1 * (365 / 12);
        $YEAR_1 = $DAY_1 * 365;
        that((date_interval)($DAY_1 * 364, '%Y/%M/%D'))->is('00/11/29');
        that((date_interval)($DAY_1 * 365, '%Y/%M/%D'))->is('01/00/00');
        that((date_interval)($DAY_1 * 366, '%Y/%M/%D'))->is('01/00/01');
        that((date_interval)($DAY_1 * 364 + $YEAR_1, '%Y/%M/%D'))->is('01/11/29');
        that((date_interval)($DAY_1 * 365 + $YEAR_1, '%Y/%M/%D'))->is('02/00/00');
        that((date_interval)($DAY_1 * 366 + $YEAR_1, '%Y/%M/%D'))->is('02/00/01');

        that((date_interval)($DAY_1 * 29, '%Y/%M/%D'))->is('00/00/29');
        that((date_interval)($DAY_1 * 30, '%Y/%M/%D'))->is('00/00/30');
        that((date_interval)($DAY_1 * 31, '%Y/%M/%D'))->is('00/01/00');
        that((date_interval)($DAY_1 * 29 + $MONTH_1, '%Y/%M/%D'))->is('00/01/29');
        that((date_interval)($DAY_1 * 30 + $MONTH_1, '%Y/%M/%D'))->is('00/01/30');
        that((date_interval)($DAY_1 * 31 + $MONTH_1, '%Y/%M/%D'))->is('00/02/00');

        that((date_interval)($DAY_1 - 1, '%Y/%M/%D'))->is('00/00/00');
        that((date_interval)($DAY_1 + 0, '%Y/%M/%D'))->is('00/00/01');
        that((date_interval)($DAY_1 + $DAY_1, '%Y/%M/%D'))->is('00/00/02');

        that((date_interval)($HOUR_1 - 1, '%H:%I:%S'))->is('00:59:59');
        that((date_interval)($HOUR_1 + 0, '%H:%I:%S'))->is('01:00:00');
        that((date_interval)($HOUR_1 + 1, '%H:%I:%S'))->is('01:00:01');

        that((date_interval)(123.456, '%v'))->is('456');
        that((date_interval)(123.456, '%%v%%'))->is('%v%');

        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'y'))->is('01/01/09 03:25:45.678');
        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'))->is('00/13/09 03:25:45.678');
        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'd'))->is('00/00/405 03:25:45.678');
        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'h'))->is('00/00/00 9723:25:45.678');
        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'i'))->is('00/00/00 00:583405:45.678');
        that((date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 's'))->is('00/00/00 00:00:35004345.678');

        that((date_interval)(60 * 60 * 24 * 900 + 12345.678, fn() => implode(',', func_get_args()), 'c'))->is('678,45,25,3,18,5,2,0');

        $format = [
            'c' => ['%c century', ' '],
            'y' => ['%y year', ' '],
            'm' => ['%m month', ' '],
            'd' => ['%d days', ' '],
            'h' => ['%h hours', ' '],
            'i' => ['%i minute', ' '],
            's' => ['%s seconds', ''],
        ];
        that((date_interval)(0, $format, 3))->is('0 hours 0 minute 0 seconds');
        that((date_interval)(60 - 1, $format, 3))->is('0 hours 0 minute 59 seconds');
        that((date_interval)(60 - 0, $format, 3))->is('0 hours 1 minute 0 seconds');
        that((date_interval)(60 * 60 - 1, $format, 3))->is('0 hours 59 minute 59 seconds');
        that((date_interval)(60 * 60 - 0, $format, 3))->is('1 hours 0 minute 0 seconds');
        that((date_interval)(60 * 60 * 24 - 1, $format, 3))->is('23 hours 59 minute 59 seconds');
        that((date_interval)(60 * 60 * 24 - 0, $format, 3))->is('1 days 0 hours 0 minute');
        that((date_interval)(60 * 60 * 24 * (365 / 12) - 1, $format, 3))->is('30 days 9 hours 59 minute');
        that((date_interval)(60 * 60 * 24 * 31, $format, 3))->is('1 month 0 days 0 hours');
        that((date_interval)(60 * 60 * 24 * 365 - 1, $format, 3))->is('11 month 30 days 23 hours');
        that((date_interval)(60 * 60 * 24 * 365 - 0, $format, 3))->is('1 year 0 month 0 days');
        that((date_interval)(60 * 60 * 24 * 365 * 100 - 1, $format, 3))->is('99 year 11 month 30 days');
        that((date_interval)(60 * 60 * 24 * 365 * 100 - 0, $format, 3))->is('1 century 0 year 0 month');

        that((date_interval)(59, $format, 1))->is('59 seconds');
        that((date_interval)($HOUR_1 - 1, $format, 1))->is('59 minute');
        that((date_interval)($DAY_1 - 1, $format, 1))->is('23 hours');
        that((date_interval)($MONTH_1 - 1, $format, 1))->is('30 days');
        that((date_interval)($YEAR_1 - 1, $format, 1))->is('11 month');
        that((date_interval)($YEAR_1, $format, 1))->is('1 year');
        that((date_interval)($YEAR_1 * 100, $format, 1))->is('1 century');

        $format = [
            'y' => ['%YY', '/'],
            'm' => ['', '%mM', '/'],
            'd' => ['%dD', '/'],
            ' T ',
            'h' => ['%HH', ':'],
            'i' => ['%II', ':'],
            's' => ['%SS'],
        ];
        that((date_interval)($YEAR_1, $format))->is('01Y');
        that((date_interval)($YEAR_1 + $MONTH_1 - $HOUR_1 * 10, $format))->is('01Y/30D');
        that((date_interval)($YEAR_1 + $MONTH_1 + $DAY_1 - $HOUR_1 * 10, $format))->is('01Y/1M');
        that((date_interval)($YEAR_1 + $MONTH_1 + $DAY_1 + 123456, $format))->is('01Y/1M/2D T 20H:17I:36S');
        that((date_interval)(12345, $format))->is('03H:25I:45S');
        that((date_interval)(1234, $format))->is('20I:34S');
        that((date_interval)(12, $format))->is('12S');

        that((date_interval)(123.456))->isInstanceOf(\DateInterval::class);

        that(date_interval)(0, '', 2)->wasThrown('$format must be array');
        that(date_interval)(1, [], 2)->wasThrown('$format is empty');
    }

    function test_date_alter()
    {
        // 順番に依存しないようにシャッフルしておく
        $holidays = (array_shuffle)([
            '2022-04-29' => '昭和の日',
            '2022-04-30' => '所定休日',
            '2022-05-01' => '法定休日',
            '2022-05-03' => '憲法記念日',
            '2022-05-04' => 'みどりの日',
            '2022-05-05' => 'こどもの日',
            '2022-05-07' => '所定休日',
            '2022-05-08' => '法定休日',
        ]);

        that((date_alter)('2022/04/28', $holidays, -3))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, -3))->is('2022-04-28');
        that((date_alter)('2022/04/30', $holidays, -3))->is('2022-04-28');
        that((date_alter)('2022/05/01', $holidays, -3))->is('2022-04-28');
        that((date_alter)('2022/05/02', $holidays, -3))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, -3))->is('2022-05-02');
        that((date_alter)('2022/05/04', $holidays, -3))->is('2022-05-02');
        that((date_alter)('2022/05/05', $holidays, -3))->is('2022-05-02');
        that((date_alter)('2022/05/06', $holidays, -3))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, -3))->is('2022-05-06');
        that((date_alter)('2022/05/08', $holidays, -3))->is('2022-05-06');
        that((date_alter)('2022/05/09', $holidays, -3))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, -2))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, -2))->is('2022-04-28');
        that((date_alter)('2022/04/30', $holidays, -2))->is('2022-04-28');
        that((date_alter)('2022/05/01', $holidays, -2))->is(null);
        that((date_alter)('2022/05/02', $holidays, -2))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, -2))->is('2022-05-02');
        that((date_alter)('2022/05/04', $holidays, -2))->is('2022-05-02');
        that((date_alter)('2022/05/05', $holidays, -2))->is(null);
        that((date_alter)('2022/05/06', $holidays, -2))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, -2))->is('2022-05-06');
        that((date_alter)('2022/05/08', $holidays, -2))->is('2022-05-06');
        that((date_alter)('2022/05/09', $holidays, -2))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, -1))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, -1))->is('2022-04-28');
        that((date_alter)('2022/04/30', $holidays, -1))->is(null);
        that((date_alter)('2022/05/01', $holidays, -1))->is(null);
        that((date_alter)('2022/05/02', $holidays, -1))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, -1))->is('2022-05-02');
        that((date_alter)('2022/05/04', $holidays, -1))->is(null);
        that((date_alter)('2022/05/05', $holidays, -1))->is(null);
        that((date_alter)('2022/05/06', $holidays, -1))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, -1))->is('2022-05-06');
        that((date_alter)('2022/05/08', $holidays, -1))->is(null);
        that((date_alter)('2022/05/09', $holidays, -1))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, 0))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, 0))->is(null);
        that((date_alter)('2022/04/30', $holidays, 0))->is(null);
        that((date_alter)('2022/05/01', $holidays, 0))->is(null);
        that((date_alter)('2022/05/02', $holidays, 0))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, 0))->is(null);
        that((date_alter)('2022/05/04', $holidays, 0))->is(null);
        that((date_alter)('2022/05/05', $holidays, 0))->is(null);
        that((date_alter)('2022/05/06', $holidays, 0))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, 0))->is(null);
        that((date_alter)('2022/05/08', $holidays, 0))->is(null);
        that((date_alter)('2022/05/09', $holidays, 0))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, +1))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, +1))->is(null);
        that((date_alter)('2022/04/30', $holidays, +1))->is(null);
        that((date_alter)('2022/05/01', $holidays, +1))->is('2022-05-02');
        that((date_alter)('2022/05/02', $holidays, +1))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, +1))->is(null);
        that((date_alter)('2022/05/04', $holidays, +1))->is(null);
        that((date_alter)('2022/05/05', $holidays, +1))->is('2022-05-06');
        that((date_alter)('2022/05/06', $holidays, +1))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, +1))->is(null);
        that((date_alter)('2022/05/08', $holidays, +1))->is('2022-05-09');
        that((date_alter)('2022/05/09', $holidays, +1))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, +2))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, +2))->is(null);
        that((date_alter)('2022/04/30', $holidays, +2))->is('2022-05-02');
        that((date_alter)('2022/05/01', $holidays, +2))->is('2022-05-02');
        that((date_alter)('2022/05/02', $holidays, +2))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, +2))->is(null);
        that((date_alter)('2022/05/04', $holidays, +2))->is('2022-05-06');
        that((date_alter)('2022/05/05', $holidays, +2))->is('2022-05-06');
        that((date_alter)('2022/05/06', $holidays, +2))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, +2))->is('2022-05-09');
        that((date_alter)('2022/05/08', $holidays, +2))->is('2022-05-09');
        that((date_alter)('2022/05/09', $holidays, +2))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, +3))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, +3))->is('2022-05-02');
        that((date_alter)('2022/04/30', $holidays, +3))->is('2022-05-02');
        that((date_alter)('2022/05/01', $holidays, +3))->is('2022-05-02');
        that((date_alter)('2022/05/02', $holidays, +3))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, +3))->is('2022-05-06');
        that((date_alter)('2022/05/04', $holidays, +3))->is('2022-05-06');
        that((date_alter)('2022/05/05', $holidays, +3))->is('2022-05-06');
        that((date_alter)('2022/05/06', $holidays, +3))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, +3))->is('2022-05-09');
        that((date_alter)('2022/05/08', $holidays, +3))->is('2022-05-09');
        that((date_alter)('2022/05/09', $holidays, +3))->is('2022-05-09');

        that((date_alter)('2022/04/28', $holidays, null))->is('2022-04-28');
        that((date_alter)('2022/04/29', $holidays, null))->is('2022-04-29');
        that((date_alter)('2022/04/30', $holidays, null))->is('2022-04-30');
        that((date_alter)('2022/05/01', $holidays, null))->is('2022-05-01');
        that((date_alter)('2022/05/02', $holidays, null))->is('2022-05-02');
        that((date_alter)('2022/05/03', $holidays, null))->is('2022-05-03');
        that((date_alter)('2022/05/04', $holidays, null))->is('2022-05-04');
        that((date_alter)('2022/05/05', $holidays, null))->is('2022-05-05');
        that((date_alter)('2022/05/06', $holidays, null))->is('2022-05-06');
        that((date_alter)('2022/05/07', $holidays, null))->is('2022-05-07');
        that((date_alter)('2022/05/08', $holidays, null))->is('2022-05-08');
        that((date_alter)('2022/05/09', $holidays, null))->is('2022-05-09');
    }
}
