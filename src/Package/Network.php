<?php

namespace ryunosuke\Functions\Package;

/**
 * ネットワーク関連のユーティリティ
 */
class Network implements Interfaces\Network
{
    /**
     * cidr を分割する
     *
     * ※ 内部向け
     *
     * @param string $cidr
     * @return array [$address, $networkBit, $localBit]
     */
    public static function cidr_parse($cidr)
    {
        [$address, $subnet] = explode('/', trim($cidr), 2) + [1 => 32];

        if (!filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException("subnet addr '$address' is invalid.");
        }
        if (!(ctype_digit("$subnet") && (0 <= $subnet && $subnet <= 32))) {
            throw new \InvalidArgumentException("subnet mask '$subnet' is invalid.");
        }

        $subnet = (int) $subnet;
        return [$address, $subnet, 32 - $subnet];
    }

    /**
     * 接続元となる IP を返す
     *
     * IP を指定してそこへ接続する際の SourceIP を返す（省略すると最初のエントリを返す）。
     * 複数のネットワークにマッチした場合の結果は不定（最長が無難だろうがそもそも SourceIP がどうなるかが不定）。
     *
     * Example:
     * ```php
     * // 何らかの IP アドレスが返ってくる
     * that(getipaddress())->isValidIpv4();
     * // 自分への接続元は自分なので 127.0.0.1 を返す
     * that(getipaddress('127.0.0.9'))->isSame('127.0.0.1');
     * ```
     *
     * @param string|int|null $target 接続先
     * @return ?string IP アドレス
     */
    public static function getipaddress($target = null)
    {
        $net_get_interfaces = Utility::cache("net_get_interfaces", fn() => net_get_interfaces(), __FUNCTION__);

        // int, null 時は最初のエントリを返す（ループバックは除く）
        if ($target === null || is_int($target)) {
            $target ??= AF_INET;
            unset($net_get_interfaces['lo']);
            foreach ($net_get_interfaces as $interface) {
                foreach ($interface['unicast'] as $unicast) {
                    if ($unicast['family'] === $target) {
                        return $unicast['address'];
                    }
                }
            }
            return null;
        }

        if (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $family = AF_INET;
        }
        elseif (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $family = AF_INET6;
        }
        else {
            throw new \InvalidArgumentException("$target is invalid ip address");
        }

        $targetBytes = unpack('C*', inet_pton($target));

        foreach ($net_get_interfaces as $interface) {
            foreach ($interface['unicast'] as $unicast) {
                if ($unicast['family'] === $family) {
                    $addressBytes = unpack('C*', inet_pton($unicast['address']));
                    $netmaskBytes = unpack('C*', inet_pton($unicast['netmask']));
                    foreach ($netmaskBytes as $i => $netmaskByte) {
                        if (($addressBytes[$i] & $netmaskByte) !== ($targetBytes[$i] & $netmaskByte)) {
                            continue 2;
                        }
                    }
                    return $unicast['address'];
                }
            }
        }
        return null;
    }

