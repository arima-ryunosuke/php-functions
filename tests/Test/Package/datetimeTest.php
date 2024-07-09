<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\array_shuffle;
use function ryunosuke\Functions\Package\date_alter;
use function ryunosuke\Functions\Package\date_convert;
use function ryunosuke\Functions\Package\date_fromto;
use function ryunosuke\Functions\Package\date_interval;
use function ryunosuke\Functions\Package\date_interval_second;
use function ryunosuke\Functions\Package\date_interval_string;
use function ryunosuke\Functions\Package\date_match;
use function ryunosuke\Functions\Package\date_modulate;
use function ryunosuke\Functions\Package\date_parse_format;
use function ryunosuke\Functions\Package\date_timestamp;
use function ryunosuke\Functions\Package\date_validate;
use function ryunosuke\Functions\Package\now;

class datetimeTest extends AbstractTestCase
{
    function test_date_alter()
    {
        // 順番に依存しないようにシャッフルしておく
        $holidays = array_shuffle([
            '2022-04-29' => '昭和の日',
            '2022-04-30' => '所定休日',
            '2022-05-01' => '法定休日',
            '2022-05-03' => '憲法記念日',
            '2022-05-04' => 'みどりの日',
            '2022-05-05' => 'こどもの日',
            '2022-05-07' => '所定休日',
            '2022-05-08' => '法定休日',
        ]);

        that(date_alter('2022/04/28', $holidays, -3))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, -3))->is('2022-04-28');
        that(date_alter('2022/04/30', $holidays, -3))->is('2022-04-28');
        that(date_alter('2022/05/01', $holidays, -3))->is('2022-04-28');
        that(date_alter('2022/05/02', $holidays, -3))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, -3))->is('2022-05-02');
        that(date_alter('2022/05/04', $holidays, -3))->is('2022-05-02');
        that(date_alter('2022/05/05', $holidays, -3))->is('2022-05-02');
        that(date_alter('2022/05/06', $holidays, -3))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, -3))->is('2022-05-06');
        that(date_alter('2022/05/08', $holidays, -3))->is('2022-05-06');
        that(date_alter('2022/05/09', $holidays, -3))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, -2))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, -2))->is('2022-04-28');
        that(date_alter('2022/04/30', $holidays, -2))->is('2022-04-28');
        that(date_alter('2022/05/01', $holidays, -2))->is(null);
        that(date_alter('2022/05/02', $holidays, -2))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, -2))->is('2022-05-02');
        that(date_alter('2022/05/04', $holidays, -2))->is('2022-05-02');
        that(date_alter('2022/05/05', $holidays, -2))->is(null);
        that(date_alter('2022/05/06', $holidays, -2))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, -2))->is('2022-05-06');
        that(date_alter('2022/05/08', $holidays, -2))->is('2022-05-06');
        that(date_alter('2022/05/09', $holidays, -2))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, -1))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, -1))->is('2022-04-28');
        that(date_alter('2022/04/30', $holidays, -1))->is(null);
        that(date_alter('2022/05/01', $holidays, -1))->is(null);
        that(date_alter('2022/05/02', $holidays, -1))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, -1))->is('2022-05-02');
        that(date_alter('2022/05/04', $holidays, -1))->is(null);
        that(date_alter('2022/05/05', $holidays, -1))->is(null);
        that(date_alter('2022/05/06', $holidays, -1))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, -1))->is('2022-05-06');
        that(date_alter('2022/05/08', $holidays, -1))->is(null);
        that(date_alter('2022/05/09', $holidays, -1))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, 0))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, 0))->is(null);
        that(date_alter('2022/04/30', $holidays, 0))->is(null);
        that(date_alter('2022/05/01', $holidays, 0))->is(null);
        that(date_alter('2022/05/02', $holidays, 0))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, 0))->is(null);
        that(date_alter('2022/05/04', $holidays, 0))->is(null);
        that(date_alter('2022/05/05', $holidays, 0))->is(null);
        that(date_alter('2022/05/06', $holidays, 0))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, 0))->is(null);
        that(date_alter('2022/05/08', $holidays, 0))->is(null);
        that(date_alter('2022/05/09', $holidays, 0))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, +1))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, +1))->is(null);
        that(date_alter('2022/04/30', $holidays, +1))->is(null);
        that(date_alter('2022/05/01', $holidays, +1))->is('2022-05-02');
        that(date_alter('2022/05/02', $holidays, +1))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, +1))->is(null);
        that(date_alter('2022/05/04', $holidays, +1))->is(null);
        that(date_alter('2022/05/05', $holidays, +1))->is('2022-05-06');
        that(date_alter('2022/05/06', $holidays, +1))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, +1))->is(null);
        that(date_alter('2022/05/08', $holidays, +1))->is('2022-05-09');
        that(date_alter('2022/05/09', $holidays, +1))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, +2))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, +2))->is(null);
        that(date_alter('2022/04/30', $holidays, +2))->is('2022-05-02');
        that(date_alter('2022/05/01', $holidays, +2))->is('2022-05-02');
        that(date_alter('2022/05/02', $holidays, +2))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, +2))->is(null);
        that(date_alter('2022/05/04', $holidays, +2))->is('2022-05-06');
        that(date_alter('2022/05/05', $holidays, +2))->is('2022-05-06');
        that(date_alter('2022/05/06', $holidays, +2))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, +2))->is('2022-05-09');
        that(date_alter('2022/05/08', $holidays, +2))->is('2022-05-09');
        that(date_alter('2022/05/09', $holidays, +2))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, +3))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, +3))->is('2022-05-02');
        that(date_alter('2022/04/30', $holidays, +3))->is('2022-05-02');
        that(date_alter('2022/05/01', $holidays, +3))->is('2022-05-02');
        that(date_alter('2022/05/02', $holidays, +3))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, +3))->is('2022-05-06');
        that(date_alter('2022/05/04', $holidays, +3))->is('2022-05-06');
        that(date_alter('2022/05/05', $holidays, +3))->is('2022-05-06');
        that(date_alter('2022/05/06', $holidays, +3))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, +3))->is('2022-05-09');
        that(date_alter('2022/05/08', $holidays, +3))->is('2022-05-09');
        that(date_alter('2022/05/09', $holidays, +3))->is('2022-05-09');

        that(date_alter('2022/04/28', $holidays, null))->is('2022-04-28');
        that(date_alter('2022/04/29', $holidays, null))->is('2022-04-29');
        that(date_alter('2022/04/30', $holidays, null))->is('2022-04-30');
        that(date_alter('2022/05/01', $holidays, null))->is('2022-05-01');
        that(date_alter('2022/05/02', $holidays, null))->is('2022-05-02');
        that(date_alter('2022/05/03', $holidays, null))->is('2022-05-03');
        that(date_alter('2022/05/04', $holidays, null))->is('2022-05-04');
        that(date_alter('2022/05/05', $holidays, null))->is('2022-05-05');
        that(date_alter('2022/05/06', $holidays, null))->is('2022-05-06');
        that(date_alter('2022/05/07', $holidays, null))->is('2022-05-07');
        that(date_alter('2022/05/08', $holidays, null))->is('2022-05-08');
        that(date_alter('2022/05/09', $holidays, null))->is('2022-05-09');
    }

    function test_date_convert()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        {
            that(date_convert(\DateTimeImmutable::class, -0.1))
                ->isInstanceOf(\DateTimeImmutable::class)
                ->format('Y/m/d H:i:s.u')->is('1970/01/01 08:59:59.900000');
            that(date_convert(null, \DateTime::createFromFormat('U', 0)))
                ->isInstanceOf(\DateTime::class)
                ->format('Y/m/d H:i:s.u')->is('1970/01/01 00:00:00.000000');
        }

        that(date_convert('Y/m/d H:i:s.u', 0.1))->is('1970/01/01 09:00:00.100000');
        that(date_convert('Y/m/d H:i:s.u', 1.1))->is('1970/01/01 09:00:01.100000');
        that(date_convert('Y/m/d H:i:s.u', -0.1))->is('1970/01/01 08:59:59.900000');
        that(date_convert('Y/m/d H:i:s.u', -1.1))->is('1970/01/01 08:59:58.900000');

        that(date_convert('Y/m/d H:i:s', 1234567890))->is('2009/02/14 08:31:30');
        that(date_convert('Y/m/d H:i:s', 1234567890.123))->is('2009/02/14 08:31:30');
        that(date_convert('Y/m/d H:i:s.u', 1234567890))->is('2009/02/14 08:31:30.000000');
        that(date_convert('Y/m/d H:i:s.u', 1234567890.123))->is('2009/02/14 08:31:30.122999');
        that(date_convert('Y/m/d H:i:s.u', "1234567890.000"))->is('2009/02/14 08:31:30.000000');
        that(date_convert('Y/m/d H:i:s.u', '2014/12/24 12:34:56.123'))->is('2014/12/24 12:34:56.122999');
        that(date_convert('Y/m/d H:i:s.u', '令和元年12月24日 12時34分56.123秒'))->is('2019/12/24 12:34:56.122999');
        that(date_convert('Y/m/d H:i:s.u', \DateTime::createFromFormat('Y/m/d H:i:s.u', '2019/12/24 12:34:56.123')))->is('2019/12/24 12:34:56.122999');
        that(date_convert('Y/m/d H:i:s.u', \DateTimeImmutable::createFromFormat('Y/m/d H:i:s.u', '2019/12/24 12:34:56.123')))->is('2019/12/24 12:34:56.122999');

        that(date_convert('Y/m/d H:i:s'))->is(date('Y/m/d H:i:s')); // microtime はテストがつらすぎるので u を付けない

        that(date_convert('Jk年m月d日', '1908/12/24'))->is('明治41年12月24日');
        that(date_convert('Jk年m月d日', '1923/12/24'))->is('大正12年12月24日');
        that(date_convert('Jk年m月d日', '1962/12/24'))->is('昭和37年12月24日');
        that(date_convert('JK年m月d日', '1989/12/24'))->is('平成元年12月24日');
        that(date_convert('bK年m月d日', '2019/12/24'))->is('R元年12月24日');
        that(date_convert('Jk年m月d日（x曜日）', '2019/12/24'))->is('令和1年12月24日（火曜日）');
        that(date_convert('x曜日', '2019/12/24 00:00:00'))->is('火曜日');
        that(date_convert('x曜日', '2019/12/24 00:00:00 -1 second'))->is('月曜日');
        that(date_convert('\\Y\\J\\K\\k\\b\\x', '2019/12/24'))->is('YJKkbx');
        that(date_convert('\\J\\\\J\\\\\\J', '2019/12/24'))->is("J\\令和\\J");
        that(date_convert('JJJ', '2019/12/24'))->is("令和令和令和");
        that(date_convert('Q', '2014/03/01'))->is("6");
        that(date_convert('Q', '2014/03/02'))->is("0");
        that(date_convert('Q', '2014/03/03'))->is("1");
        that(date_convert('Q', '2014/03/04'))->is("2");
        that(date_convert('Q', '2014/03/05'))->is("3");
        that(date_convert('Q', '2014/03/06'))->is("4");
        that(date_convert('Q', '2014/03/07'))->is("5");
        that(date_convert('Q', '2014/03/08'))->is("13");
        that(date_convert('Q', '2014/03/09'))->is("7");
        that(date_convert('Q', '2014/03/10'))->is("8");
        that(date_convert('Q', '2014/03/29'))->is("34");
        that(date_convert('Q', '2014/03/30'))->is("28");
        that(date_convert('Q', '2014/03/31'))->is("29");
        that(date_convert('Q', '2000/02/01'))->is("2");
        that(date_convert('Q', '2000/02/28'))->is("22");
        that(date_convert('Q', '2000/02/29'))->is("30");
        that(date_convert('Q', '2004/02/01'))->is("0");
        that(date_convert('Q', '2004/02/28'))->is("27");
        that(date_convert('Q', '2004/02/29'))->is("28");

        foreach (range(1, 28) as $n => $day) {
            that(date_convert('Q', "2015/02/$day"))->is($n);
        }

        that(self::resolveFunction('date_convert'))('Y/m/d H:i:s.u', 'hogera')->wasThrown('parse failed');
        that(self::resolveFunction('date_convert'))('JY/m/d H:i:s.u', '1200/12/23')->wasThrown('notfound JP_ERA');
    }

    function test_date_fromto()
    {
        that(date_fromto('Y/m/d H:i:s', '1999'))->is(['1999/01/01 00:00:00', '2000/01/01 00:00:00']);
        that(date_fromto('Y/m/d H:i:s', '1999/9'))->is(['1999/09/01 00:00:00', '1999/10/01 00:00:00']);
        that(date_fromto('Y/m/d H:i:s', '1999/9/10'))->is(['1999/09/10 00:00:00', '1999/09/11 00:00:00']);
        that(date_fromto('Y/m/d H:i:s', '1999/9/10 11'))->is(['1999/09/10 11:00:00', '1999/09/10 12:00:00']);
        that(date_fromto('Y/m/d H:i:s', '1999/9/10 11:22'))->is(['1999/09/10 11:22:00', '1999/09/10 11:23:00']);
        that(date_fromto('Y/m/d H:i:s', '1999/9/10 11:22:33'))->is(['1999/09/10 11:22:33', '1999/09/10 11:22:34']);
        that(date_fromto('Y/m/d H:i:s.v', '1999/9/10 11:22:33.789'))->is(['1999/09/10 11:22:33.789', '1999/09/10 11:22:34.000']);
        that(date_fromto('Y/m/d H:i:s.v', '1956/9/10 11:22:33.789'))->is(['1956/09/10 11:22:33.789', '1956/09/10 11:22:34.000']);
        that(date_fromto('Y/m/d H:i:s.v', '1969/12/31 23:59:59.999'))->is(['1969/12/31 23:59:59.999', '1970/01/01 00:00:00.000']);
        that(date_fromto('Y/m/d H:i:s.v', '1970/01/01 08:59:59.999'))->is(['1970/01/01 08:59:59.999', '1970/01/01 09:00:00.000']);

        that(date_fromto('Y/m/d H:i:s', '2000/2'))->is(['2000/02/01 00:00:00', '2000/03/01 00:00:00']);
        that(date_fromto('Y/m/d H:i:s', '9/10'))->is([idate('Y') . '/09/10 00:00:00', idate('Y') . '/09/11 00:00:00']);
        that(date_fromto('Y/m/d H:i:s', '999/12/23 123456'))->is(['0999/12/23 12:34:56', '0999/12/23 12:34:57']);

        that(date_fromto('Y-m-d', '2000/2'))->is(['2000-02-01', '2000-03-01']);
        that(date_fromto(null, '2000/2'))->is([949330800, 951836400]);

        that(date_fromto('Y/m/d H:i:s', 'hogehoge'))->is(null);
        that(date_fromto('Y/m/d H:i:s', '/h/o/g/e/'))->is(null);
        that(date_fromto('Y/m/d H:i:s', '2012/23/56'))->is(null);
    }

    function test_date_interval()
    {
        // create モード（ゼロ）
        that(date_interval('P0Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+00-00-00T00:00:00.0');
        that(date_interval('P-0Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+00-00-00T00:00:00.0');
        that(date_interval('P-0Y-0M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+00-00-00T00:00:00.0');

        // create モード（正数）
        that(date_interval('P1Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-00-00T00:00:00.0');
        that(date_interval('P1Y2M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-00T00:00:00.0');
        that(date_interval('P1Y2M3D'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T00:00:00.0');
        that(date_interval('P1Y2M3DT4H'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:00:00.0');
        that(date_interval('P1Y2M3DT4H5M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:00.0');
        that(date_interval('P1Y2M3DT4H5M6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.0');
        that(date_interval('P1Y2M3DT4H5M6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.788999');

        // create モード（負数）
        that(date_interval('P-1Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-00-00T00:00:00.0');
        that(date_interval('P-1Y-2M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-00T00:00:00.0');
        that(date_interval('P-1Y-2M-3D'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T00:00:00.0');
        that(date_interval('P-1Y-2M-3DT-4H'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:00:00.0');
        that(date_interval('P-1Y-2M-3DT-4H-5M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:00.0');
        that(date_interval('P-1Y-2M-3DT-4H-5M-6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:06.0');
        that(date_interval('P-1Y-2M-3DT-4H-5M-6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:06.788999');

        // create モード（全体負数）
        that(date_interval('-P-1Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-00-00T00:00:00.0');
        that(date_interval('-P-1Y-2M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-00T00:00:00.0');
        that(date_interval('-P-1Y-2M-3D'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T00:00:00.0');
        that(date_interval('-P-1Y-2M-3DT-4H'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:00:00.0');
        that(date_interval('-P-1Y-2M-3DT-4H-5M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:00.0');
        that(date_interval('-P-1Y-2M-3DT-4H-5M-6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.0');
        that(date_interval('-P-1Y-2M-3DT-4H-5M-6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+01-02-03T04:05:06.788999');
        that(date_interval('-P1Y'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-00-00T00:00:00.0');
        that(date_interval('-P1Y2M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-00T00:00:00.0');
        that(date_interval('-P1Y2M3D'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T00:00:00.0');
        that(date_interval('-P1Y2M3DT4H'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:00:00.0');
        that(date_interval('-P1Y2M3DT4H5M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:00.0');
        that(date_interval('-P1Y2M3DT4H5M6S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:06.0');
        that(date_interval('-P1Y2M3DT4H5M6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01-02-03T04:05:06.788999');
        that(date_interval('-P-9Y-2M3DT-4H5M-6.789S'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+09-02--3T04:-5:06.788999');

        // create モード（混在）
        that(date_interval('P-1Y11M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01--11-00T00:00:00.0');
        that(date_interval('P-1Y13M'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+-1-13-00T00:00:00.0');
        $base = new \DateTimeImmutable('2014/12/24 12:34:56');
        that($base->add(date_interval('P-1Y11M')))->format('Y/m/d H:i:s.v')->is('2014/11/24 12:34:56.000');
        that($base->add(date_interval('P-1Y13M')))->format('Y/m/d H:i:s.v')->is('2015/01/24 12:34:56.000');
        that($base->add(date_interval('P1Y-12MT-1.234S')))->format('Y/m/d H:i:s.v')->is('2014/12/24 12:34:54.766');

        // 相対モード
        that(date_interval('-1year 11month'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('-01--11-00T00:00:00.0');
        that(date_interval('-1year 13month'))->format('%R%Y-%M-%DT%H:%I:%S.%f')->is('+-1-13-00T00:00:00.0');
        $base = new \DateTimeImmutable('2014/12/24 12:34:56');
        that($base->add(date_interval('-1year 11month')))->format('Y/m/d H:i:s.v')->is('2014/11/24 12:34:56.000');
        that($base->add(date_interval('-1year 13month')))->format('Y/m/d H:i:s.v')->is('2015/01/24 12:34:56.000');
        that($base->add(date_interval('1 year -12month -1second')))->format('Y/m/d H:i:s.v')->is('2014/12/24 12:34:55');

        that(self::resolveFunction('date_interval'))('hoge string')->wasThrown('invalid DateInterval');
    }

    function test_date_interval_second()
    {
        that(date_interval_second('+80'))->is(80);
        that(date_interval_second('-80'))->is(-80);
        that(date_interval_second('+PT80S'))->is(80);
        that(date_interval_second('-PT80S'))->is(-80);

        $s = 1;
        $m = 60 * $s;
        $h = 60 * $m;
        $D = 24 * $h;
        $Y = 365 * $D;

        that(date_interval_second('PT80S'))->is(80 * $s);
        that(date_interval_second('PT70M80S'))->is(70 * $m + 80 * $s);
        that(date_interval_second('PT30H70M80S'))->is(30 * $h + 70 * $m + 80 * $s);
        that(date_interval_second('P40DT30H70M80S'))->is(40 * $D + 30 * $h + 70 * $m + 80 * $s);
        that(date_interval_second('P2Y40DT30H70M80S'))->is(2 * $Y + 40 * $D + 30 * $h + 70 * $m + 80 * $s);

        that(date_interval_second('-PT80S'))->is(-(80 * $s));
        that(date_interval_second('-PT70M80S'))->is(-(70 * $m + 80 * $s));
        that(date_interval_second('-PT30H70M80S'))->is(-(30 * $h + 70 * $m + 80 * $s));
        that(date_interval_second('-P40DT30H70M80S'))->is(-(40 * $D + 30 * $h + 70 * $m + 80 * $s));
        that(date_interval_second('-P2Y40DT30H70M80S'))->is(-($D + 2 * $Y + 40 * $D + 30 * $h + 70 * $m + 80 * $s));

        that(date_interval_second('PT20.123S'))->is(20.123, 0.00001);
        that(date_interval_second('PT20.123S', 3600))->is(20.123, 0.00001);
        that(date_interval_second('-PT20.123S'))->is(-20.123, 0.00001);
        that(date_interval_second('-PT20.123S', 3600))->is(-20.123, 0.00001);

        that(date_interval_second('1minute 1second'))->is(61);
        that(date_interval_second('1minute -59second'))->is(1);
        that(date_interval_second('1month', '2014/11/24'))->is($D * 30);
        that(date_interval_second('1month', '2014/12/24'))->is($D * 31);

        that(date_interval_second('P24M', '1970/01/01 00:00:00'))->is(array_sum([
            31 * $D * 2,
            28 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
        ]));
        that(date_interval_second('P24M', '1972/01/01 00:00:00'))->is(array_sum([
            31 * $D * 2,
            28 * $D * 1 + 29 * $D * 1,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
            30 * $D * 2,
            31 * $D * 2,
        ]));
    }

    function test_date_interval_string()
    {
        $HOUR_1 = 60 * 60;
        $DAY_1 = $HOUR_1 * 24;
        $MONTH_1 = $DAY_1 * (365 / 12);
        $YEAR_1 = $DAY_1 * 365;
        that(date_interval_string($DAY_1 * 364, '%Y/%M/%D'))->is('00/11/29');
        that(date_interval_string($DAY_1 * 365, '%Y/%M/%D'))->is('01/00/00');
        that(date_interval_string($DAY_1 * 366, '%Y/%M/%D'))->is('01/00/01');
        that(date_interval_string($DAY_1 * 364 + $YEAR_1, '%Y/%M/%D'))->is('01/11/29');
        that(date_interval_string($DAY_1 * 365 + $YEAR_1, '%Y/%M/%D'))->is('02/00/00');
        that(date_interval_string($DAY_1 * 366 + $YEAR_1, '%Y/%M/%D'))->is('02/00/01');

        that(date_interval_string($DAY_1 * 29, '%Y/%M/%D'))->is('00/00/29');
        that(date_interval_string($DAY_1 * 30, '%Y/%M/%D'))->is('00/00/30');
        that(date_interval_string($DAY_1 * 31, '%Y/%M/%D'))->is('00/01/00');
        that(date_interval_string($DAY_1 * 29 + $MONTH_1, '%Y/%M/%D'))->is('00/01/29');
        that(date_interval_string($DAY_1 * 30 + $MONTH_1, '%Y/%M/%D'))->is('00/01/30');
        that(date_interval_string($DAY_1 * 31 + $MONTH_1, '%Y/%M/%D'))->is('00/02/00');

        that(date_interval_string($DAY_1 - 1, '%Y/%M/%D'))->is('00/00/00');
        that(date_interval_string($DAY_1 + 0, '%Y/%M/%D'))->is('00/00/01');
        that(date_interval_string($DAY_1 + $DAY_1, '%Y/%M/%D'))->is('00/00/02');

        that(date_interval_string($HOUR_1 - 1, '%H:%I:%S'))->is('00:59:59');
        that(date_interval_string($HOUR_1 + 0, '%H:%I:%S'))->is('01:00:00');
        that(date_interval_string($HOUR_1 + 1, '%H:%I:%S'))->is('01:00:01');

        that(date_interval_string($YEAR_1 * 123 + 4.567, '%c century, %v millisecond', 'c'))->is('1 century, 567 millisecond');
        that(date_interval_string($YEAR_1 * 123 + 4.567, '%%c century, %%v millisecond', 'c'))->is('%c century, %v millisecond');
        that(date_interval_string($YEAR_1 * 123 + 4.567, '%%%c century, %%%v millisecond', 'c'))->is('%1 century, %567 millisecond');

        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'y'))->is('01/01/09 03:25:45.678');
        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'))->is('00/13/09 03:25:45.678');
        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'd'))->is('00/00/405 03:25:45.678');
        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'h'))->is('00/00/00 9723:25:45.678');
        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'i'))->is('00/00/00 00:583405:45.678');
        that(date_interval_string($YEAR_1 + $DAY_1 * 40 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 's'))->is('00/00/00 00:00:35004345.678');

        that(date_interval_string(60 * 60 * 24 * 900 + 12345.678, fn() => implode(',', func_get_args()), 'c'))->is('678,45,25,3,18,5,2,0');

        $format = [
            'c' => ['%c century', ' '],
            'y' => ['%y year', ' '],
            'm' => ['%m month', ' '],
            'd' => ['%d days', ' '],
            'h' => ['%h hours', ' '],
            'i' => ['%i minute', ' '],
            's' => ['%s seconds', ''],
        ];
        that(date_interval_string(0, $format, 3))->is('0 hours 0 minute 0 seconds');
        that(date_interval_string(60 - 1, $format, 3))->is('0 hours 0 minute 59 seconds');
        that(date_interval_string(60 - 0, $format, 3))->is('0 hours 1 minute 0 seconds');
        that(date_interval_string(60 * 60 - 1, $format, 3))->is('0 hours 59 minute 59 seconds');
        that(date_interval_string(60 * 60 - 0, $format, 3))->is('1 hours 0 minute 0 seconds');
        that(date_interval_string(60 * 60 * 24 - 1, $format, 3))->is('23 hours 59 minute 59 seconds');
        that(date_interval_string(60 * 60 * 24 - 0, $format, 3))->is('1 days 0 hours 0 minute');
        that(date_interval_string(60 * 60 * 24 * (365 / 12) - 1, $format, 3))->is('30 days 9 hours 59 minute');
        that(date_interval_string(60 * 60 * 24 * 31, $format, 3))->is('1 month 0 days 0 hours');
        that(date_interval_string(60 * 60 * 24 * 365 - 1, $format, 3))->is('11 month 30 days 23 hours');
        that(date_interval_string(60 * 60 * 24 * 365 - 0, $format, 3))->is('1 year 0 month 0 days');
        that(date_interval_string(60 * 60 * 24 * 365 * 100 - 1, $format, 3))->is('99 year 11 month 30 days');
        that(date_interval_string(60 * 60 * 24 * 365 * 100 - 0, $format, 3))->is('1 century 0 year 0 month');

        that(date_interval_string(59, $format, 1))->is('59 seconds');
        that(date_interval_string($HOUR_1 - 1, $format, 1))->is('59 minute');
        that(date_interval_string($DAY_1 - 1, $format, 1))->is('23 hours');
        that(date_interval_string($MONTH_1 - 1, $format, 1))->is('30 days');
        that(date_interval_string($YEAR_1 - 1, $format, 1))->is('11 month');
        that(date_interval_string($YEAR_1, $format, 1))->is('1 year');
        that(date_interval_string($YEAR_1 * 100, $format, 1))->is('1 century');

        $format = [
            'y' => ['%YY', '/'],
            'm' => ['', '%mM', '/'],
            'd' => ['%dD', '/'],
            ' T ',
            'h' => ['%HH', ':'],
            'i' => ['%II', ':'],
            's' => ['%SS'],
        ];
        that(date_interval_string($YEAR_1, $format))->is('01Y');
        that(date_interval_string($YEAR_1 + $MONTH_1 - $HOUR_1 * 10, $format))->is('01Y/30D');
        that(date_interval_string($YEAR_1 + $MONTH_1 + $DAY_1 - $HOUR_1 * 10, $format))->is('01Y/1M');
        that(date_interval_string($YEAR_1 + $MONTH_1 + $DAY_1 + 123456, $format))->is('01Y/1M/2D T 20H:17I:36S');
        that(date_interval_string(12345, $format))->is('03H:25I:45S');
        that(date_interval_string(1234, $format))->is('20I:34S');
        that(date_interval_string(12, $format))->is('12S');
        that(date_interval_string(date_interval('P1Y2M3DT4H5M6S'), $format))->is('01Y/2M/1D T 04H:05I:06S');

        that(self::resolveFunction('date_interval_string'))(0, '', 2)->wasThrown('$format must be array');
        that(self::resolveFunction('date_interval_string'))(1, [], 2)->wasThrown('$format is empty');
    }

    function test_date_match()
    {
        // 2014年の12月にマッチする
        that(date_match('2014/12/24 12:34:56', '2014/12/*'))->isTrue();
        that(date_match('2014/11/24 12:34:56', '2014/12/*'))->isFalse();
        that(date_match('2015/12/24 12:34:56', '2014/12/*'))->isFalse();

        // 2014年の12月の20日～25日にマッチする
        that(date_match('2014/12/24 12:34:56', '2014/12/20-25'))->isTrue();
        that(date_match('2014/12/26 12:34:56', '2014/12/20-25'))->isFalse();
        that(date_match('2015/12/24 12:34:56', '2014/12/20-25'))->isFalse();

        // 2014年の12月の10,20,30日にマッチする
        that(date_match('2014/12/20 12:34:56', '2014/12/10,20,30'))->isTrue();
        that(date_match('2014/12/24 12:34:56', '2014/12/10,20,30'))->isFalse();
        that(date_match('2015/12/30 12:34:56', '2014/12/10,20,30'))->isFalse();

        // 末日にマッチする
        that(date_match('2014/02/28 12:34:56', '2014/02/L'))->isTrue();
        that(date_match('2014/03/31 12:34:56', '2014/03/L'))->isTrue();
        that(date_match('2012/02/29 12:34:56', '2012/02/99'))->isTrue();
        that(date_match('2014/12/30 12:34:56', '2014/12/L'))->isFalse();
        that(date_match('2012/02/28 12:34:56', '2012/02/L'))->isFalse();

        that(date_match('2012/02/09 12:34:56', '2012/02/09'))->isTrue(); //一桁9は末日ではない
        that(date_match('2011/12/31 12:34:56', '2012/*/L'))->isFalse();
        that(date_match('2012/01/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/02/29 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/03/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/04/30 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/05/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/06/30 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/07/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/08/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/09/30 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/10/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/11/30 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2012/12/31 12:34:56', '2012/*/L'))->isTrue();
        that(date_match('2013/01/31 12:34:56', '2012/*/L'))->isFalse();

        // 2014年の12月の10,20~25,30日にマッチする
        that(date_match('2014/12/24 12:34:56', '2014/12/10,20-25,30'))->isTrue();
        that(date_match('2014/12/26 12:34:56', '2014/12/10,20-25,30'))->isFalse();
        that(date_match('2015/12/26 12:34:56', '2014/12/10,20-25,30'))->isFalse();

        // 2014年の12月の水曜日にマッチする
        that(date_match('2014/12/03 12:34:56', '****/**/**(3)'))->isTrue();
        that(date_match('2014/12/10 12:34:56', '****/**/**(水)'))->isTrue();
        that(date_match('2014/12/17 12:34:56', '****/**/**(水曜日)'))->isTrue();
        that(date_match('2014/12/24 12:34:56', '****/**/**(wed)'))->isTrue();
        that(date_match('2014/12/31 12:34:56', '****/**/**(wednesday)'))->isTrue();
        that(date_match('2014/12/14 12:34:56', '****/**/**(3)'))->isFalse();
        that(date_match('2014/12/09 12:34:56', '****/**/**(3)'))->isFalse();

        // 2014年の12月の平日（月～金）にマッチする
        that(date_match('2014/12/14 12:34:56', '****/**/**(1-5)'))->isFalse();
        that(date_match('2014/12/15 12:34:56', '****/**/**(1-5)'))->isTrue();
        that(date_match('2014/12/16 12:34:56', '****/**/**(1-5)'))->isTrue();
        that(date_match('2014/12/17 12:34:56', '****/**/**(1-5)'))->isTrue();
        that(date_match('2014/12/18 12:34:56', '****/**/**(1-5)'))->isTrue();
        that(date_match('2014/12/19 12:34:56', '****/**/**(1-5)'))->isTrue();
        that(date_match('2014/12/20 12:34:56', '****/**/**(1-5)'))->isFalse();

        // 2014年の12月の第1,3水曜日にマッチする
        that(date_match('2014/12/03 12:34:56', '****/**/**(水#1,水曜日#3)'))->isTrue();
        that(date_match('2014/12/10 12:34:56', '****/**/**(3#1,3#3)'))->isFalse();
        that(date_match('2014/12/17 12:34:56', '****/**/**(wed#1,wednesday#3)'))->isTrue();
        that(date_match('2014/12/24 12:34:56', '****/**/**(3#1,3#3)'))->isFalse();
        that(date_match('2014/12/31 12:34:56', '****/**/**(3#1,3#3)'))->isFalse();

        // 2014年の12月の最終水曜日にマッチする
        that(date_match('2014/12/03 12:34:56', '****/**/**(3#L)'))->isFalse();
        that(date_match('2014/12/10 12:34:56', '****/**/**(3#L)'))->isFalse();
        that(date_match('2014/12/17 12:34:56', '****/**/**(3#L)'))->isFalse();
        that(date_match('2014/12/24 12:34:56', '****/**/**(3#L)'))->isFalse();
        that(date_match('2014/12/31 12:34:56', '****/**/**(3#L)'))->isTrue();
        that(date_match('2014/12/31 12:34:56', '****/**/**(3#9)'))->isTrue();

        // 任意の13日の金曜日にマッチする
        that(date_match('2014/06/13 12:34:56', '****/**/13(fri)'))->isTrue();
        that(date_match('2014/06/14 12:34:56', '****/**/13(5)'))->isFalse();
        that(date_match('2015/06/13 12:34:56', '****/**/13(5)'))->isFalse();

        // 隔週水曜日（奇）
        that(date_match('2014/12/17 12:34:56', '****/**/**(水#o)'))->isFalse();
        that(date_match('2014/12/24 12:34:56', '****/**/**(水#o)'))->isTrue();
        that(date_match('2014/12/31 12:34:56', '****/**/**(水#o)'))->isFalse();
        that(date_match('2015/01/07 12:34:56', '****/**/**(水#o)'))->isTrue();
        that(date_match('2015/01/14 12:34:56', '****/**/**(水#o)'))->isFalse();

        // 隔週水曜日（偶）
        that(date_match('2014/12/17 12:34:56', '****/**/**(水#e)'))->isTrue();
        that(date_match('2014/12/24 12:34:56', '****/**/**(水#e)'))->isFalse();
        that(date_match('2014/12/31 12:34:56', '****/**/**(水#e)'))->isTrue();
        that(date_match('2015/01/07 12:34:56', '****/**/**(水#e)'))->isFalse();
        that(date_match('2015/01/14 12:34:56', '****/**/**(水#e)'))->isTrue();

        // 閏年隔週火曜日（偶奇）
        that(date_match('2000/02/01 12:34:56', '****/**/**(火#e)'))->isTrue();
        that(date_match('2000/02/08 12:34:56', '****/**/**(火#o)'))->isTrue();
        that(date_match('2000/02/15 12:34:56', '****/**/**(火#e)'))->isTrue();
        that(date_match('2000/02/22 12:34:56', '****/**/**(火#o)'))->isTrue();
        that(date_match('2000/02/29 12:34:56', '****/**/**(火#e)'))->isTrue();

        // 任意の12:34にマッチする
        that(date_match('2014/12/24 12:34:56', '****/**/** 12:34'))->isTrue();
        that(date_match('2014/12/25 12:33:56', '****/**/** 12:34'))->isFalse();
        that(date_match('2014/12/26 12:35:56', '****/**/** 12:34'))->isFalse();

        // 2014年の最終金曜日
        that(date_match('2014/01/31', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/02/28', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/03/28', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/04/25', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/05/30', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/06/27', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/07/25', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/08/29', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/09/26', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/10/31', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/11/28', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2014/12/26', '2014/**/**(5#9)'))->isTrue();

        // 最終週
        that(date_match('2014/02/22', '2014/**/**(6#9)'))->isTrue();
        that(date_match('2014/02/28', '2014/**/**(5#9)'))->isTrue();
        that(date_match('2024/02/22', '2024/**/**(4#9)'))->isFalse();
        that(date_match('2024/02/29', '2024/**/**(4#9)'))->isTrue();

        that(self::resolveFunction('date_match'))('hoge', '****/**/**')->wasThrown('failed to parse');
        that(self::resolveFunction('date_match'))('2014/12/24 12:35:56', 'hoge')->wasThrown('failed to parse');
        that(self::resolveFunction('date_match'))('2014/12/24 12:35:56', '****/13/**')->wasThrown('13(1~12)');
    }

    function test_date_modulate()
    {
        that(date_modulate('2014                   ', 1))->isSame('2015');
        that(date_modulate('2014/12                ', 1))->isSame('2015/01');
        that(date_modulate('2014/12/24             ', 1))->isSame('2014/12/25');
        that(date_modulate('2014/12/24 12          ', 1))->isSame('2014/12/24 13');
        that(date_modulate('2014/12/24 12:34       ', 1))->isSame('2014/12/24 12:35');
        that(date_modulate('2014/12/24 12:34:56    ', 1))->isSame('2014/12/24 12:34:57');
        that(date_modulate('2014/12/24 12:34:56.789', 1))->isSame('2014/12/24 12:34:56.790');

        that(date_modulate('1999                   ', '+1'))->isSame('2000');
        that(date_modulate('1999/12                ', '+1'))->isSame('2000/01');
        that(date_modulate('1999/12/31             ', '+1'))->isSame('2000/01/01');
        that(date_modulate('1999/12/31 23          ', '+1'))->isSame('2000/01/01 00');
        that(date_modulate('1999/12/31 23:59       ', '+1'))->isSame('2000/01/01 00:00');
        that(date_modulate('1999/12/31 23:59:59    ', '+1'))->isSame('2000/01/01 00:00:00');
        that(date_modulate('1999/12/31 23:59:59.999', '+1'))->isSame('2000/01/01 00:00:00.000');

        that(date_modulate('1999/12                ', '+14'))->isSame('2001/02');
        that(date_modulate('1999/12/31             ', '+33'))->isSame('2000/02/02');
        that(date_modulate('1999/12/31 23          ', '+26'))->isSame('2000/01/02 01');
        that(date_modulate('1999/12/31 23:59       ', '+62'))->isSame('2000/01/01 01:01');
        that(date_modulate('1999/12/31 23:59:59    ', '+62'))->isSame('2000/01/01 00:01:01');
        that(date_modulate('1999/12/31 23:59:59.999', '+1002'))->isSame('2000/01/01 00:00:01.001');

        that(date_modulate('1999/12                ', 'P1Y2M'))->isSame('2001/02');
        that(date_modulate('1999/12/31             ', 'P1M2D'))->isSame('2000/02/02');
        that(date_modulate('1999/12/31 23          ', 'P1DT2H'))->isSame('2000/01/02 01');
        that(date_modulate('1999/12/31 23:59       ', 'PT1H2M'))->isSame('2000/01/01 01:01');
        that(date_modulate('1999/12/31 23:59:59    ', 'PT1M2S'))->isSame('2000/01/01 00:01:01');
        that(date_modulate('1999/12/31 23:59:59.999', 'PT1.002S'))->isSame('2000/01/01 00:00:01.001');

        that(date_modulate('2000                   ', '-1'))->isSame('1999');
        that(date_modulate('2000/01                ', '-1'))->isSame('1999/12');
        that(date_modulate('2000/01/01             ', '-1'))->isSame('1999/12/31');
        that(date_modulate('2000/01/01 00          ', '-1'))->isSame('1999/12/31 23');
        that(date_modulate('2000/01/01 00:00       ', '-1'))->isSame('1999/12/31 23:59');
        that(date_modulate('2000/01/01 00:00:00    ', '-1'))->isSame('1999/12/31 23:59:59');
        that(date_modulate('2000/01/01 00:00:00.000', '-1'))->isSame('1999/12/31 23:59:59.999');

        that(date_modulate('2001/02                ', '-14'))->isSame('1999/12');
        that(date_modulate('2000/02/02             ', '-33'))->isSame('1999/12/31');
        that(date_modulate('2000/01/02 01          ', '-26'))->isSame('1999/12/31 23');
        that(date_modulate('2000/01/01 01:01       ', '-62'))->isSame('1999/12/31 23:59');
        that(date_modulate('2000/01/01 00:01:01    ', '-62'))->isSame('1999/12/31 23:59:59');
        that(date_modulate('2000/01/01 00:00:01.001', '-1002'))->isSame('1999/12/31 23:59:59.999');

        that(date_modulate('2001/02                ', '-P1Y2M'))->isSame('1999/12');
        that(date_modulate('2000/02/02             ', '-P1M2D'))->isSame('1999/12/31');
        that(date_modulate('2000/01/02 01          ', '-P1DT2H'))->isSame('1999/12/31 23');
        that(date_modulate('2000/01/01 01:01       ', '-PT1H2M'))->isSame('1999/12/31 23:59');
        that(date_modulate('2000/01/01 00:01:01    ', '-PT1M2S'))->isSame('1999/12/31 23:59:59');
        that(date_modulate('2000/01/01 00:00:01.001', '-PT1.002S'))->isSame('1999/12/31 23:59:59.999');

        that(self::resolveFunction('date_modulate'))('', 1)->wasThrown('failed parse date format');
        that(self::resolveFunction('date_modulate'))('hoge', 1)->wasThrown('failed parse date format');
        that(self::resolveFunction('date_modulate'))('99999', 1)->wasThrown('failed parse date format');
    }

    function test_date_parse_format()
    {
        // 数値系
        that(date_parse_format('20020202123456       '))->is('YmdHis');
        that(date_parse_format('20020202123456.789   '))->is('YmdHis.v');
        that(date_parse_format('20020202123456.789123'))->is('YmdHis.u');

        // RFC 3339（基本）
        that(date_parse_format('2002                  '))->is('Y');
        that(date_parse_format('200202                '))->is('Ym');
        that(date_parse_format('20020202              '))->is('Ymd');
        that(date_parse_format('20020202T12           '))->is('Ymd\TH');
        that(date_parse_format('20020202T1234         '))->is('Ymd\THi');
        that(date_parse_format('20020202T123456       '))->is('Ymd\THis');
        that(date_parse_format('20020202T123456.789   '))->is('Ymd\THis.v');
        that(date_parse_format('20020202T123456.789123'))->is('Ymd\THis.u');

        // RFC 3339（拡張）
        that(date_parse_format('2002                      '))->is('Y');
        that(date_parse_format('2002-02                   '))->is('Y-m');
        that(date_parse_format('2002-02-02                '))->is('Y-m-d');
        that(date_parse_format('2002-02-02T12             '))->is('Y-m-d\TH');
        that(date_parse_format('2002-02-02T12:34          '))->is('Y-m-d\TH:i');
        that(date_parse_format('2002-02-02T12:34:56       '))->is('Y-m-d\TH:i:s');
        that(date_parse_format('2002-02-02T12:34:56.789   '))->is('Y-m-d\TH:i:s.v');
        that(date_parse_format('2002-02-02T12:34:56.789123'))->is('Y-m-d\TH:i:s.u');

        // RFC 3339（TZ付き）
        that(date_parse_format('2002-02-02 +0900                 '))->is('Y-m-d O');
        that(date_parse_format('2002-02-02T12:34:56 +0900        '))->is('Y-m-d\TH:i:s O');
        that(date_parse_format('2002-02-02T12:34:56.789 +0900    '))->is('Y-m-d\TH:i:s.v O');
        that(date_parse_format('2002-02-02T12:34:56.789123 +09:00'))->is('Y-m-d\TH:i:s.u P');

        // 全て1の区切り無し
        that(date_parse_format('1111                 '))->is('Y');
        that(date_parse_format('111111               '))->is('Ym');
        that(date_parse_format('11111111             '))->is('Ymd');
        that(date_parse_format('1111111111           '))->is('YmdH');
        that(date_parse_format('111111111111         '))->is('YmdHi');
        that(date_parse_format('11111111111111       '))->is('YmdHis');
        that(date_parse_format('11111111111111.111   '))->is('YmdHis.v');
        that(date_parse_format('11111111111111.111111'))->is('YmdHis.u');

        // 日本式
        that(date_parse_format('2002                      '))->is('Y');
        that(date_parse_format('2002/02                   '))->is('Y/m');
        that(date_parse_format('2002/02/02                '))->is('Y/m/d');
        that(date_parse_format('2002/02/02 12             '))->is('Y/m/d H');
        that(date_parse_format('2002/02/02 12:34          '))->is('Y/m/d H:i');
        that(date_parse_format('2002/02/02 12:34:56       '))->is('Y/m/d H:i:s');
        that(date_parse_format('2002/02/02 12:34:56.789   '))->is('Y/m/d H:i:s.v');
        that(date_parse_format('2002/02/02 12:34:56.789123'))->is('Y/m/d H:i:s.u');

        // 日本式2
        that(date_parse_format('1999                      '))->is('Y');
        that(date_parse_format('1999/02                   '))->is('Y/m');
        that(date_parse_format('1999/02/02                '))->is('Y/m/d');
        that(date_parse_format('1999/02/02 12             '))->is('Y/m/d H');
        that(date_parse_format('1999/02/02 12:34          '))->is('Y/m/d H:i');
        that(date_parse_format('1999/02/02 12:34:56       '))->is('Y/m/d H:i:s');
        that(date_parse_format('1999/02/02 12:34:56.789   '))->is('Y/m/d H:i:s.v');
        that(date_parse_format('1999/02/02 12:34:56.789123'))->is('Y/m/d H:i:s.u');

        // アメリカ式
        that(date_parse_format('12/24                     '))->is('m/d');
        that(date_parse_format('12/24/2014                '))->is('m/d/Y');
        that(date_parse_format('12/24/2014 12:34:56       '))->is('m/d/Y H:i:s');
        that(date_parse_format('12/24/2014 12:34:56.789   '))->is('m/d/Y H:i:s.v');
        that(date_parse_format('12/24/2014 12:34:56.789123'))->is('m/d/Y H:i:s.u');

        // イギリス式
        that(date_parse_format('24.12.2014 '))->is('d.m.Y');
        that(date_parse_format('24-12-2014 '))->is('d-m-Y');

        // 月名
        that(date_parse_format('2014/jan/24    '))->is('Y/M/d');
        that(date_parse_format('2014/jan/25    '))->is('Y/M/d');

        that(date_parse_format('      jan.24.2014'))->is('M.d.Y');
        that(date_parse_format('      feb.24.2014'))->is('M.d.Y');
        that(date_parse_format('      mar.24.2014'))->is('M.d.Y');
        that(date_parse_format('      apr.24.2014'))->is('M.d.Y');
        that(date_parse_format('      may.24.2014'))->is('M.d.Y');
        that(date_parse_format('      jun.24.2014'))->is('M.d.Y');
        that(date_parse_format('      jul.24.2014'))->is('M.d.Y');
        that(date_parse_format('      aug.24.2014'))->is('M.d.Y');
        that(date_parse_format('      sep.24.2014'))->is('M.d.Y');
        that(date_parse_format('      oct.24.2014'))->is('M.d.Y');
        that(date_parse_format('  january.24.2014'))->is('F.d.Y');
        that(date_parse_format(' february.24.2014'))->is('F.d.Y');
        that(date_parse_format('    march.24.2014'))->is('F.d.Y');
        that(date_parse_format('    april.24.2014'))->is('F.d.Y');
        that(date_parse_format('      may.24.2014'))->is('M.d.Y'); // 3文字なのでどうしようもない
        that(date_parse_format('     june.24.2014'))->is('F.d.Y');
        that(date_parse_format('     july.24.2014'))->is('F.d.Y');
        that(date_parse_format('   august.24.2014'))->is('F.d.Y');
        that(date_parse_format('september.24.2014'))->is('F.d.Y');
        that(date_parse_format('  october.24.2014'))->is('F.d.Y');

        // 序数
        that(date_parse_format(' jan.1st.2014'))->is('M.jS.Y');
        that(date_parse_format(' jan.2nd.2014'))->is('M.jS.Y');
        that(date_parse_format(' jan.3rd.2014'))->is('M.jS.Y');
        that(date_parse_format(' jan.4th.2014'))->is('M.jS.Y');
        that(date_parse_format('jan.01st.2014'))->is('M.dS.Y');
        that(date_parse_format('jan.02nd.2014'))->is('M.dS.Y');
        that(date_parse_format('jan.03rd.2014'))->is('M.dS.Y');
        that(date_parse_format('jan.04th.2014'))->is('M.dS.Y');
        that(date_parse_format('jan.11th.2014'))->is('M.dS.Y');

        // パース不可
        that(date_parse_format('hoge'))->is(null);
        that(date_parse_format('9999/99/99'))->is(null);
        that(date_parse_format('2014/00/30'))->is(null);
        that(date_parse_format('2014/13/30'))->is(null);
        that(date_parse_format('2014/09/31'))->is(null);
        that(date_parse_format('2014/09/30 25:00:00'))->is(null);
        that(date_parse_format('prefix 2002/02/02'))->is(null);
        that(date_parse_format('2002/02/02 suffix'))->is(null);
        that(date_parse_format('wed, 2002/02/02'))->is(null);
        that(date_parse_format('200223'))->is(null);
    }

    function test_date_timestamp()
    {
        // テストがコケてタイムスタンプが出力されても分かりにくすぎるので文字列化してテストする
        $test = function ($val, $base = null) {
            $timestamp = date_timestamp($val, $base);
            if ($timestamp === null) {
                return null;
            }
            [$second, $micro] = explode('.', $timestamp) + [1 => '000000'];
            return date('Y/m/d H:i:s', $second) . ".$micro";
        };

        // 過去
        that(date_timestamp(\DateTime::createFromFormat('U', '0')->modify('+1 millisecond')))->is(0.001);
        that(date_timestamp(\DateTime::createFromFormat('U', '0')->modify('-1 millisecond')))->is(-0.001);

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
        // DateTimeInterface
        that($test(new \DateTime('2014/12/24 12:34:56')))->is('2014/12/24 12:34:56.000000');
        that($test(\DateTime::createFromFormat('U.u', 1234567890.789)))->is('2009/02/14 08:31:30.789');
        // 序数指定（日付）
        that($test('1st day of this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/01/01 12:34:56.000000');
        that($test('2nd day of last month', strtotime('2012/01/31 12:34:56.000000')))->is('2011/12/02 12:34:56.000000');
        that($test('3rd day of next month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/03 12:34:56.000000');
        that($test('4th day of previous month', strtotime('2012/01/31 12:34:56.000000')))->is('2011/12/04 12:34:56.000000');
        // 序数指定（曜日）
        that($test('1st friday    this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/03 00:00:00.000000');
        that($test('2nd thursday  this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/09 00:00:00.000000');
        that($test('3rd wednesday this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/15 00:00:00.000000');
        that($test('4th tuesday   this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/28 00:00:00.000000');
        that($test('5th monday    this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/03/05 00:00:00.000000');
        that($test('6th sunday    this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/03/11 00:00:00.000000');
        that($test('7th saturday  this month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/03/17 00:00:00.000000');
        // 隔週指定（奇数）
        that($test('last sunday odd  week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/05 00:00:00.000000');
        that($test('     sunday odd  week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/05 00:00:00.000000');
        that($test('next sunday odd  week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/05 00:00:00.000000');
        that($test('last sunday odd  week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/05 00:00:00.000000');
        that($test('     sunday odd  week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/19 00:00:00.000000');
        that($test('next sunday odd  week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/19 00:00:00.000000');
        // 隔週指定（偶数）
        that($test('last sunday even week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/01/29 00:00:00.000000');
        that($test('     sunday even week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/12 00:00:00.000000');
        that($test('next sunday even week', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/12 00:00:00.000000');
        that($test('last sunday even week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/12 00:00:00.000000');
        that($test('     sunday even week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/12 00:00:00.000000');
        that($test('next sunday even week', strtotime('2012/02/07 12:34:56.000000')))->is('2012/02/12 00:00:00.000000');
        // 相対指定（ベース指定）
        that($test('+1 month'))->is($test('+1 month', time()));
        that($test('+1 month', strtotime('2012/01/31 12:34:56.000000')))->is('2012/02/29 12:34:56.000000');
        that($test('+1 month', strtotime('2012/02/28 12:34:56.000000')))->is('2012/03/28 12:34:56.000000');
        that($test('-1 month', strtotime('2012/01/31 12:34:56.000000')))->is('2011/12/31 12:34:56.000000');
        that($test('-1 month', strtotime('2012/02/28 12:34:56.000000')))->is('2012/01/28 12:34:56.000000');
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
        // 相対指定閏年
        that($test('2012/02/28 12:34:56 +1 year'))->is('2013/02/28 12:34:56.000000');
        that($test('2012/02/28 12:34:56 -1 year'))->is('2011/02/28 12:34:56.000000');
        that($test('2012/02/29 12:34:56 +1 year'))->is('2013/02/28 12:34:56.000000');
        that($test('2012/02/29 12:34:56 -1 year'))->is('2011/02/28 12:34:56.000000');
        that($test('2012/03/01 12:34:56 +1 year'))->is('2013/03/01 12:34:56.000000');
        that($test('2012/03/01 12:34:56 -1 year'))->is('2011/03/01 12:34:56.000000');
        that($test('2012/02/29 12:34:56 +4 year'))->is('2016/02/29 12:34:56.000000');
        that($test('2012/02/29 12:34:56 -4 year'))->is('2008/02/29 12:34:56.000000');
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
        // タイムゾーン指定
        that($test("1969/12/31 23:59:59.900"))->is('1969/12/31 23:59:59.9');
        that($test("1970/01/01 00:00:00.000"))->is('1970/01/01 00:00:00.000000');
        that($test("1970/01/01 00:00:00.100"))->is('1970/01/01 00:00:00.1');
        that($test("1969/12/31 15:59:59.900+01:00"))->is('1969/12/31 23:59:59.9');
        that($test("1969/12/31 16:00:00.000+01:00"))->is('1970/01/01 00:00:00.000000');
        that($test("1969/12/31 16:00:00.100+01:00"))->is('1970/01/01 00:00:00.1');
        that($test("1969/12/31 14:59:59.900Z"))->is('1969/12/31 23:59:59.9');
        that($test("1969/12/31 15:00:00.000Z"))->is('1970/01/01 00:00:00.000000');
        that($test("1969/12/31 15:00:00.100Z"))->is('1970/01/01 00:00:00.1');
        that($test("1969/12/31 22:59:59.900Asia/Taipei"))->is('1969/12/31 23:59:59.9');
        that($test("1969/12/31 23:00:00.000Asia/Taipei"))->is('1970/01/01 00:00:00.000000');
        that($test("1969/12/31 23:00:00.100Asia/Taipei"))->is('1970/01/01 00:00:00.1');
        // 不正系
        that($test('hogera'))->is(null);               // 明らかにヤバイ1
        that($test('9999/99/99'))->is(null);           // 明らかにヤバイ2
        that($test('2014/2/29'))->is(null);            // 閏日でない
        that($test('2014/12/24 12:34:70'))->is(null);  // 秒が不正
        that($test('1nd of this month'))->is(null);    // 序数が不正
        that($test('2rd of this month'))->is(null);    // 序数が不正
        that($test('3th of this month'))->is(null);    // 序数が不正
        that($test('4st of this month'))->is(null);    // 序数が不正
        that($test('1nd sunday'))->is(null);           // 序数が不正
        that($test('2rd monday'))->is(null);           // 序数が不正
        that($test('3th tuesday'))->is(null);          // 序数が不正
        that($test('4st wednesday'))->is(null);        // 序数が不正
    }

    function test_date_validate()
    {
        error_clear_last();

        // valid datetime
        that(date_validate('2014', 'Y'))->is(true);
        that(date_validate('2014-12', 'Y-m'))->is(true);
        that(date_validate('2014-12-24', 'Y-m-d'))->is(true);
        that(date_validate('2014-12-24T12', 'Y-m-d\\TH'))->is(true);
        that(date_validate('2014-12-24T12:34', 'Y-m-d\\TH:i'))->is(true);
        that(date_validate('2014-12-24T12:34:56', 'Y-m-d\\TH:i:s'))->is(true);
        that(date_validate('2014-12-24T12:34:56.789', 'Y-m-d\\TH:i:s.v'))->is(true);
        that(date_validate('2014-12-24T12:34:56.789012', 'Y-m-d\\TH:i:s.u'))->is(true);

        // valid date
        that(date_validate('9999', 'Y'))->is(true);
        that(date_validate('12', 'm'))->is(true);
        that(date_validate('31', 'd'))->is(true);

        // valid time
        that(date_validate('23', 'H'))->is(true);
        that(date_validate('59', 'i'))->is(true);
        that(date_validate('59', 's'))->is(true);
        that(date_validate('789', 'v'))->is(true);
        that(date_validate('789012', 'u'))->is(true);

        // invalid
        that(date_validate('hogera'))->is(false);
        that(error_get_last()['message'])->contains("four digit year could not be found");

        // invalid datetime
        that(date_validate('2014-12-24T12:34:56.78901X', 'Y-m-d\\TH:i:s.u'))->is(false);
        that(error_get_last()['message'])->contains("Trailing data");
        that(date_validate('2014-12-24T12:34:56.7891', 'Y-m-d\\TH:i:s.v'))->is(false);
        that(error_get_last()['message'])->contains("Trailing data");
        that(date_validate('2014/12/24 12:34:60', 'Y/m/d H:i:s'))->is(false);
        that(error_get_last()['message'])->contains("invalid second '60'");
        that(date_validate('2014/12/24 12:60', 'Y/m/d H:i'))->is(false);
        that(error_get_last()['message'])->contains("invalid minute '60'");
        that(date_validate('2014/12/24 24', 'Y/m/d H'))->is(false);
        that(error_get_last()['message'])->contains("invalid hour '24'");
        that(date_validate('2014/2/29', 'Y/m/d'))->is(false);
        that(error_get_last()['message'])->contains("invalid date '2014-2-29'");

        // invalid date
        //that((date_validate)('10000', 'Y'))->is(false);
        //that(error_get_last()['message'])->contains("invalid year '10000'");
        that(date_validate('13', 'm'))->is(false);
        that(error_get_last()['message'])->contains("invalid month '13'");
        that(date_validate('32', 'd'))->is(false);
        that(error_get_last()['message'])->contains("invalid day '32'");

        // invalid time
        that(date_validate('24', 'H'))->is(false);
        that(error_get_last()['message'])->contains("invalid hour '24'");
        that(date_validate('60', 'i'))->is(false);
        that(error_get_last()['message'])->contains("invalid minute '60'");
        that(date_validate('60', 's'))->is(false);
        that(error_get_last()['message'])->contains("invalid second '60'");

        // invalid microtime
        that(date_validate('78901X', 'u'))->is(false);
        that(error_get_last()['message'])->contains("Trailing data");
        that(date_validate('7891', 'v'))->is(false);
        that(error_get_last()['message'])->contains("Trailing data");

        // overhour
        that(date_validate('24', 'H', 1))->is(true);
        that(date_validate('25', 'H', 1))->is(false);

        // text
        that(date_validate('May 20th, 2021', 'F jS, Y'))->is(true);
        that(date_validate('Thursday, May 20th, 2021', 'l, F jS, Y'))->is(true);
    }

    function test_now()
    {
        $now = now();
        usleep(1000_00);
        that(now())->is($now);
        that(now(false))->isNot($now);
    }
}
