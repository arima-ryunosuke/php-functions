<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_requests.php';
require_once __DIR__ . '/../strings/str_resource.php';
require_once __DIR__ . '/../utility/cacheobject.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * ipv4 の情報を返す
 *
 * 登録機関とか登録日、国等を返すが、実際のところ cc（国）くらいしか使わないはず。
 * データソースは各 RIR の delegated-afrinic-latest だが、かなりでかいのでデフォルトでは24時間のキャッシュが効く。
 * キャッシュ切れ/効かせないと最悪30秒くらいかかるので注意（バッチで叩くといいと思う）。
 *
 * $ipaddr に null を渡すと全 ip 情報を返す。
 * 上記の通り、情報としてかなりでかいので php で処理するのではなく、全取得して RDBMS に登録したり htaccess に書き込んだりするのに使える。
 *
 * ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * // apnic 管轄
 * that(ip_info(gethostbyname('www.nic.ad.jp'), ['timeout' => 300, 'throw' => false]))->is([
 *     'cidr'      => '192.41.192.0/24',
 *     'ipaddress' => '192.41.192.0',
 *     'netmask'   => 24,
 *     'registry'  => 'apnic',
 *     'cc'        => 'JP',
 *     'date'      => '19880620',
 * ]);
 * // arin 管轄
 * that(ip_info(gethostbyname('www.internic.net'), ['timeout' => 300, 'throw' => false]))->is([
 *     'cidr'      => '192.0.32.0/20',
 *     'ipaddress' => '192.0.32.0',
 *     'netmask'   => 20,
 *     'registry'  => 'arin',
 *     'cc'        => 'US',
 *     'date'      => '20090629',
 * ]);
 * // こういう特殊なアドレスも一応対応している（全てではない）
 * that(ip_info('127.0.0.1'))['registry']->is('RFC1122');
 * that(ip_info('192.168.0.1'))['registry']->is('RFC1918');
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 *
 * @param string $ipaddr 調べる IP アドレス
 * @param array $options オプション配列
 * @return null|array|iterable IP の情報。ヒットしない場合は null
 */
