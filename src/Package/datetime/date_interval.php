<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_pos_key.php';
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
require_once __DIR__ . '/../syntax/switchs.php';
require_once __DIR__ . '/../syntax/throws.php';
// @codeCoverageIgnoreEnd

/**
 * 秒を世紀・年・月・日・時間・分・秒・ミリ秒の各要素に分解する
 *
 * 例えば `60 * 60 * 24 * 900 + 12345.678` （約900日12345秒）は・・・
 *
 * - 2 年（約900日なので）
 * - 5 ヶ月（約(900 - 365 * 2 = 170)日なので）
 * - 18 日（約(170 - 30.416 * 5 = 18)日なので）
 * - 3 時間（約12345秒なので）
 * - 25 分（約(12345 - 3600 * 3 = 1545)秒なので）
 * - 45 秒（約(1545 - 60 * 25 = 45)秒なので）
 * - 678 ミリ秒（.678 部分そのまま）
 *
 * となる（年はうるう年未考慮で365日、月は30.41666666日で換算）。
 *
 * $format を与えると DateInterval::format して文字列で返す。与えないと DateInterval をそのまま返す。
 * $format はクロージャを与えることができる。クロージャを与えた場合、各要素を引数としてコールバックされる。
 * $format は配列で与えることができる。配列で与えた場合、 0 になる要素は省かれる。
 * セパレータを与えたり、pre/suffix を与えたりできるが、難解なので省略する。
 *
 * $limit_type で換算のリミットを指定できる。例えば 'y' を指定すると「2年5ヶ月」となるが、 'm' を指定すると「29ヶ月」となる。
 * 数値を与えるとその範囲でオートスケールする。例えば 3 を指定すると値が大きいとき `ymd` の表示になり、年が 0 になると `mdh` の表示に切り替わるようになる。
 *
 * Example:
 * ```php
 * // 書式文字列指定（%vはミリ秒）
 * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v'))->isSame('02/05/18 03:25:45.678');
 *
 * // 書式にクロージャを与えるとコールバックされる（引数はスケールの小さい方から）
 * that(date_interval(60 * 60 * 24 * 900 + 12345.678, fn() => implode(',', func_get_args())))->isSame('678,45,25,3,18,5,2,0');
 *
 * // リミットを指定（month までしか計算しないので year は 0 になり month は 29になる）
 * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'))->isSame('00/29/18 03:25:45.678');
 *
 * // 書式に配列を与えてリミットに数値を与えるとその範囲でオートスケールする
 * $format = [
 *     'y' => '%y年',
 *     'm' => '%mヶ月',
 *     'd' => '%d日',
 *     ' ',
 *     'h' => '%h時間',
 *     'i' => '%i分',
 *     's' => '%s秒',
 * ];
 * // 数が大きいので年・月・日の3要素のみ
 * that(date_interval(60 * 60 * 24 * 900 + 12345, $format, 3))->isSame('2年5ヶ月18日');
 * // 数がそこそこだと日・時間・分の3要素に切り替わる
 * that(date_interval(60 * 60 * 24 * 20 + 12345, $format, 3))->isSame('20日 3時間25分');
 * // どんなに数が小さくても3要素以下にはならない
 * that(date_interval(1234, $format, 3))->isSame('0時間20分34秒');
 *
 * // 書式指定なし（DateInterval を返す）
 * that(date_interval(123.456))->isInstanceOf(\DateInterval::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param int|float $sec タイムスタンプ
 * @param string|array|null $format 時刻フォーマット
 * @param string|int $limit_type どこまで換算するか（[c|y|m|d|h|i|s]）
 * @return string|\DateInterval 時間差文字列 or DateInterval オブジェクト
 */
