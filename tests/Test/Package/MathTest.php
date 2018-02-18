<?php

namespace ryunosuke\Test\Package;

use ryunosuke\Functions\Package\Arrays;
use ryunosuke\Functions\Package\Math;

class MathTest extends \ryunosuke\Test\AbstractTestCase
{
    static function provideData()
    {
        return [
            'int_evn'      => Arrays::array_shuffle([-3, -2, -1, 0, 1, 1, 1, 2, 3, 4]),
            'int_odd'      => Arrays::array_shuffle([-3, -2, -1, 0, 1, 1, 2, 3, 4]),
            'float_evn'    => Arrays::array_shuffle([-1.1, 0, 1.1, 1.1, 1.1, 2.2]),
            'float_odd'    => Arrays::array_shuffle([-1.1, 0, 1.1, 1.1, 2.2]),
            'string_evn'   => Arrays::array_shuffle(['a', 'm', 'm', 'm', 'z']),
            'string_odd'   => Arrays::array_shuffle(['a', 'm', 'm', 'z']),
            'datetime_evn' => Arrays::array_shuffle([
                new \DateTime('1999/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2001/12/24 12:34:56'),
            ]),
            'datetime_odd' => Arrays::array_shuffle([
                new \DateTime('1999/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2000/12/24 12:34:56'),
                new \DateTime('2001/12/24 12:34:56'),
            ]),
        ];
    }

    function test_minimum()
    {
        $aggregate = minimum;
        $data = self::provideData();
        $this->assertEquals(-3, $aggregate($data['int_evn']));
        $this->assertEquals(-3, $aggregate($data['int_odd']));
        $this->assertEquals(-1.1, $aggregate($data['float_evn']));
        $this->assertEquals(-1.1, $aggregate($data['float_odd']));
        $this->assertEquals('a', $aggregate($data['string_evn']));
        $this->assertEquals('a', $aggregate($data['string_odd']));
        $this->assertEquals(new \DateTime('1999/12/24 12:34:56'), $aggregate($data['datetime_evn']));
        $this->assertEquals(new \DateTime('1999/12/24 12:34:56'), $aggregate($data['datetime_odd']));
    }

    function test_maximum()
    {
        $aggregate = maximum;
        $data = self::provideData();
        $this->assertEquals(4, $aggregate($data['int_evn']));
        $this->assertEquals(4, $aggregate($data['int_odd']));
        $this->assertEquals(2.2, $aggregate($data['float_evn']));
        $this->assertEquals(2.2, $aggregate($data['float_odd']));
        $this->assertEquals('z', $aggregate($data['string_evn']));
        $this->assertEquals('z', $aggregate($data['string_odd']));
        $this->assertEquals(new \DateTime('2001/12/24 12:34:56'), $aggregate($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2001/12/24 12:34:56'), $aggregate($data['datetime_odd']));
    }

    function test_mode()
    {
        $aggregate = mode;
        $data = self::provideData();
        $this->assertEquals(1, $aggregate($data['int_evn']));
        $this->assertEquals(1, $aggregate($data['int_odd']));
        $this->assertEquals(1.1, $aggregate($data['float_evn']));
        $this->assertEquals(1.1, $aggregate($data['float_odd']));
        $this->assertEquals('m', $aggregate($data['string_evn']));
        $this->assertEquals('m', $aggregate($data['string_odd']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), $aggregate($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), $aggregate($data['datetime_odd']));
        $this->assertEquals(new \Exception('a'), $aggregate(new \Exception('a'), new \Exception('a'), new \Exception('b')));
    }

    function test_median()
    {
        $aggregate = median;
        $data = self::provideData();
        $this->assertEquals(1, $aggregate($data['int_evn']));
        $this->assertEquals(1, $aggregate($data['int_odd']));
        $this->assertEquals(1.1, $aggregate($data['float_evn']));
        $this->assertEquals(1.1, $aggregate($data['float_odd']));
        $this->assertEquals('m', $aggregate($data['string_evn']));
        $this->assertEquals('m', $aggregate($data['string_odd']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), $aggregate($data['datetime_evn']));
        $this->assertEquals(new \DateTime('2000/12/24 12:34:56'), $aggregate($data['datetime_odd']));
    }

    function test_mean()
    {
        $aggregate = mean;
        $data = self::provideData();
        $this->assertEquals(0.5999999999999999, $aggregate($data['int_evn']));
        $this->assertEquals(0.5555555555555555, $aggregate($data['int_odd']));
        $this->assertEquals(0.7333333333333333, $aggregate($data['float_evn']));
        $this->assertEquals(0.6600000000000000, $aggregate($data['float_odd']));
        $this->assertException('must be contain', $aggregate, $data['string_evn']);
        $this->assertException('must be contain', $aggregate, $data['string_odd']);
        $this->assertException('must be contain', $aggregate, $data['datetime_evn']);
        $this->assertException('must be contain', $aggregate, $data['datetime_odd']);
        $this->assertEquals(3.0, $aggregate('1', 2, 3.5, 5.5, 'x'));
    }

    function test_average()
    {
        $aggregate = average;
        $this->assertException(new \DomainException('not implement yet'), $aggregate);
    }

    function test_sum()
    {
        $aggregate = sum;
        $data = self::provideData();
        $this->assertEquals(6, $aggregate($data['int_evn']));
        $this->assertEquals(5, $aggregate($data['int_odd']));
        $this->assertEquals(4.4, $aggregate($data['float_evn']));
        $this->assertEquals(3.3, $aggregate($data['float_odd']));
        $this->assertException('must be contain', $aggregate, $data['string_evn']);
        $this->assertException('must be contain', $aggregate, $data['string_odd']);
        $this->assertException('must be contain', $aggregate, $data['datetime_evn']);
        $this->assertException('must be contain', $aggregate, $data['datetime_odd']);
        $this->assertEquals(6.5, $aggregate('1', 2, 3.5, 'x'));
    }

    function test_random_at()
    {
        $random_at = random_at;
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = $random_at(1, 2, 3, 4, 5, 6, 7, 8, 9);
        }
        $this->assertRange(4.85, 5.15, Math::mean($result));

        // 1つでも OK
        $this->assertEquals(9, $random_at(9));

        // 境界値テストとして種を固定して最小・最大が出るまでテストする
        mt_srand(4);
        $this->assertEquals(1, $random_at(1, 2, 3));
        $this->assertEquals(3, $random_at(1, 2, 3));
        $this->assertEquals(2, $random_at(1, 2, 3));
    }

    function test_probability()
    {
        $probability = probability;
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = $probability(10) ? 10 : 0;
        }
        $this->assertRange(0.85, 1.15, Math::mean($result));

        // 0% なら全部 false になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = $probability(0, 1);
        }
        $this->assertEquals([], array_filter($result));

        // 100% なら全部 true になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = $probability(1000, 1000);
        }
        $this->assertEquals($result, array_filter($result));

        // 負数は NG
        $this->assertException('probability must be positive number', $probability, -1, 1);
        $this->assertException('divisor must be positive number', $probability, 1, -1);
    }
}
