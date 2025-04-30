<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_benchmark.php';
// @codeCoverageIgnoreEnd

/**
 * @see http_benchmark()
 * @deprecated スペルミス
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\network
 */
function http_bechmark(
    /** URLs */ array|string $urls,
    /** 合計リクエスト */ int $requests = 10,
    /** 同時接続数 */ int $concurrency = 3,
    /** @param null|resource|bool 出力先（省略時は標準出力） */ $output = null,
): /** 結果配列 */ array
{
    trigger_error(__FUNCTION__ . ' is deprecated. use http_benchmark', E_USER_DEPRECATED);
    return http_benchmark(...func_get_args());
}
