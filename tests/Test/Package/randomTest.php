<?php

namespace ryunosuke\Test\Package;

use function ryunosuke\Functions\Package\mean;
use function ryunosuke\Functions\Package\probability;
use function ryunosuke\Functions\Package\probability_array;
use function ryunosuke\Functions\Package\random_at;
use function ryunosuke\Functions\Package\random_float;
use function ryunosuke\Functions\Package\random_normal;
use function ryunosuke\Functions\Package\random_range;
use function ryunosuke\Functions\Package\random_string;
use function ryunosuke\Functions\Package\unique_string;

class randomTest extends AbstractTestCase
{
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

    function test_probability_array()
    {
        $COUNT = 10000;
        mt_srand(123); // 時々変えた方がいい

        // 指定パーセントに収束する
        $result = [];
        foreach (range(1, $COUNT) as $n) {
            $result[$n] = probability_array([
                '10%' => 10,
                '20%' => 20,
                '30%' => 30,
                '40%' => 40,
            ]);
        }
        $result = array_count_values(array_map('strval', $result));
        that($result['10%'])->closesTo($COUNT * 0.1 - 100, 200);
        that($result['20%'])->closesTo($COUNT * 0.2 - 100, 200);
        that($result['30%'])->closesTo($COUNT * 0.3 - 100, 200);
        that($result['40%'])->closesTo($COUNT * 0.4 - 100, 200);

        // 順番には依存しないし、足りない場合は null で埋められる
        $result = [];
        foreach (range(1, $COUNT) as $n) {
            $result[$n] = probability_array([
                '30%' => 30,
                '10%' => 10,
                '20%' => 20,
            ]);
        }
        $result = array_count_values(array_map('strval', $result));
        that($result['10%'])->closesTo($COUNT * 0.1 - 100, 200);
        that($result['20%'])->closesTo($COUNT * 0.2 - 100, 200);
        that($result['30%'])->closesTo($COUNT * 0.3 - 100, 200);
        that($result[''])->closesTo($COUNT * 0.4 - 100, 200);

        // パーミル（0.1%）
        $result = [];
        foreach (range(1, $COUNT) as $n) {
            $result[$n] = probability_array([
                '999' => 999,
                '1'   => 1,
            ], 1000);
        }
        $result = array_count_values(array_map('strval', $result));
        that($result['1'])->closesTo($COUNT * 0.001 - 10, 20);

        // 0 は敢えて許容している
        $result = [];
        foreach (range(1, $COUNT) as $n) {
            $result[$n] = probability_array([
                '0'   => 0,
                '100' => 100,
            ]);
        }
        $result = array_count_values(array_map('strval', $result));
        that($result['100'])->is($COUNT);
        that($result)->notHasKey('0');

        // 重み付け
        $result = [];
        foreach (range(1, $COUNT) as $n) {
            $result[$n] = probability_array([
                'a' => 1,
                'b' => 2,
                'c' => 3,
            ], null);
        }
        $result = array_count_values(array_map('strval', $result));
        that($result['a'])->closesTo($COUNT * (1 / 6 * 1) - 100, 200);
        that($result['b'])->closesTo($COUNT * (1 / 6 * 2) - 100, 200);
        that($result['c'])->closesTo($COUNT * (1 / 6 * 3) - 100, 200);
        that($result)->notHasKey('');

        // 例外系
        that(self::resolveFunction('probability_array'))([])->wasThrown('is empty');
        that(self::resolveFunction('probability_array'))(['110%' => 110])->wasThrown('exceeds 100');
        that(self::resolveFunction('probability_array'))(['-1%' => 0], 0)->wasThrown('divisor <= 0');
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

    function test_random_float()
    {
        mt_srand(141); // 時々変えた方がいい

        // まぁ±0.01くらいには収束するだろう
        $result = [];
        foreach (range(0, 10000) as $n) {
            $result[$n] = random_float(-1, +1);
        }
        that(mean($result))->isBetween(-0.01, +0.01);
        that(min($result))->isBetween(-1, -0.999);
        that(max($result))->isBetween(+0.999, +1);

        $result = [];
        foreach (range(0, 10000) as $n) {
            $result[$n] = random_float(-1.7, +1.3);
        }
        that(min($result))->isBetween(-1.7, -1.699);
        that(max($result))->isBetween(+1.299, +1.3);

        that(self::resolveFunction('random_float'))(3, 0)->wasThrown('Minimum value must be less than or equal to the maximum value');
    }

    function test_random_normal()
    {
        mt_srand(234);

        that(random_normal(50, 5))->is(61.517088409096196);
        that(random_normal(50, 5))->is(47.46220149346318);
        that(random_normal(50, 5))->is(48.86526339618124);
        that(random_normal(50, 5))->is(55.70268085601572);
        that(random_normal(50, 5))->is(52.42643082618295);

        $average = [
            random_normal(50, 5),
            random_normal(50, 5),
            random_normal(50, 5),
            random_normal(50, 5),
            random_normal(50, 5),
        ];
        that(array_sum($average) / count($average))->isBetween(45, 55);
    }

    function test_random_range()
    {
        mt_srand(123); // 時々変えた方がいい

        $plusminus = [];
        $under7 = [];
        $over70 = [];
        $counts = [];
        foreach (range(0, 1000) as $ignored) {
            $plusminus = array_merge($plusminus, random_range(-100, 100, 7));
            $under7 = array_merge($under7, random_range(100, 200, 7));
            $over70 = array_merge($over70, random_range(100, 200, 77));
            $counts[] = count(random_range(100, 200));
        }

        that(min($plusminus))->is(-100);
        that(max($plusminus))->is(+100);
        that(mean($plusminus))->isBetween(-1, +1);

        that(min($under7))->is(100);
        that(max($under7))->is(200);
        that(mean($under7))->isBetween(149, 151);

        that(min($over70))->is(100);
        that(max($over70))->is(200);
        that(mean($over70))->isBetween(149, 151);

        that(min($counts))->is(0);
        that(max($counts))->is(101);

        // 0 や範囲超過数でも OK
        that(count(random_range(10, 20, 0)))->is(0);
        that(count(random_range(10, 20, 999)))->is(11);
        that(count(random_range(-10, +10, 999)))->is(21);

        // 範囲内で重複しない
        $array = random_range(100, 200, 999);
        that(count($array))->is(count(array_unique($array)));

        // 膨大な範囲から少しだけ取る場合でもメモリエラーを起こさない
        that(fn() => count(random_range(100000001, 200000000, 7)))->try(null)->break()->inElapsedTime(0.015)->is(7);
        // 膨大な範囲からピッタリ取る場合でも現実的な時間で返ってくる
        that(fn() => count(random_range(1000001, 2000000, 1000000)))->try(null)->break()->inElapsedTime(0.150)->is(1000000);

        that(self::resolveFunction('random_range'))(3, 0)->wasThrown('invalid range');
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
