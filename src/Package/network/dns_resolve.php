<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_aggregate.php';
require_once __DIR__ . '/../filesystem/file_set_contents.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * TTL 対応の DNS リゾルバ
 *
 * server を指定して自ら UDP で問い合わせたりするような機能はない（将来的にはやってもいいけど）。
 * リゾルバとしては OS に設定されているネームサーバが使われる（php で言えば dns_get_record）。
 *
 * hosts ファイルに記載されているレコードは ttl が 0 になるが、 $ttl0 で明示指定できる。
 * $nxdomainTtl もほぼ hosts 用の引数（SOA がないドメインなんてほぼ存在しない）。
 *
 * 結果はローカルファイルシステムに保存されるので TTL が切れるまでは別プロセスでも同じ結果を返す。
 * ネガティブキャッシュも実装されており TTL は SOA の minimum-ttl に従う。
 *
 * $returnAs で返り値の形式を指定できる。
 * - 'raw': ほぼ生のまま返す（「ほぼ」というのは type ごとにカテゴライズされるため）
 * - 'values': 主たる値を配列で返す（「主たる」とは A だったら IP, MX だったら優先度ソート済みの target）
 * - 'value': 主たる値をスカラーで返す（「主たる」とは A だったらランダムの IP, MX だったら高優先度 target）
 *
 * いずれにせよ DNS_XXX に複数の値を含めると複数の値を返し得るので注意。
 * （根本的に raw+ALL 以外の複数値指定は推奨しない）。
 *
 * 普通は 'value' で十分で、MX で別レコードにリトライしたい場合くらいにしか 'values' は使用しない。
 * 'raw' に至ってはほぼデバック・確認用で通常用途での使用はほぼないはず。
 *
 * Example:
 * ```php
 * // example.com A の主たる値をスカラーで返す
 * that(dns_resolve('example.com', DNS_A, 'value'))->isString(); // '96.7.128.175' 等（毎回異なる）
 * // example.com A の主たる値を配列で返す
 * that(dns_resolve('example.com', DNS_A, 'values'))->isArray(); // ['23.192.228.80'] 等（順番は毎回異なる）
 * // example.com 全レコードをカテゴライズして返す
 * that(dns_resolve('example.com', DNS_ALL, 'raw'))->hasKeyAll(['A', 'AAAA', 'SOA']); // var_dump してみれば一発で分かる
 * ```
 *
 * @package ryunosuke\Functions\Package\network
 */
