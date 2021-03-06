<?php

namespace ryunosuke\Functions\Package;

/**
 * 数学関連のユーティリティ
 */
class Math
{
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(minimum(-1, 0, 1))->isSame(-1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    public static function minimum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        return min($args);
    }

    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(maximum(-1, 0, 1))->isSame(1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    public static function maximum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        return max($args);
    }

    /**
     * 引数の最頻値を返す
     *
     * - 等価比較は文字列で行う。小数時は注意。おそらく php.ini の precision に従うはず
     * - 等価値が複数ある場合の返り値は不定
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(mode(0, 1, 2, 2, 3, 3, 3))->isSame(3);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    public static function mode(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return (stringify)($v);
            }
            return (string) $v;
        }, $args);
        $args = array_combine($vals, $args);
        $counts = array_count_values($vals);
        arsort($counts);
        reset($counts);
        return $args[key($counts)];
    }

    /**
     * 引数の相加平均値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(mean(1, 2, 3, 4, 5, 6))->isSame(3.5);
     * that(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6))->isSame(3.5);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    public static function mean(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or (throws)(new \LengthException("argument's must be contain munber."));
        return array_sum($args) / count($args);
    }

    /**
     * 引数の中央値を返す
     *
     * - 要素数が奇数の場合は完全な中央値/偶数の場合は中2つの平均。「平均」という概念が存在しない値なら中2つの後の値
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 偶数個なので中2つの平均
     * that(median(1, 2, 3, 4, 5, 6))->isSame(3.5);
     * // 奇数個なのでど真ん中
     * that(median(1, 2, 3, 4, 5))->isSame(3);
     * // 偶数個だが文字列なので中2つの後
     * that(median('a', 'b', 'c', 'd'))->isSame('c');
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    public static function median(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $count = count($args);
        $center = (int) ($count / 2);
        sort($args);
        // 偶数で共に数値なら平均値
        if ($count % 2 === 0 && (is_numeric($args[$center - 1]) && is_numeric($args[$center]))) {
            return ($args[$center - 1] + $args[$center]) / 2;
        }
        // 奇数なら単純に中央値
        else {
            return $args[$center];
        }
    }

    /**
     * 引数の意味平均値を返す
     *
     * - 3座標の重心座標とか日付の平均とかそういうもの
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 意味平均値
     */
    public static function average(...$variadic)
    {
        // 用意したはいいが統一的なうまい実装が思いつかない（関数ベースじゃ無理だと思う）
        // average は意味平均、mean は相加平均を明示するために定義は残しておく
        assert(is_array($variadic));
        throw new \DomainException('not implement yet.');
    }

