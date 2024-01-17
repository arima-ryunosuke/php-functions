<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_convert.php';
require_once __DIR__ . '/../datetime/date_interval.php';
require_once __DIR__ . '/../datetime/date_parse_format.php';
require_once __DIR__ . '/../var/is_decimal.php';
// @codeCoverageIgnoreEnd

/**
 * range を少し改良したもの
 *
 * - 文字列に対応
 * - 日時に対応
 * - $start, $end から $step の自動算出
 * - $start < $end で $step < 0 の場合、空配列を返す
 * - $start > $end で $step > 0 の場合、空配列を返す
 *
 * 逆に言うと $start, $end の大小を意識しないと正しい値は返らないことになる。
 * 標準 range の下記の挙動が個人的に違和感があるので実装した。
 *
 * - range(1, 3, -1); // [1, 2, 3]
 * - range(3, 1, +1); // [3, 2, 1]
 *
 * Example:
 * ```php
 * // 文字列（具体的にはデクリメント）
 * that(array_range('a', 'c', +1))->isSame(['a', 'b', 'c']);
 * that(array_range('c', 'a', -1))->isSame(['c', 'b', 'a']);
 *
 * // 日時
 * that(array_range('2014/12/24 12:34:56', '2014/12/26 12:34:56', 'P1D', ['format' => 'Y/m/d H:i:s']))->isSame([
 *     '2014/12/24 12:34:56',
 *     '2014/12/25 12:34:56',
 *     '2014/12/26 12:34:56',
 * ]);
 * that(array_range('2014/12/26 12:34:56', '2014/12/24 12:34:56', 'P-1D', ['format' => 'Y/m/d H:i:s']))->isSame([
 *     '2014/12/26 12:34:56',
 *     '2014/12/25 12:34:56',
 *     '2014/12/24 12:34:56',
 * ]);
 *
 * // step は省略可能（+/-1 になる）
 * that(array_range(1, 3))->isSame([1, 2, 3]);
 * that(array_range(3, 1))->isSame([3, 2, 1]);
 * that(array_range('a', 'c'))->isSame(['a', 'b', 'c']);
 * that(array_range('c', 'a'))->isSame(['c', 'b', 'a']);
 *
 * // 範囲外は空配列を返す
 * that(array_range(1, 3, -1))->isSame([]);
 * that(array_range(3, 1, +1))->isSame([]);
 * that(array_range('a', 'c', -1))->isSame([]);
 * that(array_range('c', 'a', +1))->isSame([]);
 * that(array_range('2014/12/24', '2014/12/27', 'P-1D'))->isSame([]);
 * that(array_range('2014/12/27', '2014/12/24', 'P1D'))->isSame([]);
 * ```
 *
 * @package ryunosuke\Functions\Package\array
 *
 * @param int|float|string|\DateTimeInterface $start 最初の値
 * @param int|float|string|\DateTimeInterface $end 最後の値
 * @param int|float|string|null|\DateInterval $step 増分
 * @return array $start ~ $end の配列
 */
