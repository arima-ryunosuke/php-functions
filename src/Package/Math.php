<?php

namespace ryunosuke\Functions\Package;

class Math
{
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(minimum(-1, 0, 1), -1);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    public static function minimum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        return min($args);
    }

    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * assertSame(maximum(-1, 0, 1), 1);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    public static function maximum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
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
     * <code>
     * assertSame(mode(0, 1, 2, 2, 3, 3, 3), 3);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    public static function mode(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return call_user_func(stringify, $v);
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
     * <code>
     * assertSame(mean(1, 2, 3, 4, 5, 6), 3.5);
     * assertSame(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6), 3.5);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    public static function mean(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or call_user_func(throws, new \LengthException("argument's must be contain munber."));
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
     * <code>
     * // 偶数個なので中2つの平均
     * assertSame(median(1, 2, 3, 4, 5, 6), 3.5);
     * // 奇数個なのでど真ん中
     * assertSame(median(1, 2, 3, 4, 5), 3);
     * // 偶数個だが文字列なので中2つの後
     * assertSame(median('a', 'b', 'c', 'd'), 'c');
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    public static function median(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
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
     * @package Math
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
     * <code>
     * assertSame(sum(1, 2, 3, 4, 5, 6), 21);
     * </code>
     *
     * @package Math
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    public static function sum(...$variadic)
    {
        $args = call_user_func(array_flatten, $variadic) or call_user_func(throws, new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or call_user_func(throws, new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }

    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * <code>
     * srand(1);mt_srand(1);
     * assertSame(random_at(1, 2, 3, 4, 5, 6), 4);
     * assertSame(random_at(1, 2, 3, 4, 5, 6), 1);
     * </code>
     *
     * @package Math
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
     * <code>
     * srand(1);mt_srand(1);
     * assertFalse(probability(50));
     * assertTrue(probability(50));
     * </code>
     *
     * @package Math
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
}
