<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_request.php';
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * http リクエストを並列で投げる
 *
 * $urls で複数の curl を渡し、並列で実行して複数の結果をまとめて返す。
 * $urls の要素は単一の文字列か curl のオプションである必要がある。
 * リクエストの実体は http_request なので、そっちで使えるオプションは一部を除きすべて使える。
 *
 * 返り値は $urls のキーを保持したまま、レスポンスが返ってきた順にボディを格納して配列で返す。
 * 構造は下記のサンプルを参照。
 *
 * Example:
 * ```php
 * $responses = http_requests([
 *     // このように [キー => CURL オプション] 形式が正しい使い方
 *     'fuga'             => [
 *         CURLOPT_URL     => 'http://unknown-host',
 *         CURLOPT_TIMEOUT => 5,
 *     ],
 *     // ただし、このように [キー => URL] 形式でもいい（オプションはデフォルトが使用される）
 *     'hoge'             => 'http://127.0.0.1',
 *     // さらに、このような [URL => CURL オプション] 形式も許容される（あまり用途はないだろうが）
 *     'http://127.0.0.1' => [
 *         CURLOPT_TIMEOUT => 5,
 *     ],
 * ], [
 *     // 第2引数で各リクエストの共通オプションを指定できる（個別指定優先）
 *     // @see https://www.php.net/manual/ja/function.curl-setopt.php
 * ], [
 *     // 第3引数でマルチリクエストのオプションを指定できる
 *     // @see https://www.php.net/manual/ja/function.curl-multi-setopt.php
 * ],
 *     // 第4引数を与えると動作が変わる（将来的にこの動作がデフォルトになる）
 *     $infos
 * );
 * # 第4引数を指定した場合の返り値
 * [
 *     // キーが維持されるので hoge キー
 *     'hoge'             => 'response body',
 *     // curl のエラーが出た場合は null になる（詳細なエラー情報は $infos に格納される）
 *     'fuga'             => null,
 *     'http://127.0.0.1' => 'response body',
 * ];
 * # 第4引数を指定しなかった場合の返り値
 * [
 *     // キーが維持されるので hoge キー
 *     'hoge'             => [
 *         // 0 番目の要素は body 文字列
 *         'response body',
 *         // 1 番目の要素は header 配列
 *         [
 *             // ・・・・・
 *             'Content-Type' => 'text/plain',
 *             // ・・・・・
 *         ],
 *         // 2 番目の要素は curl のメタ配列
 *         [
 *             // ・・・・・
 *         ],
 *     ],
 *     // curl のエラーが出た場合は int になる（CURLE_*** の値）
 *     'fuga'             => 6,
 * ];
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param array $urls 実行する curl オプション
 * @param array $single_options 全 $urls に適用されるデフォルトオプション
 * @param array $multi_options 並列リクエストとしてのオプション
 * @param array $infos curl 情報やヘッダなどが格納される受け変数
 * @return array レスポンスボディ配列。取得した順番でキーを保持しつつ追加される
 */
function http_requests($urls, $single_options = [], $multi_options = [], &$infos = [])
{
    $multi_options += [
        'throw' => false, // curl レイヤーでエラーが出たら例外を投げるか（http レイヤーではない）
    ];

    // 固定オプション（必ずこの値が使用される）
    $default = [
        'raw'                  => true,
        'throw'                => false,
        CURLOPT_FAILONERROR    => false,
        CURLOPT_RETURNTRANSFER => true, // 戻り値として返す
        CURLOPT_HEADER         => true, // ヘッダを含める
    ];

    $stringify_curl = function ($curl) {
        // スクリプトの実行中 (ウェブのリクエストや CLI プロセスの処理中) は、指定したリソースに対してこの文字列が一意に割り当てられることが保証されます
        if (is_resourcable($curl)) {
            return (string) $curl;
        }
        // @codeCoverageIgnoreStart
        if (is_object($curl)) {
            return spl_object_id($curl);
        }
        return null;
        // @codeCoverageIgnoreEnd
    };

    $responses = [];
    $resultmap = [];
    $infos = [];

    $set_response = function ($key, $body, $header, $info) use (&$responses, &$infos) {
        $responses[$key] = $body;
        $infos[$key] = [$header, $info];
    };

    $mh = curl_multi_init();
    foreach (array_filter($multi_options, 'is_int', ARRAY_FILTER_USE_KEY) as $name => $value) {
        curl_multi_setopt($mh, $name, $value);
    }

    try {
        foreach ($urls as $key => $opt) {
            // 文字列は URL 指定とみなす
            if (is_string($opt)) {
                $opt = [CURLOPT_URL => $opt];
            }
            // さらに URL 指定がないなら key を URL とみなす
            if (!isset($opt[CURLOPT_URL]) && !isset($opt['url'])) {
                $opt[CURLOPT_URL] = $key;
            }

            $rheader = null;
            $info = null;
            $res = http_request($default + $opt + $single_options, $rheader, $info);
            if (is_array($res) && isset($res[0]) && $handle_id = $stringify_curl($res[0])) {
                curl_multi_add_handle($mh, $res[0]);
                $resultmap[$handle_id] = [$key, $res[1], $res[2], microtime(true), 0];
            }
            else {
                $set_response($key, $res, $rheader, $info);
            }
        }

        do {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc === CURLM_CALL_MULTI_PERFORM);

            // see http://php.net/manual/ja/function.curl-multi-select.php#115381
            if (curl_multi_select($mh) === -1) {
                usleep(1); // @codeCoverageIgnore
            }

            do {
                if (($minfo = curl_multi_info_read($mh, $remains)) === false) {
                    continue;
                }

                $handle = $minfo['handle'];
                $handle_id = $stringify_curl($handle);
                [$key, $responser, $retry, $now, $retry_count] = $resultmap[$handle_id];

                $response = curl_multi_getcontent($handle);
                $info = curl_getinfo($handle);
                $info['errno'] = $minfo['result'];
                $info['retry'] = $retry_count;

                if ($time = $retry($info, $response)) {
                    // 同じリソースを使い回しても大丈夫っぽい？（大丈夫なわけないと思うが…動いてはいる）
                    curl_multi_remove_handle($mh, $handle);
                    curl_multi_add_handle($mh, $handle);

                    // 他のリクエストの待機で既に指定秒数を超えている場合は待たない（分岐は本来不要だが現在以下だと警告が出るため）
                    if (microtime(true) < ($next = $now + $time)) {
                        time_sleep_until($next);
                    }

                    $resultmap[$handle_id][3] = microtime(true);
                    $resultmap[$handle_id][4] = $retry_count + 1;

                    $active++;
                    continue;
                }

                if ($info['errno'] !== CURLE_OK) {
                    if ($multi_options['throw']) {
                        throw new \UnexpectedValueException("'{$info['url']}' curl_errno({$info['errno']}).");
                    }
                    $set_response($key, null, [], $info);
                }
                else {
                    $set_response($key, ...$responser($response, $info));
                }

                curl_multi_remove_handle($mh, $handle);
                curl_close($handle);
            } while ($remains);
        } while ($active && $mrc === CURLM_OK);
    }
    finally {
        curl_multi_close($mh);
    }

    return $responses;
}
