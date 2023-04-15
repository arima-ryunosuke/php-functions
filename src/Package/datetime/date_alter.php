<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_timestamp.php';
// @codeCoverageIgnoreEnd

/**
 * 日付を除外日リストに基づいてずらす
 *
 * 典型的には「祝日前の営業日」「祝日後の営業日」のような代理日を返すイメージ。
 * $follow_count に応じて下記のように返す。
 *
 * - null: 除外日でもずらさないでそのまま返す
 * - -N: 除外日なら最大N日分前倒しした日付を返す
 * - +N: 除外日なら最大N日分先送りした日付を返す
 * - 0: 除外日でもずらさないで null を返す
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string|int|\DateTimeInterface $datetime 調べる日付
 * @param array $excluded_dates 除外日（いわゆる祝休日リスト）
 * @param ?int $follow_count ずらす範囲
 * @param string $format 日付フォーマット（$excluded_dates の形式＋返り値の形式）
 * @return string|null 代替日。除外日 null
 */
function date_alter($datetime, $excluded_dates, $follow_count, $format = 'Y-m-d')
{
    $timestamp = date_timestamp($datetime);
    if (!array_key_exists($date = date($format, $timestamp), $excluded_dates)) {
        return $date;
    }
    if ($follow_count === null) {
        return $date;
    }
    $follow_count = (int) $follow_count;
    if ($follow_count < 0) {
        return date_alter($timestamp - 24 * 3600, $excluded_dates, $follow_count + 1, $format);
    }
    if ($follow_count > 0) {
        return date_alter($timestamp + 24 * 3600, $excluded_dates, $follow_count - 1, $format);
    }
    return null;
}