    /**
     * IP アドレスを含みうる cidr を返す
     *
     * from, to の大小関係には言及しないので、from > to を与えると空配列を返す。
     *
     * ipv6 は今のところ未対応。
     *
     * Example:
     * ```php
     * that(ip2cidr('192.168.1.1', '192.168.2.64'))->isSame([
     *     '192.168.1.1/32',
     *     '192.168.1.2/31',
     *     '192.168.1.4/30',
     *     '192.168.1.8/29',
     *     '192.168.1.16/28',
     *     '192.168.1.32/27',
     *     '192.168.1.64/26',
     *     '192.168.1.128/25',
     *     '192.168.2.0/26',
     *     '192.168.2.64/32',
     * ]);
     * ```
     *
     * @param string $fromipaddr ipaddrs
     * @param string $toipaddr ipaddrs
     * @return array cidr
     */
    public static function ip2cidr($fromipaddr, $toipaddr)
    {
        if (!filter_var($fromipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException("ipaddr '$fromipaddr' is invalid.");
        }
        if (!filter_var($toipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException("ipaddr '$toipaddr' is invalid.");
        }
        $minlong = ip2long($fromipaddr);
        $maxlong = ip2long($toipaddr);

        $bit_length = fn($number) => strlen(ltrim(sprintf('%032b', $number), '0'));

        $result = [];
        for ($long = $minlong; $long <= $maxlong; $long += 1 << $nbits) {
            $current_bits = $bit_length(~$long & ($long - 1));
            $target_bits = $bit_length($maxlong - $long + 1) - 1;
            $nbits = min($current_bits, $target_bits);

            $result[] = long2ip($long) . '/' . (32 - $nbits);
        }
        return $result;
    }

    /**
     * cidr 内の IP アドレスを返す
     *
     * すべての IP アドレスを返すため、`/1` のような極端な値を投げてはならない。
     * （Generator の方がいいかもしれない）。
     *
     * ipv6 は今のところ未対応。
     *
     * Example:
     * ```php
     * that(cidr2ip('192.168.0.0/30'))->isSame(['192.168.0.0', '192.168.0.1', '192.168.0.2', '192.168.0.3']);
     * that(cidr2ip('192.168.0.255/30'))->isSame(['192.168.0.252', '192.168.0.253', '192.168.0.254', '192.168.0.255']);
     * ```
     *
     * @param string $cidr cidr
     * @return array IP アドレス
     */
    public static function cidr2ip($cidr)
    {
        [$prefix, , $mask] = Network::cidr_parse($cidr);

        $prefix = ip2long($prefix) >> $mask << $mask;

        $result = [];
        for ($i = 0, $l = 1 << $mask; $i < $l; $i++) {
            $result[] = long2ip($prefix + $i);
        }
        return $result;
    }

    /**
     * ipv4 の cidr チェック
     *
     * $ipaddr が $cidr のレンジ内なら true を返す。
     * $cidr は複数与えることができ、どれかに合致したら true を返す。
     *
     * ipv6 は今のところ未対応。
     *
     * Example:
     * ```php
     * // 範囲内なので true
     * that(incidr('192.168.1.1', '192.168.1.0/24'))->isTrue();
     * // 範囲外なので false
     * that(incidr('192.168.1.1', '192.168.2.0/24'))->isFalse();
     * // 1つでも範囲内なら true
     * that(incidr('192.168.1.1', ['192.168.1.0/24', '192.168.2.0/24']))->isTrue();
     * // 全部範囲外なら false
     * that(incidr('192.168.1.1', ['192.168.2.0/24', '192.168.3.0/24']))->isFalse();
     * ```
     *
     * @param string $ipaddr 調べられる IP/cidr アドレス
     * @param string|array $cidr 調べる cidr アドレス
     * @return bool $ipaddr が $cidr 内なら true
     */
    public static function incidr($ipaddr, $cidr)
    {
        [$ipaddr, , $ipmask] = Network::cidr_parse($ipaddr);

        $iplong = ip2long($ipaddr);

        foreach (Arrays::arrayize($cidr) as $cidr) {
            [$netaddress, , $netmask] = Network::cidr_parse($cidr);

            if ($ipmask > $netmask) {
                continue;
            }

            if ((ip2long($netaddress) >> $netmask) == ($iplong >> $netmask)) {
                return true;
            }
        }
        return false;
    }

    /**
     * ネットワーク疎通を返す
     *
     * $port を指定すると TCP/UDP、省略（null）すると ICMP で繋ぐ。
     * が、 ICMP は root ユーザしか実行できないので ping コマンドにフォールバックする。
     * TCP/UDP の分岐はマニュアル通り tcp://, udp:// のようなスキームで行う（スキームがなければ tcp）。
     *
     * udp は結果が不安定なので信頼しないこと（タイムアウトも疎通 OK とみなされる。プロトコルの仕様上どうしようもない）。
     *
     * Example:
     * ```php
     * // 自身へ ICMP ping を打つ（正常終了なら float を返し、失敗なら false を返す）
     * that(ping('127.0.0.1'))->isFloat();
     * // 自身の tcp:1234 が開いているか（開いていれば float を返し、開いていなければ false を返す）
     * that(ping('tcp://127.0.0.1', 1234))->isFalse();
     * that(ping('127.0.0.1', 1234))->isFalse(); // tcp はスキームを省略できる
     * ```
     *
     * @param string $host ホスト名（プロトコルも指定できる）
     * @param int|null $port ポート番号。指定しないと ICMP になる
     * @param int $timeout タイムアウト秒
     * @param string $errstr エラー文字列が格納される
     * @return float|bool 成功したときは疎通時間。失敗したときは false
     */
    public static function ping($host, $port = null, $timeout = 1, &$errstr = '')
    {
        $errstr = '';

        $parts = parse_url($host);
        if (!isset($parts['scheme'])) {
            if ($port === null) {
                $parts['scheme'] = 'icmp';
            }
            else {
                $parts['scheme'] = 'tcp';
            }
        }
        $protocol = strtolower($parts['scheme']);
        $host = $parts['host'] ?? $parts['path'];

        // icmp で linux かつ非 root は SOCK_RAW が使えないので ping コマンドへフォールバック
        if ($protocol === 'icmp' && DIRECTORY_SEPARATOR === '/' && !is_readable('/root')) {
            // @codeCoverageIgnoreStart
            $stdout = null;
            Utility::process('ping', [
                '-c' => 1,
                '-W' => (int) $timeout,
                $host,
            ], null, $stdout, $errstr);
            // min/avg/max/mdev = 0.026/0.026/0.026/0.000
            if (preg_match('#min/avg/max/mdev.*?[0-9.]+/([0-9.]+)/[0-9.]+/[0-9.]+#', $stdout, $m)) {
                return $m[1] / 1000.0;
            }
            return false;
            // @codeCoverageIgnoreEnd
        }

        if ($protocol === 'icmp') {
            $port = 0;
            $socket = socket_create(AF_INET, SOCK_RAW, getprotobyname($protocol));
        }
        elseif ($protocol === 'tcp') {
            $socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname($protocol));
        }
        elseif ($protocol === 'udp') {
            $socket = socket_create(AF_INET, SOCK_DGRAM, getprotobyname($protocol));
        }
        else {
            throw new \InvalidArgumentException("'$protocol' is not supported.");
        }

        $mtime = microtime(true);
        try {
            Funchand::call_safely(function ($socket, $protocol, $host, $port, $timeout) {
                socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $timeout, 'usec' => 0]);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]);
                if (!socket_connect($socket, $host, $port)) {
                    throw new \RuntimeException(); // @codeCoverageIgnore
                }

                // icmp は ping メッセージを送信
                if ($protocol === 'icmp') {
                    $message = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
                    socket_send($socket, $message, strlen($message), 0);
                    socket_read($socket, 255);
                }
                // tcp は接続自体ができれば OK
                if ($protocol === 'tcp') {
                    assert(true); // PhpStatementHasEmptyBodyInspection
                }
                // udp は何か送ってみてその挙動で判断（=> catch 節）
                if ($protocol === 'udp') {
                    $message = ""; // noop
                    socket_send($socket, $message, strlen($message), 0);
                    socket_read($socket, 255);
                }
            }, $socket, $protocol, $host, $port, $timeout);
            return microtime(true) - $mtime;
        }
        catch (\Throwable $t) {
            $errno = socket_last_error($socket);
            // windows では到達できても socket_read がエラーを返すので errno で判断
            // 接続済みの呼び出し先が一定の時間を過ぎても正しく応答しなかったため、接続できませんでした。
            // または接続済みのホストが応答しなかったため、確立された接続は失敗しました。
            if (DIRECTORY_SEPARATOR === '\\' && $errno === 10060 && $protocol === 'udp') {
                return microtime(true) - $mtime;
            }
            $errstr = socket_strerror($errno);
            return false;
        }
        finally {
            socket_close($socket);
        }
    }

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
     * @param array $urls 実行する curl オプション
     * @param array $single_options 全 $urls に適用されるデフォルトオプション
     * @param array $multi_options 並列リクエストとしてのオプション
     * @param array $infos curl 情報やヘッダなどが格納される受け変数
     * @return array レスポンスボディ配列。取得した順番でキーを保持しつつ追加される
     */
    public static function http_requests($urls, $single_options = [], $multi_options = [], &$infos = [])
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
            if (is_resource($curl)) {
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
                $res = Network::http_request($default + $opt + $single_options, $rheader, $info);
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

    /**
     * curl のラッパー関数
     *
     * curl は高機能だけど、低レベルで設定が細かすぎる上に似たようなものが大量にあるので素で書くのが割とつらい。
     * のでデフォルトをスタンダードな設定に寄せつつ、多少便利になるようにラップしている。
     * まぁ現在では guzzle みたいなクライアントも整ってるし、使い捨てスクリプトでサクッとリクエストを投げたい時用。
     *
     * 生 curl との差異は下記。
     *
     * - `CURLOPT_HTTPHEADER` は連想配列指定が可能
     * - `CURLOPT_POSTFIELDS` は連想配列・多次元配列指定が可能
     * - 単一ファイル指定は単一アップロードになる
     *
     * さらに独自のオプションとして下記がある。
     *
     * - `raw` (bool): curl インスタンスと変換クロージャを返すだけになる
     *     - ただし、ほぼデバッグや内部用なので指定することはほぼ無いはず
     * - `nobody` (bool): ヘッダーの受信が完了したらただちに処理を返す
     *     - ボディは空文字になる（CURLOPT_NOBODY とは全く性質が異なるので注意）
     * - `throw` (bool): ステータスコードが 400 以上のときに例外を投げる
     *     - `CURLOPT_FAILONERROR` は原則使わないほうがいいと思う
     * - `retry` (float[]|callable): エラーが出た場合にリトライする
     *     - 配列で指定した回数・秒数のリトライを行う（[1, 2, 3] で、1秒後、2秒後、3秒後になる）
     *     - callable を指定するとその callable が false を返すまでリトライする（引数として curl_info が渡ってきて待機秒数を返す）
     * - `atfile` (bool): キーに @ があるフィールドをファイルアップロードとみなす
     *     - 悪しき `CURLOPT_SAFE_UPLOAD` の代替。ただし値ではなくキーで判別する
     *     - 値が配列のフィールドのキーに @ をつけると連番要素のみアップロードになる
     * - `cachedir` (string): GET のときにクライアントキャッシュや 304 キャッシュが効くようになる
     *     - Cache-Control の private, public は見ないので一応注意
     * - `parser` (array): Content-Type に基づいて body をパースする
     *     - 今のところ application/json のみ
     *
     * また、頻出するオプションは下記の定数のエイリアスがあり、単純に読み替えられる。
     *
     * - `url`: `CURLOPT_URL`
     * - `method`: `CURLOPT_CUSTOMREQUEST`
     * - `cookie`: `CURLOPT_COOKIE`
     * - `header`: `CURLOPT_HTTPHEADER`
     * - `body`: `CURLOPT_POSTFIELDS`
     * - `cookie_file`: `CURLOPT_COOKIEJAR`, `CURLOPT_COOKIEFILE`
     *
     * Example:
     * ```php
     * $response = http_request([
     *     'url'    => 'http://httpbin.org/post?name=value',
     *     'method' => 'POST',
     *     'body'   => ['k1' => 'v1', 'k2' => 'v2'],
     * ]);
     * that($response['args'])->is([
     *     'name' => 'value',
     * ]);
     * that($response['form'])->is([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     * ]);
     * ```
     *
     * @param array $options curl_setopt_array に渡される
     * @param array $response_header レスポンスヘッダが連想配列で格納される
     * @param array $info curl_getinfo が格納される
     * @return mixed レスポンスボディ
     */
    public static function http_request($options = [], &$response_header = [], &$info = [])
    {
        $options += [
            // curl options
            CURLOPT_CUSTOMREQUEST  => 'GET', // リクエストメソッド
            CURLINFO_HEADER_OUT    => true,  // リクエストヘッダを含める
            CURLOPT_HTTPHEADER     => [],    // リクエストヘッダ
            CURLOPT_COOKIE         => null,  // リクエストクッキー
            CURLOPT_POSTFIELDS     => null,  // リクエストボディ
            CURLOPT_NOBODY         => false, // HEAD 用
            CURLOPT_ENCODING       => "",    // Accept-Encoding 兼自動展開
            CURLOPT_FOLLOWLOCATION => true,  // リダイレクトをたどる
            CURLOPT_MAXREDIRS      => 16,    // リダイレクトをたどる回数
            CURLOPT_RETURNTRANSFER => true,  // 戻り値として返す
            CURLOPT_HEADER         => true,  // レスポンスヘッダを含める
            CURLOPT_CONNECTTIMEOUT => 60,    // timeout on connect
            CURLOPT_TIMEOUT        => 60,    // timeout on response

            // alias option
            'url'                  => null,
            'method'               => null,
            'cookie'               => null,
            'header'               => null,
            'body'                 => null,
            'cookie_file'          => null,

            // custom options
            'raw'                  => false,
            'nobody'               => false,
            'throw'                => true,
            'retry'                => [],
            'atfile'               => true,
            'cachedir'             => null,
            'parser'               => [
                'application/json' => [
                    'request'  => fn($contents) => Strings::json_export($contents),
                    'response' => fn($contents) => Strings::json_import($contents),
                ],
            ],
        ];

        // 利便性用の定数エイリアス
        $options[CURLOPT_URL] = $options['url'] ?? $options[CURLOPT_URL];
        $options[CURLOPT_CUSTOMREQUEST] = $options['method'] ?? $options[CURLOPT_CUSTOMREQUEST];
        $options[CURLOPT_COOKIE] = $options['cookie'] ?? $options[CURLOPT_COOKIE];
        $options[CURLOPT_HTTPHEADER] = $options['header'] ?? $options[CURLOPT_HTTPHEADER];
        $options[CURLOPT_POSTFIELDS] = $options['body'] ?? $options[CURLOPT_POSTFIELDS];
        if (isset($options['cookie_file'])) {
            $options[CURLOPT_COOKIEJAR] = $options['cookie_file'];
            $options[CURLOPT_COOKIEFILE] = $options['cookie_file'];
        }
        if ($options['nobody']) {
            $headers = '';
            $options[CURLOPT_HEADERFUNCTION] = function ($curl, $header) use (&$headers) {
                if (trim($header) === '') {
                    return -1;
                }
                $headers .= $header;
                return strlen($header);
            };
        }

        // ヘッダは後段の判定に頻出するので正規化して取得しておく
        $request_header = Arrays::array_kvmap($options[CURLOPT_HTTPHEADER], function ($k, $v) {
            if (is_int($k)) {
                [$k, $v] = explode(':', $v, 2);
            }
            return [strtolower(trim($k)) => trim($v)];
        });

        // request body 変換
        $content_type = Strings::split_noempty(';', $request_header['content-type'] ?? '');
        if ($convert = ($options['parser'][strtolower($content_type[0] ?? '')]['request'] ?? null)) {
            $options[CURLOPT_POSTFIELDS] = $convert($options[CURLOPT_POSTFIELDS], ...$content_type);
        }

        // response クロージャ
        $response_parse = function ($response, $info) use ($options) {
            [$head, $body] = Strings::str_chunk($response, $info['header_size']);

            $head = Strings::str_array($head, ':', true);
            $info['no_request'] = false;
            $info['response_size'] = strlen($response);
            $info['content_type'] = $info['content_type'] ?? null;
            $info['cache_control'] = $head['Cache-Control'] ?? null;
            $info['last_modified'] = $head['Last-Modified'] ?? null;
            $info['etag'] = $head['ETag'] ?? null;
            if (isset($info['request_header']) && is_string($info['request_header'])) {
                $info['request_header'] = Strings::str_array($info['request_header'], ':', true);
            }

            if (!($options[CURLOPT_NOBODY] ?? false) && !$options['nobody']) {
                $content_type = Strings::split_noempty(';', $info['content_type'] ?? '');
                if ($convert = ($options['parser'][strtolower($content_type[0] ?? '')]['response'] ?? null)) {
                    $body = $convert($body, ...$content_type);
                }
            }

            return [$info, $head, $body];
        };

        // キャッシュのキー
        $filekey = null;
        if ($options[CURLOPT_CUSTOMREQUEST] === 'GET' && isset($options['cachedir'])) {
            [$url, $query] = explode('?', $options[CURLOPT_URL]) + [1 => ''];
            $filekey = $options['cachedir'] . DIRECTORY_SEPARATOR . urlencode($url) . sha1($query);
        }

        // http cache
        if (isset($filekey)) {
            if (file_exists($filekey)) {
                $fp = fopen($filekey, 'r');
                try {
                    $info = json_decode(fgets($fp), true);
                    if (stripos($info['cache_control'] ?? '', 'no-cache') === false && preg_match('#max-age=(\\d+)#i', $info['cache_control'] ?? '', $matches)) {
                        clearstatcache(true, $filekey);
                        if (time() - filemtime($filekey) < $matches[1]) {
                            $info['no_request'] = true;
                            $response = stream_get_contents($fp);
                            [, $response_header, $body] = $response_parse($response, $info);
                            return $body;
                        }
                    }

                    if ($info['last_modified']) {
                        $options[CURLOPT_HTTPHEADER]['if-modified-since'] = $info['last_modified'];
                    }
                    if ($info['etag']) {
                        $options[CURLOPT_HTTPHEADER]['if-none-match'] = $info['etag'];
                    }
                }
                finally {
                    fclose($fp);
                }
            }
        }

        // http cache クロージャ
        $cache = function ($response, $info) use ($filekey, $response_parse) {
            if (isset($filekey)) {
                if ($info['http_code'] === 200 && stripos($info['cache_control'] ?? '', 'no-store') === false) {
                    FileSystem::file_set_contents($filekey, json_encode($info, JSON_UNESCAPED_SLASHES) . "\n" . $response);
                }
                if ($info['http_code'] === 304 && file_exists($filekey)) {
                    touch($filekey);
                    [$info2, $response] = explode("\n", file_get_contents($filekey), 2);
                    return $response_parse($response, json_decode($info2, true))[2];
                }
            }
        };

        // CURLOPT_POSTFIELDS は配列を渡せば万事 OK ・・・と思いきや多次元には対応していないのでフラットにする
        if (is_array($options[CURLOPT_POSTFIELDS])) {
            // の、前に @ 付きキーを CURLFile に変換
            if ($options['atfile']) {
                $options[CURLOPT_POSTFIELDS] = Arrays::array_kvmap($options[CURLOPT_POSTFIELDS], function ($k, $v, $callback) {
                    $atfile = ($k[0] ?? null) === '@';
                    if ($atfile) {
                        $k = substr($k, 1);
                        if (is_array($v)) {
                            $v = Arrays::array_kvmap($v, fn($k, $v) => [is_int($k) ? "@$k" : $k => $v]);
                        }
                        else {
                            $v = new \CURLFile($v);
                        }
                    }
                    if (is_array($v)) {
                        $v = Arrays::array_kvmap($v, $callback);
                    }
                    return [$k => $v];
                });
            }
            // CURLFile が含まれているかもしれないので http_build_query は使えない
            $options[CURLOPT_POSTFIELDS] = Arrays::array_flatten($options[CURLOPT_POSTFIELDS], fn($keys) => array_shift($keys) . ($keys ? '[' . implode('][', $keys) . ']' : ''));
        }

        // 単一ファイルは単一アップロードとする
        if ($options[CURLOPT_POSTFIELDS] instanceof \CURLFile) {
            $file = $options[CURLOPT_POSTFIELDS];
            unset($options[CURLOPT_POSTFIELDS]);
            if (!isset($request_header['content-type'])) {
                $options[CURLOPT_HTTPHEADER]['content-type'] = $file->getMimeType() ?: mime_content_type($file->getFilename());
            }
            $options[CURLOPT_INFILE] = fopen($file->getFilename(), 'r');
            $options[CURLOPT_INFILESIZE] = filesize($file->getFilename());
            $options[CURLOPT_PUT] = true;
        }

        // CURLOPT_HTTPHEADER は素の配列しか受け入れてくれないので連想配列を k: v 形式に変換
        $options[CURLOPT_HTTPHEADER] = Arrays::array_sprintf($options[CURLOPT_HTTPHEADER], fn($v, $k) => is_int($k) ? $v : "$k: $v");

        // 同上： CURLOPT_COOKIE
        if ($options[CURLOPT_COOKIE] && is_array($options[CURLOPT_COOKIE])) {
            $options[CURLOPT_COOKIE] = Arrays::array_sprintf($options[CURLOPT_COOKIE], fn($v, $k) => is_int($k) ? $v : rawurlencode($k) . "=" . rawurlencode($v), '; ');
        }

        assert(is_callable($options['retry']) || is_array($options['retry']));
        $retry = is_callable($options['retry']) ? $options['retry'] : function ($info) use ($options) {
            // リトライを費やしたなら打ち切り
            $time = $options['retry'][$info['retry']] ?? null;
            if ($time === null) {
                return false;
            }
            // curl レイヤでは一部の curl_errno のみ
            if (in_array($info['errno'], [CURLE_OPERATION_TIMEOUTED, CURLE_GOT_NOTHING, CURLE_SEND_ERROR, CURLE_RECV_ERROR])) {
                return $time;
            }
            // 結果が返ってきてるなら打ち切り…としたいところだが、一部のコードはリトライ対象とする。ちょっと思うところがあるのでメモを下記に記す
            // 429 は微妙。いわゆるレート制限が多いだろうので、リトライしてもどうせコケる
            // 502 はもっと微妙。でも「たまたま具合の悪い ap サーバに到達してしまった」ならリトライの価値はある
            // 503 は本来あるべきリトライだろうけど、過負荷でリトライしても…という思いもある
            if ($info['errno'] === CURLE_OK && in_array($info['http_code'], [429, 502, 503])) {
                return $time;
            }

            return false;
        };

        $responser = function ($response, $info) use ($response_parse, $cache) {
            [$info, $head, $body] = $response_parse($response, $info);
            return [$cache($response, $info) ?? $body, $head, $info];
        };

        $ch = curl_init();
        curl_setopt_array($ch, array_filter($options, 'is_int', ARRAY_FILTER_USE_KEY));
        if ($options['raw']) {
            return [$ch, $responser, $retry];
        }

        try {
            $retry_count = 0;
            do {
                $headers = '';
                $response = curl_exec($ch);
                if ($options['nobody']) {
                    $response = $headers;
                }
                $info = curl_getinfo($ch);
                $info['retry'] = $retry_count++;
                $info['errno'] = curl_errno($ch);
                $time = $retry($info, $response);
                usleep($time * 1000 * 1000);
            } while ($time);

            if (!($info['errno'] === CURLE_OK || ($options['nobody'] && $info['errno'] === CURLE_WRITE_ERROR))) {
                throw new \RuntimeException(curl_error($ch), curl_errno($ch));
            }
        }
        finally {
            curl_close($ch);
        }

        if ($options['throw'] && $info['http_code'] >= 400) {
            throw new \UnexpectedValueException("status is {$info['http_code']}.");
        }

        [$body, $response_header, $info] = $responser($response, $info);
        return $body;
    }

    /**
     * {@link http_request() http_request} の HEAD 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return array レスポンスヘッダ
     */
    public static function http_head($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'method'       => 'HEAD',
            CURLOPT_NOBODY => true,
        ];
        Network::http_get($url, $data, $options + $default, $response_header, $info);
        return $response_header;
    }

    /**
     * {@link http_request() http_request} の GET 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    public static function http_get($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        if (!Vars::is_empty($data, true)) {
            $url .= (strrpos($url, '?') === false ? '?' : '&') . (is_array($data) || is_object($data) ? http_build_query($data) : $data);
        }
        $default = [
            'url'    => $url,
            'method' => 'GET',
        ];
        return Network::http_request($options + $default, $response_header, $info);
    }

    /**
     * {@link http_request() http_request} の POST 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    public static function http_post($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'POST',
            'body'   => $data,
        ];
        return Network::http_request($options + $default, $response_header, $info);
    }

    /**
     * {@link http_request() http_request} の PUT 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    public static function http_put($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'PUT',
            'body'   => $data,
        ];
        return Network::http_request($options + $default, $response_header, $info);
    }

    /**
     * {@link http_request() http_request} の PATCH 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    public static function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'PATCH',
            'body'   => $data,
        ];
        return Network::http_request($options + $default, $response_header, $info);
    }

    /**
     * {@link http_request() http_request} の DELETE 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    public static function http_delete($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'DELETE',
            'body'   => $data,
        ];
        return Network::http_request($options + $default, $response_header, $info);
    }
}