function date_interval($sec, $format = null, $limit_type = 'y')
{
    $ymdhisv = ['c', 'y', 'm', 'd', 'h', 'i', 's', 'v'];
    $map = ['c' => 7, 'y' => 6, 'm' => 5, 'd' => 4, 'h' => 3, 'i' => 2, 's' => 1];
    if (ctype_digit("$limit_type")) {
        $limit = $map['c'];
        $limit_type = (int) $limit_type;
        if (!is_array($format) && !is_null($format)) {
            throw new \UnexpectedValueException('$format must be array if $limit_type is digit.');
        }
    }
    else {
        $limit = $map[$limit_type] ?? throws(new \InvalidArgumentException("limit_type:$limit_type is undefined."));
    }

    // 各単位を導出
    $mills = $sec * 1000;
    $seconds = $sec;
    $minutes = $seconds / 60;
    $hours = $minutes / 60;
    $days = $hours / 24;
    $months = $days / (365 / 12);
    $years = $days / 365;
    $centurys = $years / 100;

    // $limit に従って値を切り捨てて DateInterval を作成
    $interval = new \DateInterval('PT1S');
    $interval->c = $limit < $map['c'] ? 0 : (int) $centurys % 1000;
    $interval->y = $limit < $map['y'] ? 0 : (int) ($limit === $map['y'] ? $years : (int) $years % 100);
    $interval->m = $limit < $map['m'] ? 0 : (int) ($limit === $map['m'] ? $months : (int) $months % 12);
    $interval->d = $limit < $map['d'] ? 0 : (int) ($limit === $map['d'] ? $days : (int) ((int) ($days * 100000000) % (int) (365 / 12 * 100000000) / 100000000));
    $interval->h = $limit < $map['h'] ? 0 : (int) ($limit === $map['h'] ? $hours : (int) $hours % 24);
    $interval->i = $limit < $map['i'] ? 0 : (int) ($limit === $map['i'] ? $minutes : (int) $minutes % 60);
    $interval->s = $limit < $map['s'] ? 0 : (int) ($limit === $map['s'] ? $seconds : (int) $seconds % 60);
    $interval->v = $mills % 1000;

    // null は DateInterval をそのまま返す
    if ($format === null) {
        return $interval;
    }

    // クロージャはコールバックする
    if ($format instanceof \Closure) {
        return $format($interval->v, $interval->s, $interval->i, $interval->h, $interval->d, $interval->m, $interval->y, $interval->c);
    }

    // 配列はいろいろとフィルタする
    if (is_array($format)) {
        // 数値ならその範囲でオートスケール
        if (is_int($limit_type)) {
            // 配列を回して値があるやつ + $limit_type の範囲とする
            foreach ($ymdhisv as $n => $key) {
                // 最低 $limit_type は保持するために isset する
                if ($interval->$key > 0 || !isset($ymdhisv[$n + $limit_type + 1])) {
                    $pos = [];
                    for ($i = 0; $i < $limit_type; $i++) {
                        if (isset($ymdhisv[$n + $i])) {
                            if (($p = array_pos_key($format, $ymdhisv[$n + $i], -1)) >= 0) {
                                $pos[] = $p;
                            }
                        }
                    }
                    if (!$pos) {
                        throw new \UnexpectedValueException('$format is empty.');
                    }
                    // 順不同なので min/max から slice しなければならない
                    $min = min($pos);
                    $max = max($pos);
                    $format = array_slice($format, $min, $max - $min + 1);
                    break;
                }
            }
        }

        // 来ている $format を正規化（日時文字列は配列にするかつ値がないならフィルタ）
        $tmp = [];
        foreach ($format as $key => $fmt) {
            if (isset($interval->$key)) {
                if (!is_int($limit_type) && $interval->$key === 0) {
                    $tmp[] = ['', '', ''];
                    continue;
                }
                $fmt = arrayize($fmt);
                $fmt = switchs(count($fmt), [
                    1 => static fn() => ['', $fmt[0], ''],
                    2 => static fn() => ['', $fmt[0], $fmt[1]],
                    3 => static fn() => array_values($fmt),
                ]);
            }
            $tmp[] = $fmt;
        }
        // さらに前後の値がないならフィルタ
        $tmp2 = [];
        foreach ($tmp as $n => $fmt) {
            $prevempty = true;
            for ($i = $n - 1; $i >= 0; $i--) {
                if (!is_array($tmp[$i])) {
                    break;
                }
                if (strlen($tmp[$i][1])) {
                    $prevempty = false;
                    break;
                }
            }
            $nextempty = true;
            for ($i = $n + 1, $l = count($tmp); $i < $l; $i++) {
                if (!is_array($tmp[$i])) {
                    break;
                }
                if (strlen($tmp[$i][1])) {
                    $nextempty = false;
                    break;
                }
            }

            if (is_array($fmt)) {
                if ($prevempty) {
                    $fmt[0] = '';
                }
                if ($nextempty) {
                    $fmt[2] = '';
                }
            }
            elseif ($prevempty || $nextempty) {
                $fmt = '';
            }
            $tmp2 = array_merge($tmp2, arrayize($fmt));
        }
        $format = implode('', $tmp2);
    }

    $format = strtr_escaped($format, [
        '%c' => $interval->c,
        '%v' => $interval->v,
    ], '%');
    return $interval->format($format);
}
