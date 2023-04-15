<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\mean;
use function ryunosuke\Functions\Package\normal_rand;
use function ryunosuke\Functions\Package\probability;
use function ryunosuke\Functions\Package\random_at;
use function ryunosuke\Functions\Package\random_string;
use function ryunosuke\Functions\Package\unique_string;

class randomTest extends AbstractTestCase
{
    function test_normal_rand()
    {
        mt_srand(234);

        that(normal_rand(50, 5))->is(61.517088409096196);
        that(normal_rand(50, 5))->is(47.46220149346318);
        that(normal_rand(50, 5))->is(48.86526339618124);
        that(normal_rand(50, 5))->is(55.70268085601572);
        that(normal_rand(50, 5))->is(52.42643082618295);

        $average = [
            normal_rand(50, 5),
            normal_rand(50, 5),
            normal_rand(50, 5),
            normal_rand(50, 5),
            normal_rand(50, 5),
        ];
        that(array_sum($average) / count($average))->isBetween(45, 55);
    }

    function test_probability()
    {
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = probability(10) ? 10 : 0;
        }
        that(mean($result))->isBetween(0.85, 1.15);

        // 0% なら全部 false になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = probability(0, 1);
        }
        that(array_filter($result))->is([]);

        // 100% なら全部 true になるはず
        $result = [];
        foreach (range(0, 100) as $n) {
            $result[$n] = probability(1000, 1000);
        }
        that(array_filter($result))->is($result);

        // 負数は NG
        that(self::resolveFunction('probability'))(-1, 1)->wasThrown('probability must be positive number');
        that(self::resolveFunction('probability'))(1, -1)->wasThrown('divisor must be positive number');
    }

    function test_random_at()
    {
        mt_srand(123); // 時々変えた方がいい

        // まぁ±0.15くらいには収束するだろう
        $result = [];
        foreach (range(0, 1000) as $n) {
            $result[$n] = random_at(1, 2, 3, 4, 5, 6, 7, 8, 9);
        }
        that(mean($result))->isBetween(4.85, 5.15);

        // 1つでも OK
        that(random_at(9))->is(9);

        // 境界値テストとして最小・最大が出るまでテストする
        $r = [];
        for ($i = 0; $i < 1000; $i++) {
            $r[random_at(1, 2, 3)] = true;
            if (count($r) === 3) {
                break;
            }
        }
        // 1000 回やって出ないのは何かがおかしい
        if ($i === 1000) {
            $this->fail('invisible [1, 2, 3]');
        }
    }

    function test_random_string()
    {
        $actual = random_string(256, 'abc');
        that(strlen($actual))->is(256);  // 256文字のはず
        that($actual)->matches('#abc#'); // 大抵の場合含まれるはず（極稀にコケる）

        that(self::resolveFunction('random_string'))(0, 'x')->wasThrown('positive number');
        that(self::resolveFunction('random_string'))(256, '')->wasThrown('empty');
    }

    function test_unique_string()
    {
        that(unique_string('hoge', 'xxx', 'X'))->is('xxxX');
        that(unique_string('hoge', null, 'o'))->stringLengthEquals(2);
        that(unique_string('hoge', 10))->stringLengthEquals(11);
        that(self::resolveFunction('unique_string'))('hoge', null, '')->wasThrown('empty');

        for ($i = 0; $i < 9999; $i++) {
            $unique_string = unique_string('hoge');
            that(strpos('hoge', $unique_string))->isFalse();
        }
    }
}
