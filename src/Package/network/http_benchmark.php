<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../dataformat/markdown_table.php';
require_once __DIR__ . '/../math/mean.php';
require_once __DIR__ . '/../network/http_requests.php';
// @codeCoverageIgnoreEnd

/**
 * http のベンチマークを取る
 *
 * 結果の各意味合いは下記の通り。
 * - status: http status code の統計
 *   - 200 以外が混ざっている場合は何かが間違ってるので結果を疑うべき
 * - wait: 接続確立後から最初の応答までの時間（いわゆる TTFB）
 *   - ストリーミングなどしていなければ（かつ相手先が php であれば）これが実質的な応答速度と言える（バッファリングされるため transfer はただの消化試合になる）
 *   - 全体として遅いならスコアは低いと言ってよい
 *   - min/max の差が激しいならおそらく捌き切れていない（backlog に溜まるなど）
 * - transfer: 最初の応答から全レスポンス完了までの時間
 *   - いわゆる帯域…のような単純な値ではない
 *   - 例えばストリーミングをしている場合はその生成速度と言える
 * - total: TCP/TLS 等のメタい時間を除いた合計時間
 *   - レスポンスサイズに引きずられるため参考程度でよい
 *   - 敢えて言うなら min/max の差が激しいようなら何かを疑うべき
 *
 * 例えば下記のような php のベンチを取ると概ね wait:1, transfer:2, total:3 になる。
 *
 * ```
 * ob_end_clean();
 * sleep(1);
 * echo "wait";
 * flush();
 * sleep(2);
 * echo 'done';
 * ```
 *
 * 外れ値のフィルタなどは行わない。
 * 例えば backlog に溜まって応答が10倍になったとしてもそれは外れ値ではないだろう。
 * と考えるとそもそも「外れ値」の定義自体が不可能であり、余計なことは一切しない。
 *
 * @package ryunosuke\Functions\Package\network
 */
function http_bechmark(
    /** URLs */ array|string $urls,
    /** 合計リクエスト */ int $requests = 10,
    /** 同時接続数 */ int $concurrency = 3,
    /** @param null|resource|bool 出力先（省略時は標準出力） */ $output = null,
): /** 結果配列 */ array
{
    assert($requests > 0);
    assert($concurrency > 0);

    $urls = (array) $urls;
    assert(count($urls) > 0);

    $output ??= fopen('php://output', 'w');

    $results = [];

    foreach ($urls as $url => $data) {
        // 特に意味はないが、接続が残っていたりするかもしれないのでやっておいて損はないだろう
        gc_collect_cycles();

        if (!is_array($data)) {
            $data = ['url' => $data];
        }
        $curl = $data + ['url' => $url];

        http_requests(array_pad([], $requests, $curl), [
            CURLOPT_FORBID_REUSE   => true,  // ベンチマーク目的なら切るべき…とは思う
            CURLOPT_FOLLOWLOCATION => false, // リダイレクトがあるのは本当のベンチマークではないと思う
        ], [
            'chunk' => $concurrency,
        ], $infos);

        $status = [];
        $waiting = [];
        $transfer = [];
        $total = [];
        $start = [];
        $end = [];
        foreach ($infos as [, $info]) {
            // namelookup(DNS resolve)
            // ---------->connect(TCP handshake)
            // ------------------>appconnect(TLS handshake)
            // ----------------------------->pretransfer(TLS cipher spec)
            // ----------------------------------------->starttransfer(send request and TTFB)
            // ------------------------------------------------------->total(complete)
            $status[] = $info['http_code'];
            $waiting[] = $w = $info['starttransfer_time'] - $info['pretransfer_time'];
            $transfer[] = $r = $info['total_time'] - $info['starttransfer_time'];
            $total[] = $t = $w + $r;
            $start[] = $info['start'];
            $end[] = $info['start'] + $t;
        }

        $results[$infos[0][1]['url']] = [
            'status'         => array_count_values($status),
            'wait'           => $waiting,
            'transfer'       => $transfer,
            'total'          => $total,
            'request/second' => $requests / (max($end) - min($start)),
        ];
    }

    $minmills = min(array_column($results, 'request/second'));
    foreach ($results as &$result) {
        $result['ratio'] = $result['request/second'] / $minmills;
    }
    uasort($results, fn($a, $b) => $b['ratio'] <=> $a['ratio']);

    if ($output) {
        $number_format = function ($value, $ratio = 1, $decimal = 0, $nullvalue = '') {
            return $value === null ? $nullvalue : number_format($value * $ratio, $decimal);
        };
        fprintf($output, "Running %s urls (n/c=%s/%s):\n", count($urls), $number_format($requests), $number_format($concurrency));
        fwrite($output, markdown_table(array_map(function ($v) use ($number_format) {
            return [
                'status'         => array_sprintf($v['status'], '%2$s:%1$s', ', '),
                'wait(min)'      => $number_format(min($v['wait']), 1, 6),
                'wait(max)'      => $number_format(max($v['wait']), 1, 6),
                'wait(avg)'      => $number_format(mean($v['wait']), 1, 6),
                'transfer(min)'  => $number_format(min($v['transfer']), 1, 6),
                'transfer(max)'  => $number_format(max($v['transfer']), 1, 6),
                'transfer(avg)'  => $number_format(mean($v['transfer']), 1, 6),
                'total(min)'     => $number_format(min($v['total']), 1, 6),
                'total(max)'     => $number_format(max($v['total']), 1, 6),
                'total(avg)'     => $number_format(mean($v['total']), 1, 6),
                'request/second' => $number_format($v['request/second'], 1, 3),
                'ratio'          => $v['ratio'],
            ];
        }, $results), ['keylabel' => 'url', 'context' => null]));
    }

    return $results;
}
