<?php

namespace ryunosuke\Test\Package;

class DateTest extends AbstractTestCase
{
    function test_date_timestamp()
    {
        // テストがコケてタイムスタンプが出力されても分かりにくすぎるので文字列化してテストする
        $test = function ($val) {
            $timestamp = (date_timestamp)($val);
            if ($timestamp === null) {
                return null;
            }
            list($second, $micro) = explode('.', $timestamp) + [1 => '000000'];
            return date('Y/m/d H:i:s', $second) . ".$micro";
        };

        // 割と普通のやつ
        $this->assertEquals('2014/12/24 12:34:56.000000', $test('2014/12/24 12:34:56'));
        $this->assertEquals('2014/12/24 00:00:00.000000', $test('2014/12/24'));
        // 日本語
        $this->assertEquals('2014/12/24 12:34:56.000000', $test('西暦2014年12月24日12時34分56秒'));
        $this->assertEquals('2014/12/24 00:00:00.000000', $test('西暦2014年12月24日'));
        // 西暦なし
        $this->assertEquals('2014/12/24 12:34:56.000000', $test('2014年12月24日12時34分56秒'));
        $this->assertEquals('2014/12/24 00:00:00.000000', $test('2014年12月24日'));
        // 和暦
        $this->assertEquals('1956/12/24 12:34:56.000000', $test('昭和31年12月24日 12時34分56秒'));
        $this->assertEquals('1956/12/24 00:00:00.000000', $test('昭和31年12月24日'));
        $this->assertEquals('2019/12/24 12:34:56.000000', $test('令和元年12月24日 12時34分56秒'));
        $this->assertEquals('2019/12/24 00:00:00.000000', $test('令和元年12月24日'));
        // 数値X桁
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('2014'));
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('西暦2014'));
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('平成26'));
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('2014年'));
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('西暦2014年'));
        $this->assertEquals('2014/01/01 00:00:00.000000', $test('平成26年'));
        // マイクロ秒
        $this->assertEquals('2009/02/14 08:31:30.000000', $test(1234567890));
        $this->assertEquals('2009/02/14 08:31:30.000000', $test('1234567890'));
        $this->assertEquals('2009/02/14 08:31:30.789', $test(1234567890.789));
        $this->assertEquals('2009/02/14 08:31:30.789', $test('1234567890.789'));
        $this->assertEquals('2014/12/24 12:34:56.789', $test('2014/12/24 12:34:56.789'));
        $this->assertEquals('1956/12/24 12:34:56.789', $test('昭和31年12月24日 12時34分56.789秒'));
        // 相対指定
        $this->assertEquals('2012/02/28 12:34:56.000000', $test('2012/01/28 12:34:56 +1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/01/29 12:34:56 +1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/01/30 12:34:56 +1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/01/31 12:34:56 +1 month'));
        $this->assertEquals('2012/03/01 12:34:56.000000', $test('2012/02/01 12:34:56 +1 month'));
        $this->assertEquals('2012/02/28 12:34:56.000000', $test('2011/12/28 12:34:56 +2 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2011/12/29 12:34:56 +2 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2011/12/30 12:34:56 +2 month'));
        $this->assertEquals('2012/03/01 12:34:56.000000', $test('2012/01/01 12:34:56 +2 month'));
        $this->assertEquals('2012/03/01 12:34:56.000000', $test('2012/04/01 12:34:56 -1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/03/31 12:34:56 -1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/03/30 12:34:56 -1 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/03/29 12:34:56 -1 month'));
        $this->assertEquals('2012/02/28 12:34:56.000000', $test('2012/03/28 12:34:56 -1 month'));
        $this->assertEquals('2012/03/01 12:34:56.000000', $test('2012/05/01 12:34:56 -2 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/04/30 12:34:56 -2 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2012/04/29 12:34:56 -2 month'));
        $this->assertEquals('2012/02/28 12:34:56.000000', $test('2012/04/28 12:34:56 -2 month'));
        $this->assertEquals('2012/04/28 12:34:56.000000', $test('2011/04/28 12:34:56 +12 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2011/01/31 12:34:56 +13 month'));
        $this->assertEquals('2012/04/28 12:34:56.000000', $test('2013/04/28 12:34:56 -12 month'));
        $this->assertEquals('2012/02/29 12:34:56.000000', $test('2013/03/31 12:34:56 -13 month'));
        $this->assertEquals('2021/04/28 12:34:56.000000', $test('2011/04/28 12:34:56 +120 month'));
        $this->assertEquals('2022/01/31 12:34:56.000000', $test('2011/01/31 12:34:56 +132 month'));
        $this->assertEquals('2003/04/28 12:34:56.000000', $test('2013/04/28 12:34:56 -120 month'));
        $this->assertEquals('2002/03/31 12:34:56.000000', $test('2013/03/31 12:34:56 -132 month'));
        // 月がメインなのでほかはさっと流す
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2011/12/24 12:34:56 +1 year'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2013/12/24 12:34:56 -1 year'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/23 12:34:56 +1 day'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/25 12:34:56 -1 day'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 11:34:56 +1 hour'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 13:34:56 -1 hour'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 12:33:56 +1 minute'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 12:35:56 -1 minute'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 12:34:55 +1 second'));
        $this->assertEquals('2012/12/24 12:34:56.000000', $test('2012/12/24 12:34:57 -1 second'));
        // 不正系
        $this->assertEquals(null, $test('hogera'));     // 明らかにヤバイ1
        $this->assertEquals(null, $test('9999/99/99')); // 明らかにヤバイ2
        $this->assertEquals(null, $test('2014/2/29'));  // 閏日でない
        $this->assertEquals(null, $test('2014/12/24 12:34:70'));  // 秒が不正
    }

    function test_date_convert()
    {
        $this->assertEquals('2009/02/14 08:31:30', (date_convert)('Y/m/d H:i:s', 1234567890));
        $this->assertEquals('2009/02/14 08:31:30', (date_convert)('Y/m/d H:i:s', 1234567890.123));
        $this->assertEquals('2009/02/14 08:31:30.000000', (date_convert)('Y/m/d H:i:s.u', 1234567890));
        $this->assertEquals('2009/02/14 08:31:30.123000', (date_convert)('Y/m/d H:i:s.u', 1234567890.123));
        $this->assertEquals('2014/12/24 12:34:56.123000', (date_convert)('Y/m/d H:i:s.u', '2014/12/24 12:34:56.123'));
        $this->assertEquals('2019/12/24 12:34:56.123000', (date_convert)('Y/m/d H:i:s.u', '令和元年12月24日 12時34分56.123秒'));
        $this->assertEquals('2019/12/24 12:34:56.123000', (date_convert)('Y/m/d H:i:s.u', \DateTime::createFromFormat('Y/m/d H:i:s.u', '2019/12/24 12:34:56.123')));

        $this->assertEquals(date('Y/m/d H:i:s'), (date_convert)('Y/m/d H:i:s')); // microtime はテストがつらすぎるので u を付けない

        $this->assertEquals('明治41年12月24日', (date_convert)('Jk年m月d日', '1908/12/24'));
        $this->assertEquals('大正12年12月24日', (date_convert)('Jk年m月d日', '1923/12/24'));
        $this->assertEquals('昭和37年12月24日', (date_convert)('Jk年m月d日', '1962/12/24'));
        $this->assertEquals('平成元年12月24日', (date_convert)('JK年m月d日', '1989/12/24'));
        $this->assertEquals('R元年12月24日', (date_convert)('bK年m月d日', '2019/12/24'));
        $this->assertEquals('令和1年12月24日（火曜日）', (date_convert)('Jk年m月d日（x曜日）', '2019/12/24'));
        $this->assertEquals('YJKkbx', (date_convert)('\\Y\\J\\K\\k\\b\\x', '2019/12/24'));

        $this->assertException('parse failed', date_convert, 'Y/m/d H:i:s.u', 'hogera');
        $this->assertException('notfound JP_ERA', date_convert, 'JY/m/d H:i:s.u', '1200/12/23');
    }

    function test_date_interval()
    {
        $HOUR_1 = 60 * 60;
        $DAY_1 = $HOUR_1 * 24;
        $MONTH_1 = $DAY_1 * (365 / 12);
        $YEAR_1 = $DAY_1 * 365;
        $this->assertEquals('00/11/29', (date_interval)($DAY_1 * 364, '%Y/%M/%D'));
        $this->assertEquals('01/00/00', (date_interval)($DAY_1 * 365, '%Y/%M/%D'));
        $this->assertEquals('01/00/01', (date_interval)($DAY_1 * 366, '%Y/%M/%D'));
        $this->assertEquals('01/11/29', (date_interval)($DAY_1 * 364 + $YEAR_1, '%Y/%M/%D'));
        $this->assertEquals('02/00/00', (date_interval)($DAY_1 * 365 + $YEAR_1, '%Y/%M/%D'));
        $this->assertEquals('02/00/01', (date_interval)($DAY_1 * 366 + $YEAR_1, '%Y/%M/%D'));

        $this->assertEquals('00/00/29', (date_interval)($DAY_1 * 29, '%Y/%M/%D'));
        $this->assertEquals('00/00/30', (date_interval)($DAY_1 * 30, '%Y/%M/%D'));
        $this->assertEquals('00/01/00', (date_interval)($DAY_1 * 31, '%Y/%M/%D'));
        $this->assertEquals('00/01/29', (date_interval)($DAY_1 * 29 + $MONTH_1, '%Y/%M/%D'));
        $this->assertEquals('00/01/30', (date_interval)($DAY_1 * 30 + $MONTH_1, '%Y/%M/%D'));
        $this->assertEquals('00/02/00', (date_interval)($DAY_1 * 31 + $MONTH_1, '%Y/%M/%D'));

        $this->assertEquals('00/00/00', (date_interval)($DAY_1 - 1, '%Y/%M/%D'));
        $this->assertEquals('00/00/01', (date_interval)($DAY_1 + 0, '%Y/%M/%D'));
        $this->assertEquals('00/00/02', (date_interval)($DAY_1 + $DAY_1, '%Y/%M/%D'));

        $this->assertEquals('00:59:59', (date_interval)($HOUR_1 - 1, '%H:%I:%S'));
        $this->assertEquals('01:00:00', (date_interval)($HOUR_1 + 0, '%H:%I:%S'));
        $this->assertEquals('01:00:01', (date_interval)($HOUR_1 + 1, '%H:%I:%S'));

        $this->assertEquals('456', (date_interval)(123.456, '%v'));
        $this->assertEquals('%v%', (date_interval)(123.456, '%%v%%'));

        $this->assertEquals('01/01/09 03:25:45.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'y'));
        $this->assertEquals('00/13/09 03:25:45.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'));
        $this->assertEquals('00/00/405 03:25:45.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'd'));
        $this->assertEquals('00/00/00 9723:25:45.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'h'));
        $this->assertEquals('00/00/00 00:583405:45.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'i'));
        $this->assertEquals('00/00/00 00:00:35004345.678', (date_interval)($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 's'));

        $this->assertEquals('678,45,25,3,18,5,2,0', (date_interval)(60 * 60 * 24 * 900 + 12345.678, function () { return implode(',', func_get_args()); }, 'c'));


        $format = [
            'c' => ['%c century', ' '],
            'y' => ['%y year', ' '],
            'm' => ['%m month', ' '],
            'd' => ['%d days', ' '],
            'h' => ['%h hours', ' '],
            'i' => ['%i minute', ' '],
            's' => ['%s seconds', ''],
        ];
        $this->assertEquals('0 hours 0 minute 0 seconds', (date_interval)(0, $format, 3));
        $this->assertEquals('0 hours 0 minute 59 seconds', (date_interval)(60 - 1, $format, 3));
        $this->assertEquals('0 hours 1 minute 0 seconds', (date_interval)(60 - 0, $format, 3));
        $this->assertEquals('0 hours 59 minute 59 seconds', (date_interval)(60 * 60 - 1, $format, 3));
        $this->assertEquals('1 hours 0 minute 0 seconds', (date_interval)(60 * 60 - 0, $format, 3));
        $this->assertEquals('23 hours 59 minute 59 seconds', (date_interval)(60 * 60 * 24 - 1, $format, 3));
        $this->assertEquals('1 days 0 hours 0 minute', (date_interval)(60 * 60 * 24 - 0, $format, 3));
        $this->assertEquals('30 days 9 hours 59 minute', (date_interval)(60 * 60 * 24 * (365 / 12) - 1, $format, 3));
        $this->assertEquals('1 month 0 days 0 hours', (date_interval)(60 * 60 * 24 * 31, $format, 3));
        $this->assertEquals('11 month 30 days 23 hours', (date_interval)(60 * 60 * 24 * 365 - 1, $format, 3));
        $this->assertEquals('1 year 0 month 0 days', (date_interval)(60 * 60 * 24 * 365 - 0, $format, 3));
        $this->assertEquals('99 year 11 month 30 days', (date_interval)(60 * 60 * 24 * 365 * 100 - 1, $format, 3));
        $this->assertEquals('1 century 0 year 0 month', (date_interval)(60 * 60 * 24 * 365 * 100 - 0, $format, 3));

        $this->assertEquals('59 seconds', (date_interval)(59, $format, 1));
        $this->assertEquals('59 minute', (date_interval)($HOUR_1 - 1, $format, 1));
        $this->assertEquals('23 hours', (date_interval)($DAY_1 - 1, $format, 1));
        $this->assertEquals('30 days', (date_interval)($MONTH_1 - 1, $format, 1));
        $this->assertEquals('11 month', (date_interval)($YEAR_1 - 1, $format, 1));
        $this->assertEquals('1 year', (date_interval)($YEAR_1, $format, 1));
        $this->assertEquals('1 century', (date_interval)($YEAR_1 * 100, $format, 1));

        $format = [
            'y' => ['%YY', '/'],
            'm' => ['', '%mM', '/'],
            'd' => ['%dD', '/'],
            ' T ',
            'h' => ['%HH', ':'],
            'i' => ['%II', ':'],
            's' => ['%SS'],
        ];
        $this->assertEquals('01Y', (date_interval)($YEAR_1, $format));
        $this->assertEquals('01Y/30D', (date_interval)($YEAR_1 + $MONTH_1 - $HOUR_1 * 10, $format));
        $this->assertEquals('01Y/1M', (date_interval)($YEAR_1 + $MONTH_1 + $DAY_1 - $HOUR_1 * 10, $format));
        $this->assertEquals('01Y/1M/2D T 20H:17I:36S', (date_interval)($YEAR_1 + $MONTH_1 + $DAY_1 + 123456, $format));
        $this->assertEquals('03H:25I:45S', (date_interval)(12345, $format));
        $this->assertEquals('20I:34S', (date_interval)(1234, $format));
        $this->assertEquals('12S', (date_interval)(12, $format));

        $this->assertInstanceOf(\DateInterval::class, (date_interval)(123.456));

        $this->assertException('$format must be array', date_interval, 0, '', 2);
        $this->assertException('$format is empty', date_interval, 1, [], 2);
    }
}
