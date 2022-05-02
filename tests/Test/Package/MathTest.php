<?php

namespace ryunosuke\Test\Package;

class MathTest extends AbstractTestCase
{
    static function provideData()
    {
        return [
            'int_evn'      => (array_shuffle)([-3, -2, -1, 0, 1, 1, 1, 2, 3, 4]),
            'int_odd'      => (array_shuffle)([-3, -2, -1, 0, 1, 1, 2, 3, 4]),
            'float_evn'    => (array_shuffle)([-1.1, 0, 1.1, 1.1, 1.1, 2.2]),
            'float_odd'    => (array_shuffle)([-1.1, 0, 1.1, 1.1, 2.2]),
            'string_evn'   => (array_shuffle)(['a', 'm', 'm', 'm', 'z']),
            'string_odd'   => (array_shuffle)(['a', 'm', 'm', 'z']),
            'datetime_evn' => (array_shuffle)([
                new \DateTime('1999/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2001/12/24 12:34:56'),
            ]),
            'datetime_odd' => (array_shuffle)([
                new \DateTime('1999/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2001/12/24 12:34:56'),
            ]),
        ];
    }

    function test_minimum()
    {
        $data = self::provideData();
        that((minimum)($data['int_evn']))->is(-3);
        that((minimum)($data['int_odd']))->is(-3);
        that((minimum)($data['float_evn']))->is(-1.1);
        that((minimum)($data['float_odd']))->is(-1.1);
        that((minimum)($data['string_evn']))->is('a');
        that((minimum)($data['string_odd']))->is('a');
        that((minimum)($data['datetime_evn']))->is(new \DateTime('1999/12/24 12:34:56'));
        that((minimum)($data['datetime_odd']))->is(new \DateTime('1999/12/24 12:34:56'));
    }

    function test_maximum()
    {
        $data = self::provideData();
        that((maximum)($data['int_evn']))->is(4);
        that((maximum)($data['int_odd']))->is(4);
        that((maximum)($data['float_evn']))->is(2.2);
        that((maximum)($data['float_odd']))->is(2.2);
        that((maximum)($data['string_evn']))->is('z');
        that((maximum)($data['string_odd']))->is('z');
        that((maximum)($data['datetime_evn']))->is(new \DateTime('2001/12/24 12:34:56'));
        that((maximum)($data['datetime_odd']))->is(new \DateTime('2001/12/24 12:34:56'));
    }

    function test_mode()
    {
        $data = self::provideData();
        that((mode)($data['int_evn']))->is(1);
        that((mode)($data['int_odd']))->is(1);
        that((mode)($data['float_evn']))->is(1.1);
        that((mode)($data['float_odd']))->is(1.1);
        that((mode)($data['string_evn']))->is('m');
        that((mode)($data['string_odd']))->is('m');
        that((mode)($data['datetime_evn']))->is(new \DateTime('2000/12/24 12:34:56'));
        that((mode)($data['datetime_odd']))->is(new \DateTime('2000/12/24 12:34:56'));
        that((mode)(new \Exception('a'), new \Exception('a'), new \Exception('b')))->is(new \Exception('a'));
    }

    function test_median()
    {
        $data = self::provideData();
        that((median)($data['int_evn']))->is(1);
        that((median)($data['int_odd']))->is(1);
        that((median)($data['float_evn']))->is(1.1);
        that((median)($data['float_odd']))->is(1.1);
        that((median)($data['string_evn']))->is('m');
        that((median)($data['string_odd']))->is('m');
        that((median)($data['datetime_evn']))->is(new \DateTime('2000/12/24 12:34:56'));
        that((median)($data['datetime_odd']))->is(new \DateTime('2000/12/24 12:34:56'));
    }

