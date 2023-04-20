<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 現在日時を float で返す
 *
 * microtime(true) と同じ。
 * ただし、引数 $persistence を true(デフォルト) にすると以降の呼び出しですべて同じ値を返すようになる。
 *
 * Example:
 * ```php
 * // 現在時刻
 * $now = now();
 * sleep(1);
 * // 1秒経っても同じ値を返す
 * that(now())->is($now);
 * // false を与えると新しい時刻を返す
 * that(now(false))->isNot($now);
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param bool $persistence 固定化フラグ
 * @return float 現在日時
 */
function now($persistence = true)
{
    static $now = null;
    if ($now === null || !$persistence) {
        $now = microtime(true);
    }
    return $now;
}
