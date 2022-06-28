<?php

namespace ryunosuke\Functions\Package;

/**
 * 数学関連のユーティリティ
 */
class Math implements Interfaces\Math
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    public static function minimum(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    public static function maximum(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    public static function mode(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return Vars::stringify($v);
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    public static function mean(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or Syntax::throws(new \LengthException("argument's must be contain munber."));
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    public static function median(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
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
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    public static function sum(...$variadic)
    {
        $args = Arrays::array_flatten($variadic) or Syntax::throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or Syntax::throws(new \LengthException("argument's must be contain munber."));
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
     * 数値を指定桁数に丸める
     *
     * 感覚的には「桁数指定できる ceil/floor」に近い。
     * ただし、正の方向(ceil)、負の方向(floor)以外にも0の方向、無限大の方向も実装されている（さらに四捨五入もできる）。
     *
     * - 0   : 0 に近づく方向： 絶対値が必ず減る
     * - null: 0 から離れる方向： 絶対値が必ず増える
     * - -INF: 負の無限大の方向： 数値として必ず減る
     * - +INF : 正の無限大の方向： 数値として必ず増える
     *
     * のように「持っていきたい方向（の数値）」を指定すれば良い（正負自動だけ null で特殊だが）。
     *
     * Example:
     * ```php
     * that(decimal(-3.14, 1, 0))->isSame(-3.1);    // 0 に近づく方向
     * that(decimal(-3.14, 1, null))->isSame(-3.2); // 0 から離れる方向
     * that(decimal(-3.14, 1, -INF))->isSame(-3.2); // 負の無限大の方向
     * that(decimal(-3.14, 1, +INF))->isSame(-3.1); // 正の無限大の方向
     *
     * that(decimal(3.14, 1, 0))->isSame(3.1);    // 0 に近づく方向
     * that(decimal(3.14, 1, null))->isSame(3.2); // 0 から離れる方向
     * that(decimal(3.14, 1, -INF))->isSame(3.1); // 負の無限大の方向
     * that(decimal(3.14, 1, +INF))->isSame(3.2); // 正の無限大の方向
     * ```
     *
     * @param int|float $value 丸める値
     * @param int $precision 有効桁数
     * @param mixed $mode 丸めモード（0 || null || ±INF || PHP_ROUND_HALF_XXX）
     * @return float 丸めた値
     */
    public static function decimal($value, $precision = 0, $mode = 0)
    {
        $precision = (int) $precision;

        if ($precision === 0) {
            if ($mode === 0) {
                return (float) (int) $value;
            }
            if ($mode === INF) {
                return ceil($value);
            }
            if ($mode === -INF) {
                return floor($value);
            }
            if ($mode === null) {
                return $value > 0 ? ceil($value) : floor($value);
            }
            if (in_array($mode, [PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, PHP_ROUND_HALF_ODD], true)) {
                return round($value, $precision, $mode);
            }
            throw new \InvalidArgumentException('$precision must be either null, 0, INF, -INF');
        }

        if ($precision > 0 && 10 ** PHP_FLOAT_DIG <= abs($value)) {
            trigger_error('it exceeds the valid values', E_USER_WARNING);
        }

        $k = 10 ** $precision;
        return Math::decimal($value * $k, 0, $mode) / $k;
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
     * @param mixed ...$args 候補
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
        $rand_max ??= mt_getrandmax();
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

    /**
     * 数式を計算して結果を返す
     *
     * 内部的には eval で計算するが、文字列や関数呼び出しなどは受け付けないため原則としてセーフティ。
     * 許可されるのは定数・数値リテラルと演算子のみ。
     * 定数を許可しているのは PI(3.14) や HOUR(3600) などの利便性のため。
     * 定数値が非数値の場合、強制的に数値化して警告を促す。
     *
     * Example:
     * ```php
     * that(calculate_formula('1 + 2 - 3 * 4'))->isSame(-9);
     * that(calculate_formula('1 + (2 - 3) * 4'))->isSame(-3);
     * that(calculate_formula('PHP_INT_SIZE * 3'))->isSame(PHP_INT_SIZE * 3);
     * ```
     *
     * @param string $formula 計算式
     * @return int|float 計算結果
     */
    public static function calculate_formula($formula)
    {
        // TOKEN_PARSE を渡せばシンタックスチェックも行ってくれる
        $tokens = Syntax::parse_php("<?php ($formula);", [
            'phptag' => false,
            'flags'  => TOKEN_PARSE,
        ]);
        array_shift($tokens);
        array_pop($tokens);

        $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR];
        // @codeCoverageIgnoreStart
        if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
            /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
            $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR, T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE];
        }
        // @codeCoverageIgnoreEnd
        $operands = [T_LNUMBER, T_DNUMBER];
        $operators = ['(', ')', '+', '-', '*', '/', '%', '**'];

        $constant = '';
        $expression = '';
        foreach ($tokens as $token) {
            if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                continue;
            }
            if (in_array($token[0], $constants, true)) {
                $constant .= $token[1];
            }
            elseif (in_array($token[0], $operands, true) || in_array($token[1], $operators, true)) {
                if (strlen($constant)) {
                    $expression .= constant($constant) + 0;
                    $constant = '';
                }
                $expression .= $token[1];
            }
            else {
                throw new \ParseError(sprintf("syntax error, unexpected '%s' in  on line %d", $token[1], $token[2]));
            }
        }
        return Syntax::evaluate("return $expression;");
    }
}
