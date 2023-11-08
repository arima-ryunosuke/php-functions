<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_find.php';
require_once __DIR__ . '/../datetime/date_timestamp.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
require_once __DIR__ . '/../syntax/throws.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * 日時文字列をよしなに別のフォーマットに変換する
 *
 * マイクロ秒にも対応している。
 * かなり適当に和暦にも対応している。
 *
 * 拡張書式は下記。
 * - J: 日本元号
 *   - e.g. 平成
 *   - e.g. 令和
 * - b: 日本元号略称
 *   - e.g. H
 *   - e.g. R
 * - k: 日本元号年
 *   - e.g. 平成7年
 *   - e.g. 令和1年
 * - K: 日本元号年（1年が元年）
 *   - e.g. 平成7年
 *   - e.g. 令和元年
 * - x: 日本語曜日
 *   - e.g. 日
 *   - e.g. 月
 * - Q: 月内週番号（商が第N、余が曜日）
 *   - e.g. 6（7 * 0 + 6 第1土曜日）
 *   - e.g. 15（7 * 2 + 1 第3月曜日）
 *
 * php8.2 から x,X が追加されたため上記はあくまで参考となる。
 *
 * Example:
 * ```php
 * // 和暦を Y/m/d H:i:s に変換
 * that(date_convert('Y/m/d H:i:s', '昭和31年12月24日 12時34分56秒'))->isSame('1956/12/24 12:34:56');
 * // 単純に「マイクロ秒が使える date」としても使える
 * $now = 1234567890.123; // テストがしづらいので固定時刻にする
 * that(date_convert('Y/m/d H:i:s.u', $now))->isSame('2009/02/14 08:31:30.122999');
 * // $format に DateTimeInterface 実装クラス名を与えるとそのインスタンスを返す
 * that(date_convert(\DateTimeImmutable::class, $now))->isInstanceOf(\DateTimeImmutable::class);
 * // null は DateTime を意味する
 * that(date_convert(null, $now))->isInstanceOf(\DateTime::class);
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @todo 引数を入れ替えたほうが自然な気がする
 *
 * @param ?string $format フォーマット
 * @param string|int|float|\DateTimeInterface|null $datetimedata 日時データ。省略時は microtime
 * @return string|\DateTimeInterface 日時文字列。$format が null の場合は DateTime
 */
function date_convert($format, $datetimedata = null)
{
    $format ??= \DateTime::class;
    $return_object = class_exists($format) && is_subclass_of($format, \DateTimeInterface::class);

    if ($return_object && $datetimedata instanceof \DateTimeInterface) {
        return $datetimedata;
    }

    // 省略時は microtime
    if ($datetimedata === null) {
        $timestamp = microtime(true);
    }
    else {
        $timestamp = date_timestamp($datetimedata);
        if ($timestamp === null) {
            throw new \InvalidArgumentException("parse failed '$datetimedata'");
        }
    }

    if (!$return_object) {
        $era = array_find(JP_ERA, function ($era) use ($timestamp) {
            if ($era['since'] <= $timestamp) {
                $era['year'] = idate('Y', (int) $timestamp) - idate('Y', $era['since']) + 1;
                $era['gann'] = $era['year'] === 1 ? '元' : $era['year'];
                return $era;
            }
        }, false);
        $format = strtr_escaped($format, [
            'J' => fn() => $era ? $era['name'] : throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
            'b' => fn() => $era ? $era['abbr'] : throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
            'k' => fn() => $era ? $era['year'] : throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
            'K' => fn() => $era ? $era['gann'] : throws(new \InvalidArgumentException("notfound JP_ERA '$datetimedata'")),
            'x' => fn() => ['日', '月', '火', '水', '木', '金', '土'][idate('w', (int) $timestamp)],
            'Q' => fn() => idate('w', $timestamp) + intdiv(idate('j', $timestamp) - 1, 7) * 7,
        ], '\\');
    }

    if (is_int($timestamp) && !$return_object) {
        return date($format, $timestamp);
    }

    $class = $return_object ? $format : \DateTime::class;
    $dt = new $class();
    $dt = $dt->setTimestamp((int) $timestamp);

    if (is_float($timestamp)) {
        $diff = (int) (($timestamp - (int) $timestamp) * 1000 * 1000);
        $dt = $dt->modify("$diff microsecond");
    }

    if ($return_object) {
        return $dt;
    }
    return $dt->format($format);
}