    /**
     * 引数の合計値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(sum(1, 2, 3, 4, 5, 6))->isSame(21);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    public static function sum(...$variadic)
    {
        $args = (array_flatten)($variadic) or (throws)(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or (throws)(new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }

    /**
     * 値を一定範囲に収める
     *
     * $circulative に true を渡すと値が循環する。
     * ただし、循環的な型に限る（整数のみ？）。
     *
     * Example:
     * ```php
     * // 5～9 に収める
     * that(clamp(4, 5, 9))->isSame(5); // 4 は [5～9] の範囲外なので 5 に切り上げられる
     * that(clamp(5, 5, 9))->isSame(5); // 範囲内なのでそのまま
     * that(clamp(6, 5, 9))->isSame(6); // 範囲内なのでそのまま
     * that(clamp(7, 5, 9))->isSame(7); // 範囲内なのでそのまま
     * that(clamp(8, 5, 9))->isSame(8); // 範囲内なのでそのまま
     * that(clamp(9, 5, 9))->isSame(9); // 範囲内なのでそのまま
     * that(clamp(10, 5, 9))->isSame(9); // 10 は [5～9] の範囲外なので 9 に切り下げられる
     *
     * // 5～9 に収まるように循環する
     * that(clamp(4, 5, 9, true))->isSame(9); // 4 は [5～9] の範囲外なので循環して 9 になる
     * that(clamp(5, 5, 9, true))->isSame(5); // 範囲内なのでそのまま
     * that(clamp(6, 5, 9, true))->isSame(6); // 範囲内なのでそのまま
     * that(clamp(7, 5, 9, true))->isSame(7); // 範囲内なのでそのまま
     * that(clamp(8, 5, 9, true))->isSame(8); // 範囲内なのでそのまま
     * that(clamp(9, 5, 9, true))->isSame(9); // 範囲内なのでそのまま
     * that(clamp(10, 5, 9, true))->isSame(5); // 10 は [5～9] の範囲外なので循環して 5 になる
     * ```
     *
     * @param int|mixed $value 対象の値
     * @param int|mixed $min 最小値
     * @param int|mixed $max 最大値
     * @param bool $circulative true だと切り詰めるのではなく循環する
     * @return int 一定範囲に収められた値
     */
    public static function clamp($value, $min, $max, $circulative = false)
    {
        if (!$circulative) {
            return max($min, min($max, $value));
        }

        if ($value < $min) {
            return $max + ($value - $max) % ($max - $min + 1);
        }
        if ($value > $max) {
            return $min + ($value - $min) % ($max - $min + 1);
        }
        return $value;
    }

    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 1 ～ 6 のどれかを返す
     * that(random_at(1, 2, 3, 4, 5, 6))->isAny([1, 2, 3, 4, 5, 6]);
     * ```
     *
     * @param array $args 候補
     * @return mixed 引数のうちどれか
     */
    public static function random_at(...$args)
    {
        return $args[mt_rand(0, count($args) - 1)];
    }

    /**
     * 一定確率で true を返す
     *
     * 具体的には $probability / $divisor の確率で true を返す。
     * $divisor のデフォルトは 100 にしてあるので、 $probability だけ与えれば $probability パーセントで true を返すことになる。
     *
     * Example:
     * ```php
     * // 50% の確率で "hello" を出す
     * if (probability(50)) {
     *     echo "hello";
     * }
     * ```
     *
     * @param int $probability 分子
     * @param int $divisor 分母
     * @return bool true or false
     */
    public static function probability($probability, $divisor = 100)
    {
        $probability = (int) $probability;
        if ($probability < 0) {
            throw new \InvalidArgumentException('$probability must be positive number.');
        }
        $divisor = (int) $divisor;
        if ($divisor < 0) {
            throw new \InvalidArgumentException('$divisor must be positive number.');
        }
        // 不等号の向きや=の有無が怪しかったのでメモ
        // 1. $divisor に 100 が与えられたとすると、取り得る範囲は 0 ～ 99（100個）
        // 2. $probability が 1 だとするとこの式を満たす数は 0 の1個のみ
        // 3. 100 個中1個なので 1%
        return $probability > mt_rand(0, $divisor - 1);
    }

    /**
     * 正規乱数（正規分布に従う乱数）を返す
     *
     * ※ ボックス＝ミュラー法
     *
     * Example:
     * ```php
     * mt_srand(4); // テストがコケるので種固定
     *
     * // 平均 100, 標準偏差 10 の正規乱数を得る
     * that(normal_rand(100, 10))->isSame(101.16879645296162);
     * that(normal_rand(100, 10))->isSame(96.49615862542069);
     * that(normal_rand(100, 10))->isSame(87.74557282679618);
     * that(normal_rand(100, 10))->isSame(117.93697951557125);
     * that(normal_rand(100, 10))->isSame(99.1917453115627);
     * that(normal_rand(100, 10))->isSame(96.74688207698713);
     * ```
     *
     * @param float $average 平均
     * @param float $std_deviation 標準偏差
     * @return float 正規乱数
     */
    public static function normal_rand($average = 0.0, $std_deviation = 1.0)
    {
        static $z2, $rand_max, $generate = true;
        $rand_max = $rand_max ?? mt_getrandmax();
        $generate = !$generate;

        if ($generate) {
            return $z2 * $std_deviation + $average;
        }

        $u1 = mt_rand(1, $rand_max) / $rand_max;
        $u2 = mt_rand(0, $rand_max) / $rand_max;
        $v1 = sqrt(-2 * log($u1));
        $v2 = 2 * M_PI * $u2;
        $z1 = $v1 * cos($v2);
        $z2 = $v1 * sin($v2);

        return $z1 * $std_deviation + $average;
    }
}