    function test_mean()
    {
        $data = self::provideData();
        that((mean)($data['int_evn']))->is(0.5999999999999999);
        that((mean)($data['int_odd']))->is(0.5555555555555555);
        that((mean)($data['float_evn']))->is(0.7333333333333333);
        that((mean)($data['float_odd']))->is(0.6600000000000000);
        that(mean)->try($data['string_evn'])->wasThrown('must be contain');
        that(mean)->try($data['string_odd'])->wasThrown('must be contain');
        that(mean)->try($data['datetime_evn'])->wasThrown('must be contain');
        that(mean)->try($data['datetime_odd'])->wasThrown('must be contain');
        that((mean)('1', 2, 3.5, 5.5, 'x'))->is(3.0);
    }

    function test_average()
    {
        that(average)->try()->wasThrown('not implement yet');
    }

    function test_sum()
    {
        $data = self::provideData();
        that((sum)($data['int_evn']))->is(6);
        that((sum)($data['int_odd']))->is(5);
        that((sum)($data['float_evn']))->is(4.4);
        that((sum)($data['float_odd']))->is(3.3);
        that(sum)->try($data['string_evn'])->wasThrown('must be contain');
        that(sum)->try($data['string_odd'])->wasThrown('must be contain');
        that(sum)->try($data['datetime_evn'])->wasThrown('must be contain');
        that(sum)->try($data['datetime_odd'])->wasThrown('must be contain');
        that((sum)('1', 2, 3.5, 'x'))->is(6.5);
    }

    function test_clamp()
    {
        $circulative_false = [
            -8  => 5,
            -7  => 5,
            -6  => 5,
            -5  => 5,
            -4  => 5,
            -3  => 5,
            -2  => 5,
            -1  => 5,
            0   => 5,
            +1  => 5,
            +2  => 5,
            +3  => 5,
            +4  => 5,
            +5  => 5,
            +6  => 6,
            +7  => 7,
            +8  => 8,
            +9  => 9,
            +10 => 10,
            +11 => 10,
        ];
        foreach ($circulative_false as $actual => $expected) {
            that((clamp)($actual, 5, 10, false))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }

        $circulative_true = [
            -8  => 10,
            -7  => 5,
            -6  => 6,
            -5  => 7,
            -4  => 8,
            -3  => 9,
            -2  => 10,
            -1  => 5,
            0   => 6,
            +1  => 7,
            +2  => 8,
            +3  => 9,
            +4  => 10,
            +5  => 5,
            +6  => 6,
            +7  => 7,
            +8  => 8,
            +9  => 9,
            +10 => 10,
            +11 => 5,
        ];
        foreach ($circulative_true as $actual => $expected) {
            that((clamp)($actual, 5, 10, true))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }

        $circulative_false = [
            -11 => -10,
            -10 => -10,
            -9  => -9,
            -8  => -8,
            -7  => -7,
            -6  => -6,
            -5  => -5,
            -4  => -5,
            -3  => -5,
            -2  => -5,
            -1  => -5,
            0   => -5,
            +1  => -5,
            +2  => -5,
        ];
        foreach ($circulative_false as $actual => $expected) {
            that((clamp)($actual, -10, -5, false))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }

        $circulative_false = [
            -11 => -5,
            -10 => -10,
            -9  => -9,
            -8  => -8,
            -7  => -7,
            -6  => -6,
            -5  => -5,
            -4  => -10,
            -3  => -9,
            -2  => -8,
            -1  => -7,
            0   => -6,
            +1  => -5,
            +2  => -10,
        ];
        foreach ($circulative_false as $actual => $expected) {
            that((clamp)($actual, -10, -5, true))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }

        $circulative_false = [
            -6 => -5,
            -5 => -5,
            -4 => -4,
            -3 => -3,
            -2 => -2,
            -1 => -1,
            0  => 0,
            +1 => 1,
            +2 => 2,
            +3 => 3,
            +4 => 4,
            +5 => 5,
            +6 => 5,
        ];
        foreach ($circulative_false as $actual => $expected) {
            that((clamp)($actual, -5, 5, false))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }

        $circulative_false = [
            -6 => 5,
            -5 => -5,
            -4 => -4,
            -3 => -3,
            -2 => -2,
            -1 => -1,
            0  => 0,
            +1 => 1,
            +2 => 2,
            +3 => 3,
            +4 => 4,
            +5 => 5,
            +6 => -5,
        ];
        foreach ($circulative_false as $actual => $expected) {
            that((clamp)($actual, -5, 5, true))->as(json_encode(compact('actual', 'expected')))->is($expected);
        }
    }