function array_range($start, $end, $step = null, $options = [])
{
    $options += [
        'format' => null,
    ];

    // 数値モード
    if (true
        && is_decimal($start)
        && is_decimal($end)
        && ($step === null || is_decimal($step))
    ) {
        if ($step === null) {
            if ($start < $end) {
                $step = (is_float($start) || is_float($end)) ? +1.0 : +1;
            }
            if ($start >= $end) {
                $step = (is_float($start) || is_float($end)) ? -1.0 : -1;
            }
        }
        if (empty($step)) {
            throw new \InvalidArgumentException("\$step is empty($step)");
        }

        if (is_float($step)) {
            $start = (float) $start;
            $end = (float) $end;
            $step = (float) $step;
        }
        else {
            $start = (int) $start;
            $end = (int) $end;
            $step = (int) $step;
        }

        $result = [];
        if ($step > 0) {
            for ($i = $start; $i <= $end; $i += $step) {
                $result[] = $i;
            }
        }
        if ($step < 0) {
            for ($i = $start; $i >= $end; $i += $step) {
                $result[] = $i;
            }
        }
        return $result;
    }

    // 文字列モード
    if (true
        && (is_string($start) && strlen($start))
        && (is_string($end) && strlen($end))
        && ($step === null || is_decimal($step, false))
    ) {
        if ($step === null) {
            $step = ($start <=> $end) < 0 ? +1 : -1;
        }
        if (empty($step)) {
            throw new \InvalidArgumentException("\$step is empty($step)");
        }

        // 単純な比較ではない（Z <=> aa < 1 のように中身によらず字数が大きい方が常に大きい）
        $compare = function ($a, $b) {
            if (($d = strlen($a) - strlen($b)) !== 0) {
                return $d;
            }
            for ($i = 0; $i < strlen($a); $i++) {
                if (($d = ($a[$i] <=> $b[$i])) !== 0) {
                    return $d;
                }
            }
            return 0;
        };

        // 1以上のインクリメントは対応していない
        $increment = function ($string, $step) {
            for ($i = 0; $i < $step; $i++) {
                $string++;
            }
            return $string;
        };

        $invert = $step < 0;

        // 文字列デクリメントは出来ないので reverse で対応する
        if ($invert) {
            $step = -$step;
            [$start, $end] = [$end, $start];
        }

        $result = [];
        if ($step > 0) {
            for ($i = $start; $compare($i, $end) <= 0; $i = $increment($i, $step)) {
                $result[] = $i;
            }
        }

        // 文字列デクリメントは（略）
        if ($invert) {
            if (count($result) === 1) {
                $result = [$end];
            }
            else {
                $result = array_reverse($result);
            }
        }

        return $result;
    }

    // 日時モード
    if (true
        && ($start instanceof \DateTimeInterface || (is_string($start) && strlen($start)))
        && ($end instanceof \DateTimeInterface || (is_string($end) && strlen($end)))
        && ($step instanceof \DateInterval || is_string($step))
    ) {
        try {
            if ($options['format'] === 'auto') {
                $options['format'] = (function (...$dts) {
                    foreach ($dts as $dt) {
                        if (is_string($dt) && ($format = date_parse_format($dt)) !== null) {
                            return $format;
                        }
                    }
                    throw new \InvalidArgumentException("failed to auto detect dateformat");
                })($start, $end);
            }

            if (is_string($start)) {
                $start = date_convert(\DateTimeImmutable::class, $start);
            }
            if ($start instanceof \DateTime) {
                $start = \DateTimeImmutable::createFromMutable($start);
            }
            if (is_string($end)) {
                $end = date_convert(\DateTimeImmutable::class, $end);
            }
            if ($end instanceof \DateTime) {
                $end = \DateTimeImmutable::createFromMutable($end);
            }
            if (is_string($step)) {
                $step = @\DateInterval::createFromDateString($step) ?: date_interval($step);
            }

            $now = new \DateTimeImmutable();
            $new = $now->add($step);

            if ($now == $new) {
                throw new \InvalidArgumentException("\$step is empty({$step->format('%RP%Y-%M-%DT%H:%I:%S.%F')})");
            }

            // $result = iterator_to_array(new \DatePeriod($start, $step, $end)); // happen too many bugs
            $result = [];
            if ($now > $new) {
                for ($i = $start; $i >= $end; $i = $i->add($step)) {
                    $result[] = $i;
                }
            }
            if ($now < $new) {
                for ($i = $start; $i <= $end; $i = $i->add($step)) {
                    $result[] = $i;
                }
            }
            if (isset($options['format'])) {
                $result = array_map(fn($dt) => $dt->format($options['format']), $result);
            }
            return $result;
        }
        catch (\Exception $e) {
            // through
        }
    }

    if (isset($e)) {
        throw $e;
    }
    throw new \InvalidArgumentException("failed to detect mode", 0, $e ?? null);
}
