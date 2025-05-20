<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../syntax/blank_if.php';
// @codeCoverageIgnoreEnd

/**
 * blank_if の可変引数版
 *
 * blank ではない最初の引数を返す。
 * blank_if は設計が古い & 可変対応すると名前が適切ではなくなってしまうので新設。
 *
 * Example:
 * ```php
 * // 処理自体は blank_if と同じ
 * that(blank_coalesce(null, false, '', [], 'X'))->is('X');
 * ```
 *
 * @package ryunosuke\Functions\Package\syntax
 *
 * @template T of mixed
 * @param T ...$args 値
 * @return T blank ではない最初の引数
 */
function blank_coalesce(...$args)
{
    foreach ($args as $arg) {
        if (blank_if($arg) !== null) {
            return $arg;
        }
    }
    return null;
}
