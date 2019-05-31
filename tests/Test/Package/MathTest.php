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
        $this->assertEquals(-3, (minimum)($data['int_evn']));
        $this->assertEquals(-3, (minimum)($data['int_odd']));
        $this->assertEquals(-1.1, (minimum)($data['float_evn']));
        $this->assertEquals(-1.1, (minimum)($data['float_odd']));
        $this->assertEquals('a', (minimum)($data['string_evn']));
        $this->assertEquals('a', (minimum)($data['string_odd']));
        $this->assertEquals(new \DateTime('1999/12/24 12:34:56'), (minimum)($data['datetime_evn']));
        $this->assertEquals(new \DateTime('1999/12/24 12:34:56'), (minimum)($data['datetime_odd']));
    }

    function test_maximum()
    {
        $data = self::provideData();
        $this->assertEquals(4, (maximum)($data['int_evn']));
        $this->assertEquals(4, (maximum)($data['int_odd']));
        $this->assertEquals(2.2, (maximum)($data['float_evn']));
        $this->assertEquals(2.2, (maximum)($data['float_odd']));
        $this->assertEquals('z', (maximum)($data['string_evn']));
        $this->assertEquals('z', (maximum)($data['string_odd']));
        $this->assertEquals(new \DateTime('2001/12/24 12:34:56'), (maximum)($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2001/12/24 12:34:56'), (maximum)($data['datetime_odd']));
    }

    function test_mode()
    {
        $data = self::provideData();
        $this->assertEquals(1, (mode)($data['int_evn']));
        $this->assertEquals(1, (mode)($data['int_odd']));
        $this->assertEquals(1.1, (mode)($data['float_evn']));
        $this->assertEquals(1.1, (mode)($data['float_odd']));
        $this->assertEquals('m', (mode)($data['string_evn']));
        $this->assertEquals('m', (mode)($data['string_odd']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), (mode)($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), (mode)($data['datetime_odd']));
        $this->assertEquals(new \Exception('a'), (mode)(new \Exception('a'), new \Exception('a'), new \Exception('b')));
    }

    function test_median()
    {
        $data = self::provideData();
        $this->assertEquals(1, (median)($data['int_evn']));
        $this->assertEquals(1, (median)($data['int_odd']));
        $this->assertEquals(1.1, (median)($data['float_evn']));
        $this->assertEquals(1.1, (median)($data['float_odd']));
        $this->assertEquals('m', (median)($data['string_evn']));
        $this->assertEquals('m', (median)($data['string_odd']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), (median)($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), (median)($data['datetime_odd']));
    }

    function test_mean()
    {
        $data = self::provideData();
        $this->assertEquals(0.5999999999999999, (mean)($data['int_evn']));
        $this->assertEquals(0.5555555555555555, (mean)($data['int_odd']));
        $this->assertEquals(0.7333333333333333, (mean)($data['float_evn']));
        $this->assertEquals(0.6600000000000000, (mean)($data['float_odd']));
        $this->assertException('must be contain', mean, $data['string_evn']);
        $this->assertException('must be contain', mean, $data['string_odd']);
        $this->assertException('must be contain', mean, $data['datetime_evn']);
        $this->assertException('must be contain', mean, $data['datetime_odd']);
        $this->assertEquals(3.0, (mean)('1', 2, 3.5, 5.5, 'x'));
    }

    function test_average()
    {
        $this->assertException(new \DomainException('not implement yet'), average);
    }

    function test_sum()
    {
        $data = self::provideData();
        $this->assertEquals(6, (sum)($data['int_evn']));
        $this->assertEquals(5, (sum)($data['int_odd']));
        $this->assertEquals(4.4, (sum)($data['float_evn']));
        $this->assertEquals(3.3, (sum)($data['float_odd']));
        $this->assertException('must be contain', sum, $data['string_evn']);
        $this->assertException('must be contain', sum, $data['string_odd']);
        $this->assertException('must be contain', sum, $data['datetime_evn']);
        $this->assertException('must be contain', sum, $data['datetime_odd']);
        $this->assertEquals(6.5, (sum)('1', 2, 3.5, 'x'));
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
            $this->assertEquals($expected, (clamp)($actual, 5, 10, false), json_encode(compact('actual', 'expected')));
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
            $this->assertEquals($expected, (clamp)($actual, 5, 10, true), json_encode(compact('actual', 'expected')));
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
            $this->assertEquals($expected, (clamp)($actual, -10, -5, false), json_encode(compact('actual', 'expected')));
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
            $this->assertEquals($expected, (clamp)($actual, -10, -5, true), json_encode(compact('actual', 'expected')));
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
            $this->assertEquals($expected, (clamp)($actual, -5, 5, false), json_encode(compact('actual', 'expected')));
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
            $this->assertEquals($expected, (clamp)($actual, -5, 5, true), json_encode(compact('actual', 'expected')));
        }
    }

    function test_random_at()
    {
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = (random_at)(1, 2, 3, 4, 5, 6, 7, 8, 9);
        }
        $this->assertRange(4.85, 5.15, (mean)($result));

        // 1つでも OK
        $this->assertEquals(9, (random_at)(9));

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
        $this->assertRange(0.85, 1.15, (mean)($result));

        // 0% なら全部 false になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = (probability)(0, 1);
        }
        $this->assertEquals([], array_filter($result));

        // 100% なら全部 true になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = (probability)(1000, 1000);
        }
        $this->assertEquals($result, array_filter($result));

        // 負数は NG
        $this->assertException('probability must be positive number', probability, -1, 1);
        $this->assertException('divisor must be positive number', probability, 1, -1);
    }
}
