<?php

namespace ryunosuke\Test\Package;

class DateTest extends AbstractTestCase
{
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