    function test_decimal()
    {
        $decimal = fn(...$args) => that((decimal)(...$args));

        $compatible_round = [
            [-115, -1, PHP_ROUND_HALF_UP],
            [-115, -1, PHP_ROUND_HALF_DOWN],
            [-115, -1, PHP_ROUND_HALF_EVEN],
            [-115, -1, PHP_ROUND_HALF_ODD],

            [115, -1, PHP_ROUND_HALF_UP],
            [115, -1, PHP_ROUND_HALF_DOWN],
            [115, -1, PHP_ROUND_HALF_EVEN],
            [115, -1, PHP_ROUND_HALF_ODD],

            [-1.5, 0, PHP_ROUND_HALF_UP],
            [-1.5, 0, PHP_ROUND_HALF_DOWN],
            [-1.5, 0, PHP_ROUND_HALF_EVEN],
            [-1.5, 0, PHP_ROUND_HALF_ODD],

            [1.5, 0, PHP_ROUND_HALF_UP],
            [1.5, 0, PHP_ROUND_HALF_DOWN],
            [1.5, 0, PHP_ROUND_HALF_EVEN],
            [1.5, 0, PHP_ROUND_HALF_ODD],

            [-1.15, 1, PHP_ROUND_HALF_UP],
            [-1.15, 1, PHP_ROUND_HALF_DOWN],
            [-1.15, 1, PHP_ROUND_HALF_EVEN],
            [-1.15, 1, PHP_ROUND_HALF_ODD],

            [1.15, 1, PHP_ROUND_HALF_UP],
            [1.15, 1, PHP_ROUND_HALF_DOWN],
            [1.15, 1, PHP_ROUND_HALF_EVEN],
            [1.15, 1, PHP_ROUND_HALF_ODD],
        ];
        foreach ($compatible_round as [$number, $precision, $mode]) {
            $actual = (decimal)($number, $precision, $mode);
            $expected = round($number, $precision, $mode);
            that($actual)->as("round($number, $precision, $mode)")->isSame($expected);
        }

        $ZERO = 0;    // 0 方向
        $PINF = +INF;  // 正の無限大
        $NINF = -INF; // 負の無限大
        $AUTO = null; // 正負で自動

        $decimal(-110, -1, $NINF)->isSame(-110.0);
        $decimal(-114, -1, $NINF)->isSame(-120.0);
        $decimal(-115, -1, $NINF)->isSame(-120.0);
        $decimal(-116, -1, $NINF)->isSame(-120.0);
        $decimal(-110, -1, $PINF)->isSame(-110.0);
        $decimal(-114, -1, $PINF)->isSame(-110.0);
        $decimal(-115, -1, $PINF)->isSame(-110.0);
        $decimal(-116, -1, $PINF)->isSame(-110.0);
        $decimal(-110, -1, $ZERO)->isSame(-110.0);
        $decimal(-114, -1, $ZERO)->isSame(-110.0);
        $decimal(-115, -1, $ZERO)->isSame(-110.0);
        $decimal(-116, -1, $ZERO)->isSame(-110.0);
        $decimal(-110, -1, $AUTO)->isSame(-110.0);
        $decimal(-114, -1, $AUTO)->isSame(-120.0);
        $decimal(-115, -1, $AUTO)->isSame(-120.0);
        $decimal(-116, -1, $AUTO)->isSame(-120.0);

        $decimal(110, -1, $NINF)->isSame(110.0);
        $decimal(114, -1, $NINF)->isSame(110.0);
        $decimal(115, -1, $NINF)->isSame(110.0);
        $decimal(116, -1, $NINF)->isSame(110.0);
        $decimal(110, -1, $PINF)->isSame(110.0);
        $decimal(114, -1, $PINF)->isSame(120.0);
        $decimal(115, -1, $PINF)->isSame(120.0);
        $decimal(116, -1, $PINF)->isSame(120.0);
        $decimal(110, -1, $ZERO)->isSame(110.0);
        $decimal(114, -1, $ZERO)->isSame(110.0);
        $decimal(115, -1, $ZERO)->isSame(110.0);
        $decimal(116, -1, $ZERO)->isSame(110.0);
        $decimal(110, -1, $AUTO)->isSame(110.0);
        $decimal(114, -1, $AUTO)->isSame(120.0);
        $decimal(115, -1, $AUTO)->isSame(120.0);
        $decimal(116, -1, $AUTO)->isSame(120.0);

        $decimal(-11.0, 0, $NINF)->isSame(-11.0);
        $decimal(-11.4, 0, $NINF)->isSame(-12.0);
        $decimal(-11.5, 0, $NINF)->isSame(-12.0);
        $decimal(-11.6, 0, $NINF)->isSame(-12.0);
        $decimal(-11.0, 0, $PINF)->isSame(-11.0);
        $decimal(-11.4, 0, $PINF)->isSame(-11.0);
        $decimal(-11.5, 0, $PINF)->isSame(-11.0);
        $decimal(-11.6, 0, $PINF)->isSame(-11.0);
        $decimal(-11.0, 0, $ZERO)->isSame(-11.0);
        $decimal(-11.4, 0, $ZERO)->isSame(-11.0);
        $decimal(-11.5, 0, $ZERO)->isSame(-11.0);
        $decimal(-11.6, 0, $ZERO)->isSame(-11.0);
        $decimal(-11.0, 0, $AUTO)->isSame(-11.0);
        $decimal(-11.4, 0, $AUTO)->isSame(-12.0);
        $decimal(-11.5, 0, $AUTO)->isSame(-12.0);
        $decimal(-11.6, 0, $AUTO)->isSame(-12.0);

        $decimal(11.0, 0, $NINF)->isSame(11.0);
        $decimal(11.4, 0, $NINF)->isSame(11.0);
        $decimal(11.5, 0, $NINF)->isSame(11.0);
        $decimal(11.6, 0, $NINF)->isSame(11.0);
        $decimal(11.0, 0, $PINF)->isSame(11.0);
        $decimal(11.4, 0, $PINF)->isSame(12.0);
        $decimal(11.5, 0, $PINF)->isSame(12.0);
        $decimal(11.6, 0, $PINF)->isSame(12.0);
        $decimal(11.0, 0, $ZERO)->isSame(11.0);
        $decimal(11.4, 0, $ZERO)->isSame(11.0);
        $decimal(11.5, 0, $ZERO)->isSame(11.0);
        $decimal(11.6, 0, $ZERO)->isSame(11.0);
        $decimal(11.0, 0, $AUTO)->isSame(11.0);
        $decimal(11.4, 0, $AUTO)->isSame(12.0);
        $decimal(11.5, 0, $AUTO)->isSame(12.0);
        $decimal(11.6, 0, $AUTO)->isSame(12.0);

        $decimal(-1.10, 1, $NINF)->isSame(-1.1);
        $decimal(-1.14, 1, $NINF)->isSame(-1.2);
        $decimal(-1.15, 1, $NINF)->isSame(-1.2);
        $decimal(-1.16, 1, $NINF)->isSame(-1.2);
        $decimal(-1.10, 1, $PINF)->isSame(-1.1);
        $decimal(-1.14, 1, $PINF)->isSame(-1.1);
        $decimal(-1.15, 1, $PINF)->isSame(-1.1);
        $decimal(-1.16, 1, $PINF)->isSame(-1.1);
        $decimal(-1.10, 1, $ZERO)->isSame(-1.1);
        $decimal(-1.14, 1, $ZERO)->isSame(-1.1);
        $decimal(-1.15, 1, $ZERO)->isSame(-1.1);
        $decimal(-1.16, 1, $ZERO)->isSame(-1.1);
        $decimal(-1.10, 1, $AUTO)->isSame(-1.1);
        $decimal(-1.14, 1, $AUTO)->isSame(-1.2);
        $decimal(-1.15, 1, $AUTO)->isSame(-1.2);
        $decimal(-1.16, 1, $AUTO)->isSame(-1.2);

        $decimal(1.10, 1, $NINF)->isSame(1.1);
        $decimal(1.14, 1, $NINF)->isSame(1.1);
        $decimal(1.15, 1, $NINF)->isSame(1.1);
        $decimal(1.16, 1, $NINF)->isSame(1.1);
        $decimal(1.10, 1, $PINF)->isSame(1.1);
        $decimal(1.14, 1, $PINF)->isSame(1.2);
        $decimal(1.15, 1, $PINF)->isSame(1.2);
        $decimal(1.16, 1, $PINF)->isSame(1.2);
        $decimal(1.10, 1, $ZERO)->isSame(1.1);
        $decimal(1.14, 1, $ZERO)->isSame(1.1);
        $decimal(1.15, 1, $ZERO)->isSame(1.1);
        $decimal(1.16, 1, $ZERO)->isSame(1.1);
        $decimal(1.10, 1, $AUTO)->isSame(1.1);
        $decimal(1.14, 1, $AUTO)->isSame(1.2);
        $decimal(1.15, 1, $AUTO)->isSame(1.2);
        $decimal(1.16, 1, $AUTO)->isSame(1.2);

        $decimal(-0.4999999999999999445, -1, $NINF)->isSame(-10.0);
        $decimal(-0.4999999999999999445, -1, $PINF)->isSame(-0.0);
        $decimal(-0.4999999999999999445, -1, $AUTO)->isSame(-10.0);
        $decimal(-0.4999999999999999445, -1, $ZERO)->isSame(-0.0);
        $decimal(-0.4999999999999999445, 0, $NINF)->isSame(-1.0);
        $decimal(-0.4999999999999999445, 0, $PINF)->isSame(-0.0);
        $decimal(-0.4999999999999999445, 0, $AUTO)->isSame(-1.0);
        $decimal(-0.4999999999999999445, 0, $ZERO)->isSame(-0.0);
        $decimal(-0.4999999999999999445, 1, $NINF)->isSame(-0.5);
        $decimal(-0.4999999999999999445, 1, $PINF)->isSame(-0.4);
        $decimal(-0.4999999999999999445, 1, $AUTO)->isSame(-0.5);
        $decimal(-0.4999999999999999445, 1, $ZERO)->isSame(-0.4);

        $decimal(0.4999999999999999445, -1, $NINF)->isSame(0.0);
        $decimal(0.4999999999999999445, -1, $PINF)->isSame(10.0);
        $decimal(0.4999999999999999445, -1, $AUTO)->isSame(10.0);
        $decimal(0.4999999999999999445, -1, $ZERO)->isSame(0.0);
        $decimal(0.4999999999999999445, 0, $NINF)->isSame(0.0);
        $decimal(0.4999999999999999445, 0, $PINF)->isSame(1.0);
        $decimal(0.4999999999999999445, 0, $AUTO)->isSame(1.0);
        $decimal(0.4999999999999999445, 0, $ZERO)->isSame(0.0);
        $decimal(0.4999999999999999445, 1, $NINF)->isSame(0.4);
        $decimal(0.4999999999999999445, 1, $PINF)->isSame(0.5);
        $decimal(0.4999999999999999445, 1, $AUTO)->isSame(0.5);
        $decimal(0.4999999999999999445, 1, $ZERO)->isSame(0.4);

        $decimal(-9007199254740991.0, -1, $NINF)->isSame(-9007199254741000.0);
        $decimal(-9007199254740991.0, -1, $PINF)->isSame(-9007199254740990.0);
        $decimal(-9007199254740991.0, -1, $AUTO)->isSame(-9007199254741000.0);
        $decimal(-9007199254740991.0, -1, $ZERO)->isSame(-9007199254740990.0);

        $decimal(9007199254740991.0, -1, $NINF)->isSame(9007199254740990.0);
        $decimal(9007199254740991.0, -1, $PINF)->isSame(9007199254741000.0);
        $decimal(9007199254740991.0, -1, $AUTO)->isSame(9007199254741000.0);
        $decimal(9007199254740991.0, -1, $ZERO)->isSame(9007199254740990.0);

        that(decimal)->try(1, 1, 'hoge')->wasThrown('$precision must be either');
        that(decimal)->try(9007199254740991.0, 1, $NINF)->wasThrown('it exceeds the valid values');
    }