function dns_resolve(
    /** 取得するドメイン名 */ string $hostname,
    /** 取得するレコードタイプ */ int $type = DNS_A,
    /** 返り値のタイプ */ string $returnAs = 'value', // 'raw' | 'values' | 'value'
    /** TTL が 0（hosts 等）の場合の代替値 */ int $ttl0 = 0,
    /** SOA がない場合（hosts 等）のネガティブキャッシュの TTL */ int $nxdomainTtl = 60,
    /** フラッシュフラグ */ bool $flush = false,
    /** 注入用 hosts ファイルだが実質的にテスト用 */ array $hosts = [],
) {
    $client = new class(function_configure('storagedir') . '/dns_resolve/', $ttl0, $nxdomainTtl, $hosts) {
        private static array $rules;
        private static array $cache    = [];
        private static array $original = [];

        public function __construct(private string $storage, private int $ttl0, private int $nxdomainTtl, private array $hosts)
        {
            self::$rules ??= [
                DNS_SOA   => [
                    'name'  => 'SOA',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => preg_replace('#\\.#', '@', $record['rname'] ?? '', 1),
                ],
                DNS_PTR   => [
                    'name'  => 'PTR',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['target'],
                ],
                DNS_NS    => [
                    'name'  => 'NS',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['target'],
                ],
                DNS_CNAME => [
                    'name'  => 'CNAME',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['target'],
                ],
                DNS_A     => [
                    'name'  => 'A',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['ip'],
                ],
                DNS_AAAA  => [
                    'name'  => 'AAAA',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['ipv6'],
                ],
                DNS_MX    => [
                    'name'  => 'MX',
                    'sort'  => function (&$records) {
                        shuffle($records);
                        usort($records, fn($a, $b) => $a['pri'] <=> $b['pri']);
                    },
                    'value' => fn($record) => $record['target'],
                ],
                DNS_SRV   => [
                    'name'  => 'SRV',
                    'sort'  => function (&$records) {
                        $weights = array_aggregate($records, ['weights' => fn($group) => array_sum(array_column($group, 'weight'))], 'pri');
                        $score = array_map(fn($row) => rand($row['weight'], $weights[$row['pri']]['weights']), $records);
                        uksort($records, fn($a, $b) => $records[$a]['pri'] <=> $records[$b]['pri'] ?: $score[$b] <=> $score[$a]);
                    },
                    'value' => fn($record) => $record['target'] . ':' . $record['port'],
                ],
                DNS_TXT   => [
                    'name'  => 'TXT',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => $record['txt'],
                ],
                DNS_NAPTR => [
                    'name'  => 'NAPTR',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => (object) $record,
                ],
                DNS_HINFO => [
                    'name'  => 'HINFO',
                    'sort'  => fn(&$records) => shuffle($records),
                    'value' => fn($record) => (object) $record,
                ],
                // Windows not supported
                // DNS_A6    => [],
                // DNS_CAA   => [],
            ];
        }

        public function __destruct()
        {
            foreach (self::$cache as $hostname => $records) {
                if (self::$original[$hostname] !== $records) {
                    $cachefile = "{$this->storage}/" . rawurlencode($hostname) . ".php";
                    file_set_contents($cachefile, '<?php return ' . var_export($records, true) . ';');
                    opcache_invalidate($cachefile, true);
                }
            }
        }

        private function &loadCache(string $hostname)
        {
            if (!isset(self::$cache[$hostname])) {
                $cachefile = "{$this->storage}/" . rawurlencode($hostname) . ".php";
                self::$cache[$hostname] = file_exists($cachefile) ? include $cachefile : [];
            }

            self::$original[$hostname] ??= self::$cache[$hostname];

            return self::$cache[$hostname];
        }

        public function flush()
        {
            self::$cache = [];
            self::$original = [];

            foreach (glob("{$this->storage}/*.php") as $cachefile) {
                @unlink($cachefile);
                opcache_invalidate($cachefile, true);
            }
        }

        public function resolve(string $hostname, int $type, $returnAs = 'raw')
        {
            // 不正な $hostname はこの段階で弾く（下手すると無限ループの可能性があるため）
            if (!filter_var($hostname, FILTER_VALIDATE_IP) && !filter_var($hostname, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
                throw new \InvalidArgumentException("$hostname is not a valid DNS name");
            }

            // dns_get_record の type は文字列なので読み替え用のマップが必要
            $target_dns = array_flip(array_map(fn($r) => $r['name'], array_filter(self::$rules, fn($k) => $k & $type, ARRAY_FILTER_USE_KEY)));

            // 全レコード（変更感知のため参照変数）
            $allRecords = &$this->loadCache($hostname);

            // TTL で伏せる
            foreach ($allRecords as $rtype => $record) {
                foreach ($record as $r) {
                    if (($r['@time'] + $r['ttl']) <= time()) {
                        // 不揃い TTL は許容しない。一つでも切れていたら丸ごと伏せる
                        unset($allRecords[$rtype]);
                        break;
                    }
                }
            }

            // 無かったり TTL 切れなどは問い合わせる
            $missings = array_diff_key($target_dns, $allRecords);
            if ($missings) {
                $allRecords += $this->_query($hostname, array_sum($missings));
            }

            // それでも無い場合は NXDOMAIN
            $missings = array_diff_key($target_dns, $allRecords);
            if ($missings) {
                // DNS の仕様上、NXDOMAIN の TTL は SOA(minimum-ttl) に従う
                $soa = (function () use ($allRecords, $missings, $hostname) {
                    // 自身が持っているならそれでよい
                    if (isset($allRecords['SOA'])) {
                        return $allRecords['SOA'];
                    }
                    // 持っていないなら問い合わせる必要があるが今の問い合わせが SOA だと無限ループするので飛ばす
                    if (!isset($missings['SOA'])) {
                        $soa = $this->resolve($hostname, DNS_SOA, 'raw') ?? [];
                        if (isset($soa[0]['minimum-ttl'])) {
                            return $soa;
                        }
                    }
                    // それ以降は親を辿っていく
                    $parentname = implode('.', array_slice(explode('.', $hostname), 1));
                    if (strlen($parentname)) {
                        return $this->resolve($parentname, DNS_SOA, 'raw') ?? [];
                    }
                    return [];
                })();

                // NXDOMAIN は null として必要最小限の情報だけ入れる
                foreach ($missings as $typename => $_) {
                    $allRecords[$typename][] = [
                        ''      => null,
                        'type'  => $typename,
                        'ttl'   => $soa[0]['minimum-ttl'] ?? $this->nxdomainTtl,
                        '@time' => time(),
                    ];
                }
            }

            // 整形して返す（下手に書き換えると保存されるので別メソッドに切り出している）
            $results = $this->_singulate($allRecords, $returnAs);
            if (count($target_dns) === 1) {
                return $results[array_key_first($target_dns)];
            }
            else {
                return array_intersect_key($results, $target_dns);
            }
        }

        private function _query(string $hostname, int $type)
        {
            // IP はエラーにせず A/AAAA で解決されたとみなす
            if (filter_var($hostname, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $resolved = [
                    ['type' => 'A', 'ttl' => 0, 'ip' => $hostname],
                    ['type' => 'SOA', 'ttl' => 0, 'minimum-ttl' => $this->nxdomainTtl],
                ];
            }
            elseif (filter_var($hostname, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $resolved = [
                    ['type' => 'AAAA', 'ttl' => 0, 'ipv6' => $hostname],
                    ['type' => 'SOA', 'ttl' => 0, 'minimum-ttl' => $this->nxdomainTtl],
                ];
            }
            // それ以外は DNS を引く
            else {
                $resolved = [];
                if ($this->hosts) {
                    $target_dns = array_flip(array_map(fn($r) => $r['name'], array_filter(self::$rules, fn($k) => $k & $type, ARRAY_FILTER_USE_KEY)));
                    foreach ($this->hosts as $record) {
                        if (isset($target_dns[$record['type']]) && $record['host'] === $hostname) {
                            $resolved[] = $record;
                        }
                    }
                }

                if (!$resolved) {
                    $resolved = @dns_get_record($hostname, $type);
                    if ($resolved === false) {
                        $error = error_get_last();
                        throw new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
                    }
                }
            }

            $records = [];
            foreach ($resolved as $record) {
                if (!($record['ttl'] ?? 0)) {
                    $record['ttl'] = $this->ttl0;
                }
                $record['@time'] = time();
                $records[$record['type']][] = $record;
            }
            return $records;
        }

        private function _singulate(array $allRecords, $returnAs)
        {
            if ($returnAs === 'raw') {
                return $allRecords;
            }

            foreach (self::$rules as $rule) {
                if (isset($allRecords[$rule['name']])) {
                    $records = &$allRecords[$rule['name']];

                    $records = array_values(array_filter($records, fn($r) => !array_key_exists('', $r)));
                    $rule['sort']($records);

                    foreach ($records as $n => $record) {
                        $records[$n] = $rule['value']($record);
                    }

                    if ($returnAs === 'value') {
                        $records = reset($records) ?: null;
                    }
                }
            }
            return $allRecords;
        }
    };

    if ($flush) {
        $client->flush();
    }

    return $client->resolve($hostname, $type, $returnAs);
}
