<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
// @codeCoverageIgnoreEnd

/**
 * 日時文字列のバリデーション
 *
 * 存在しない日付・時刻・相対指定などは全て不可。
 * あくまで「2014/12/24 12:34:56」のような形式と妥当性だけでチェックする。
 * $overhour 引数で 27:00 のような拡張時刻も許容させることができる（6 を指定すればいわゆる30時間制になる）。
 *
 * 日時形式は結構複雑なので「正しいはずだがなぜか false になる」という事象が頻発する。
 * その時、調査が大変（どの段階で false になっているか分からない）なので＠で抑制しつつも内部的には user_error を投げている。
 * このエラーは error_get_last で取得可能だが、行儀の悪い（＠抑制を見ない）エラーハンドラが設定されていると例外として送出されることがあるので注意。
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string $datetime_string 日付形式の文字列
 * @param string $format フォーマット文字列
 * @param int $overhour 24時以降をどこまで許すか
 * @return bool valid な日時なら true
 */
function date_validate($datetime_string, $format = 'Y/m/d H:i:s', $overhour = 0)
{
    $inrange = fn($value, $min, $max) => $min <= $value && $value <= $max;

    try {
        $parsed = date_parse_from_format($format, $datetime_string);

        if ($parsed['error_count']) {
            throw new \ErrorException(array_sprintf($parsed['errors'], '#%2$s %1$s', "\n"));
        }

        ['year' => $year, 'month' => $month, 'day' => $day] = $parsed;

        if ($year !== false && $month !== false && $day !== false && !checkdate($month, $day, $year)) {
            throw new \ErrorException("invalid date '$year-$month-$day'");
        }
        elseif ($year !== false && !$inrange($year, 0, 9999)) {
            // 現状のパラメ－タで 0~9999 以外の年が来ることはない
            throw new \ErrorException("invalid year '$year'"); // @codeCoverageIgnore
        }
        elseif ($month !== false && !$inrange($month, 1, 12)) {
            throw new \ErrorException("invalid month '$month'");
        }
        elseif ($day !== false && !$inrange($day, 1, 31)) {
            throw new \ErrorException("invalid day '$day'");
        }

        ['hour' => $hour, 'minute' => $minute, 'second' => $second] = $parsed;

        if ($hour !== false && !$inrange($hour, 0, 23 + $overhour)) {
            throw new \ErrorException("invalid hour '$hour'");
        }
        elseif ($minute !== false && !$inrange($minute, 0, 59)) {
            throw new \ErrorException("invalid minute '$minute'");
        }
        elseif ($second !== false && !$inrange($second, 0, 59)) {
            throw new \ErrorException("invalid second '$second'");
        }

        return true;
    }
    catch (\Throwable $t) {
        @trigger_error($t->getMessage());
        return false;
    }
}