    function test_random_at()
    {
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = (random_at)(1, 2, 3, 4, 5, 6, 7, 8, 9);
        }
        that((mean)($result))->isBetween(4.85, 5.15);

        // 1つでも OK
        that((random_at)(9))->is(9);

        // 境界値テストとして最小・最大が出るまでテストする
        $r = [];
        for ($i = 0; $i < 1000; $i++) {
            $r[(random_at)(1, 2, 3)] = true;
            if (count($r) === 3) {
                break;
            }
        }
        // 1000 回やって出ないのは何かがおかしい
        if ($i === 1000) {
            $this->fail('invisible [1, 2, 3]');
        }
    }

    function test_probability()
    {
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = (probability)(10) ? 10 : 0;
        }
        that((mean)($result))->isBetween(0.85, 1.15);

        // 0% なら全部 false になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = (probability)(0, 1);
        }
        that(array_filter($result))->is([]);

        // 100% なら全部 true になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = (probability)(1000, 1000);
        }
        that(array_filter($result))->is($result);

        // 負数は NG
        that(probability)->try(-1, 1)->wasThrown('probability must be positive number');
        that(probability)->try(1, -1)->wasThrown('divisor must be positive number');
    }

    function test_normal_rand()
    {
        mt_srand(234);

        that((normal_rand)(50, 5))->is(61.517088409096196);
        that((normal_rand)(50, 5))->is(47.46220149346318);
        that((normal_rand)(50, 5))->is(48.86526339618124);
        that((normal_rand)(50, 5))->is(55.70268085601572);
        that((normal_rand)(50, 5))->is(52.42643082618295);

        $average = [
            (normal_rand)(50, 5),
            (normal_rand)(50, 5),
            (normal_rand)(50, 5),
            (normal_rand)(50, 5),
            (normal_rand)(50, 5),
        ];
        that(array_sum($average) / count($average))->isBetween(45, 55);
    }

    function test_calculate_formula()
    {
        define('NS\\NINE', 9);
        that((calculate_formula)('(1 - 2 + 3) ** 3 / 4'))->is(2);
        that((calculate_formula)('NS\\NINE + M_PI * 3 + \\M_PI'))->is(9 + M_PI * 4);
        that((calculate_formula)('NS\\NINE + ArrayObject::ARRAY_AS_PROPS * 3 + \\ArrayObject::ARRAY_AS_PROPS'))->is(9 + \ArrayObject::ARRAY_AS_PROPS * 4);

        define('NS\\STR', 'evil');
        that(calculate_formula)->try('NS\\STR + 1')->wasThrown();
        that(calculate_formula)->try('NS\\STR (1)')->wasThrown();
        that(calculate_formula)->try('UNDEFINED(1)')->wasThrown();
        that(calculate_formula)->try('1 + "aaa"')->wasThrown();
    }
}