function ip_info($ipaddr, $options = [])
{
    if ($ipaddr === null) {
        $ipv = 0;
    }
    elseif (filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $ipv = 4;
    }
    elseif (filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $ipv = 6; // @codeCoverageIgnore
    }

    if (!isset($ipv)) {
        throw new \InvalidArgumentException("\$ipaddr($ipaddr) is invalid");
    }
    if ($ipv === 6) {
        throw new \InvalidArgumentException("IPV6($ipaddr) is not supported");
    }

    $options += [
        'readonly' => false, // for compatible. 接続や更新を行わずに今あるデータだけで返すか（通常は true, 裏で更新するときに false にするとよい）
        'cachedir' => function_configure('storagedir') . '/' . rawurlencode(__FUNCTION__),
        'ttl'      => 60 * 60 * 24 + 120, // 120 は1日1回バッチで叩くことを前提としたバッファ
        'cache'    => true, // false を指定すると ttl が 0 扱いになり、内部キャッシュもクリアされる
        'rir'      => [],
        'timeout'  => 180,
        'generate' => false, // for compatible. true を指定するとジェネレータで返す（将来的に削除か true がデフォルトになる）
        'throw'    => true, // テスト用で原則 true（例外が飛ばないと情報が膨大過ぎるので失敗しても気付けない）
    ];
    $options['rir'] += [
        'afrinic' => 'https://ftp.afrinic.net/pub/stats/afrinic/delegated-afrinic-extended-latest',
        'apnic'   => 'https://ftp.apnic.net/pub/stats/apnic/delegated-apnic-extended-latest',
        'arin'    => 'https://ftp.arin.net/pub/stats/arin/delegated-arin-extended-latest',
        'lacnic'  => 'https://ftp.lacnic.net/pub/stats/lacnic/delegated-lacnic-extended-latest',
        'ripe'    => 'https://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-extended-latest',
    ];

    if (!is_dir($options['cachedir'])) {
        @mkdir($options['cachedir'], 0777, true);
    }

    $client = new class($options) {
        private \PDO $pdo;

        public function __construct(private array $options) { }

        public function register()
        {
            $pdo = $this->pdo();

            $meta = $pdo->query("SELECT registry, expire FROM rir_meta")->fetchAll(\PDO::FETCH_ASSOC | \PDO::FETCH_UNIQUE);

            // RFC アドレス
            if (($meta['reserved']['expire'] ?? 0) < time()) {
                $this->transaction(function () {
                    // reserved は options.ttl は見ず多少長めで良い
                    $this->refresh('reserved', 60 * 60 * 24 * 7, (function () {
                        foreach ([
                            ['RFC1700', '0.0.0.0', 8],         // wildcard
                            ['RFC919', '255.255.255.255', 32], // broadcast
                            ['RFC5771', '224.0.0.0', 4],       // multicast
                            ['RFC1122', '127.0.0.0', 8],       // loopback
                            ['RFC3927', '169.254.0.0', 16],    // link-local
                            ['RFC1918', '10.0.0.0', 8],        // private
                            ['RFC1918', '172.16.0.0', 12],     // private
                            ['RFC1918', '192.168.0.0', 16],    // private
                        ] as [$name, $ip, $mask]) {
                            yield [
                                'ipaddress' => $ip,
                                'netmask'   => $mask,
                                'registry'  => $name,
                                'cc'        => null,
                                'date'      => null,
                            ];
                        }
                    })());
                });
            }

            // RIR アドレス
            if ($urls = array_filter($this->options['rir'], fn($registry) => ($meta[$registry]['expire'] ?? 0) < time(), ARRAY_FILTER_USE_KEY)) {
                $responses = http_requests($urls, [
                    'cachedir'             => $this->options['cachedir'],
                    CURLOPT_CONNECTTIMEOUT => $this->options['timeout'],
                    CURLOPT_TIMEOUT        => $this->options['timeout'],
                ], [
                    'throw' => $this->options['throw'],
                ], $infos);
                foreach ($responses as $registry => $response) {
                    if ($response === null || $infos[$registry][1]['http_code'] >= 400) {
                        $this->transaction(function () use ($registry) {
                            // 失敗状態なので少し短めにする
                            $this->refresh($registry, (int) ($this->options['ttl'] / 2), []);
                        });
                        $message = sprintf("request %s failed. caused by %s(error [%s] %s)",
                            $infos[$registry][1]['url'],
                            $infos[$registry][1]['http_code'],
                            $infos[$registry][1]['errno'],
                            curl_strerror($infos[$registry][1]['errno']),
                        );
                        if ($this->options['throw']) {
                            throw new \UnexpectedValueException($message);
                        }
                        trigger_error($message, E_USER_WARNING);
                    }

                    $fp = str_resource($response);

                    $this->transaction(function () use ($fp, $registry) {
                        // 同時に走らないように rand でバラす
                        $this->refresh($registry, time() + $this->options['ttl'] + rand(0, 60), (function () use ($fp) {
                            while (($fields = fgetcsv($fp, 0, "|")) !== false) {
                                if (($fields[2] ?? '') === 'ipv4' && in_array($fields[6] ?? '', ['assigned', 'allocated'], true)) {
                                    foreach ($this->cidr($fields[3], $fields[4]) as $cidr) {
                                        yield [
                                            'ipaddress' => $cidr[0],
                                            'netmask'   => $cidr[1],
                                            'registry'  => $fields[0],
                                            'cc'        => $fields[1],
                                            'date'      => $fields[5],
                                        ];
                                    }
                                }
                            }
                        })());
                    });
                }
            }
        }

        public function generate(): iterable
        {
            $pdo = $this->pdo();
            $stmt = $pdo->query('SELECT ipaddress || "/" || netmask AS cidr, * FROM rir_data', \PDO::FETCH_ASSOC);
            foreach ($stmt as $row) {
                $row['netmask'] = (int) $row['netmask'];
                yield $row;
            }
        }

        public function query(string $ipaddr): ?array
        {
            $pdo = $this->pdo();
            $stmt = $pdo->prepare('SELECT ipaddress || "/" || netmask AS cidr, * FROM rir_data WHERE ipaddress = :ipaddress AND netmask = :netmask');
            for ($i = 32; $i > 0; $i--) {
                $subnet = (32 - $i);
                $ip = ip2long($ipaddr);
                $ip = $ip >> $subnet;
                $ip = $ip << $subnet;
                $ip = long2ip($ip);

                $stmt->execute([
                    'ipaddress' => $ip,
                    'netmask'   => $i,
                ]);
                $infos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($infos as $info) {
                    $info['netmask'] = (int) $info['netmask'];
                    return $info;
                }
            }
            return null;
        }

        private function pdo(): \PDO
        {
            return $this->pdo ??= (function () {
                $sqlfile = "{$this->options['cachedir']}/ip_infov001.sqlite";
                if (!$this->options['cache']) {
                    @unlink($sqlfile);
                }

                // PDO(sqlite)取得
                $initial = !file_exists($sqlfile);
                $pdo = new \PDO("sqlite:$sqlfile", null, null, [
                    \PDO::ATTR_ERRMODE           => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_EMULATE_PREPARES  => false,
                ]);
                if ($initial) {
                    $pdo->exec(<<<SQL
                        CREATE TABLE IF NOT EXISTS rir_meta(
                            registry VARCHAR(32) NOT NULL,
                            expire   INT         NOT NULL,
                            PRIMARY KEY (registry)
                        )
                        SQL,
                    );
                    $pdo->exec(<<<SQL
                        CREATE TABLE IF NOT EXISTS rir_data(
                            ipaddress VARCHAR(16) NOT NULL,
                            netmask   INT         NOT NULL,
                            registry  VARCHAR(32) NOT NULL,
                            cc        VARCHAR(16),
                            date      VARCHAR(8),
                            PRIMARY KEY (ipaddress, netmask)
                        )
                        SQL,
                    );
                }
                return $pdo;
            })();
        }

        private function transaction(callable $callback)
        {
            $pdo = $this->pdo();
            $pdo->beginTransaction();
            // @codeCoverageIgnoreStart かなりしんどいので ignore
            try {
                $return = $callback($pdo);
                $pdo->commit();
                return $return;
            }
            catch (\Exception $e) {
                $pdo->rollBack();
                throw $e;
                // @codeCoverageIgnoreEnd
            }
        }

        private function refresh(string $registry, int $expire, iterable $data)
        {
            $pdo = $this->pdo();
            $pdo->prepare('REPLACE INTO rir_meta VALUES (:registry, :expire)')->execute([
                'registry' => $registry,
                'expire'   => $expire,
            ]);
            if ($data) {
                $pdo->prepare('DELETE FROM rir_data WHERE registry = :registry')->execute([
                    'registry' => $registry,
                ]);
                foreach ($data as $values) {
                    $pdo->prepare('REPLACE INTO rir_data VALUES (:ipaddress, :netmask, :registry, :cc, :date)')->execute($values);
                }
            }
        }

        private function cidr(string $ipaddr, int $count): iterable
        {
            $main = function (int $longip, int $count) use (&$main) {
                if ($count > 0) {
                    for ($bit = (int) ceil(log($count, 2)); $bit > 1; $bit--) {
                        $bitcount = (int) pow(2, $bit);
                        if (($longip & $bitcount - 1) === 0 && $count >= $bitcount) {
                            yield [long2ip($longip), (32 - $bit)];
                            yield from $main($longip + $bitcount, $count - $bitcount);
                            break;
                        }
                    }
                }
            };
            yield from $main(ip2long($ipaddr), $count);
        }
    };

    if (!$options['readonly']) {
        $client->register();
    }

    if ($ipaddr === null) {
        $generator = $client->generate();
        if ($options['generate']) {
            return $generator;
        }
        return [...$generator];
    }

    $cacheobject = cacheobject(__FUNCTION__, 0.01, 1.0);

    if (!$options['cache']) {
        $cacheobject->delete($ipaddr);
    }

    if (!$cacheobject->has($ipaddr)) {
        $cacheobject->set($ipaddr, $client->query($ipaddr), $options['ttl']);
    }

    return $cacheobject->get($ipaddr);
}
