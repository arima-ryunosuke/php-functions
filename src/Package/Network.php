<?php

namespace ryunosuke\Functions\Package;

/**
 * ネットワーク関連のユーティリティ
 */
class Network
{
    /**
     * 接続元となる IP を返す
     *
     * 要するに自分の IP を返す。
     *
     * Example:
     * ```php
     * // 何らかの IP アドレスが返ってくる
     * assertRegExp('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#', getipaddress());
     * // 自分への接続元は自分なので 127.0.0.1 を返す
     * assertSame(getipaddress('127.0.0.9'), '127.0.0.1');
     * ```
     *
     * @param string $target 接続先。基本的に指定することはない
     * @return string IP アドレス
     */
    public static function getipaddress($target = '128.0.0.0')
    {
        $socket = stream_socket_client("udp://$target:7", $errno, $errstr);
        if ($socket === false) {
            throw new \InvalidArgumentException($errstr, $errno);
        }
        $sname = stream_socket_get_name($socket, false);
        $ipaddr = parse_url($sname, PHP_URL_HOST);

        fclose($socket);

        return $ipaddr;
    }

    /**
     * http リクエストを並列で投げる
     *
     * $urls で複数の curl を渡し、並列で実行して複数の結果をまとめて返す。
     * $urls の要素は単一の文字列か curl のオプションである必要がある。
     *
     * 返り値は $urls のキーを保持したまま、レスポンスが返ってきた順に格納して配列で返す。
     * 構造は下記のサンプルを参照。
     *
     * Example:
     * ```php
     * $responses = http_requests([
     *     // このように [キー => CURL オプション] 形式が正しい使い方
     *     'fuga' => [
     *         CURLOPT_URL     => 'http://unknown-host',
     *         CURLOPT_TIMEOUT => 5,
     *     ],
     *     // ただし、このように [キー => URL] 形式でもいい（オプションはデフォルトが使用される）
     *     'hoge' => 'http://127.0.0.1',
     * ]);
     * [
     *     // キーが維持されるので hoge キー
     *     'hoge' => [
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
     *     'fuga' => 6,
     * ];
     * ```
     *
     * @param array $urls 実行する curl オプション
     * @return array レスポンス配列。取得した順番でキーを保持しつつ追加される
     */
    public static function http_requests($urls)
    {
        // 固定オプション（必ずこの値が使用される）
        $default1 = [
            CURLOPT_RETURNTRANSFER => true, // 戻り値として返す
            CURLOPT_HEADER         => true, // ヘッダを含める
            CURLOPT_SAFE_UPLOAD    => true, // @付きフィールドをファイルと見なさない
        ];

        // 可変オプション（指定がない場合のみ使用される）
        $default2 = [
            CURLOPT_FOLLOWLOCATION => true, // リダイレクトをたどる
            CURLOPT_MAXREDIRS      => 16,   // リダイレクトをたどる回数
        ];

        $resultmap = [];
        $mh = curl_multi_init();
        foreach ($urls as $key => $opt) {
            // 文字列は URL 指定とみなす
            if (is_string($opt)) {
                $opt = [
                    CURLOPT_URL => $opt,
                ];
            }

            $ch = curl_init();
            curl_setopt_array($ch, $default1 + $opt + $default2);
            curl_multi_add_handle($mh, $ch);

            // スクリプトの実行中 (ウェブのリクエストや CLI プロセスの処理中) は、指定したリソースに対してこの文字列が一意に割り当てられることが保証されます
            $resultmap["$ch"] = $key;
        }

        $responses = [];
        do {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            // see http://php.net/manual/ja/function.curl-multi-select.php#115381
            if (curl_multi_select($mh) == -1) {
                usleep(1); // @codeCoverageIgnore
            }

            do {
                if (($minfo = curl_multi_info_read($mh, $remains)) === false) {
                    continue;
                }

                $handle = $minfo['handle'];

                if ($minfo['result'] !== CURLE_OK) {
                    $responses[$resultmap["$handle"]] = $minfo['result'];
                }
                else {
                    $info = curl_getinfo($handle);
                    $response = curl_multi_getcontent($handle);
                    $headers = [];
                    foreach (preg_split('#\R#', substr($response, 0, $info['header_size']), -1, PREG_SPLIT_NO_EMPTY) as $header) {
                        $parts = explode(':', $header, 2);
                        if (isset($parts[1])) {
                            $headers[trim($parts[0])] = trim($parts[1]);
                        }
                        else {
                            $headers[] = trim($parts[0]);
                        }
                    }
                    $body = substr($response, $info['header_size']);
                    $responses[$resultmap["$handle"]] = [$body, $headers, $info];
                }

                curl_multi_remove_handle($mh, $handle);
                curl_close($handle);
            } while ($remains);
        } while ($active && $mrc == CURLM_OK);

        curl_multi_close($mh);

        return $responses;
    }
}
