<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_requests.php';
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
 * 膨大な配列として保持するのでメモ化等は一切行わない。
 * opcache 前提であるので、CLI 等で呼ぶとかなり遅くなるので注意。
 *
 * ipv6 は今のところ未対応。
 *
 * Example:
 * ```php
 * // apnic 管轄
 * that(ip_info(gethostbyname('www.nic.ad.jp')))->is([
 *     'cidr'     => '192.41.192.0/24',
 *     'registry' => 'apnic',
 *     'cc'       => 'JP',
 *     'date'     => '19880620',
 * ]);
 * // arin 管轄
 * that(ip_info(gethostbyname('www.internic.net')))->is([
 *     'cidr'     => '192.0.32.0/20',
 *     'registry' => 'arin',
 *     'cc'       => 'US',
 *     'date'     => '20090629',
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
 * @return ?array IP の情報。ヒットしない場合は null
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
        'cachedir' => function_configure('storagedir') . '/' . rawurlencode(__FUNCTION__),
        'ttl'      => 60 * 60 * 24 + 120, // 120 は1日1回バッチで叩くことを前提としたバッファ
        'rir'      => [],
    ];
    $options['rir'] += [
        'afrinic' => 'https://ftp.afrinic.net/pub/stats/afrinic/delegated-afrinic-latest',
        'apnic'   => 'https://ftp.apnic.net/pub/stats/apnic/delegated-apnic-latest',
        'arin'    => 'https://ftp.arin.net/pub/stats/arin/delegated-arin-extended-latest',
        'lacnic'  => 'https://ftp.lacnic.net/pub/stats/lacnic/delegated-lacnic-latest',
        'ripe'    => 'https://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-latest',
    ];

    $urls = [];
    $files = [
        'reserved' => (function () {
            $reserved = [];
            foreach ([
                ['RFC1700', '0.0.0.0', 8],         // wildcard
                ['RFC919', '255.255.255.255', 32], // broadcast
                ['RFC5771', '224.0.0.0', 4],       // multicast
                ['RFC1122', '127.0.0.0', 8],       // loopback
                ['RFC3927', '169.254.0.0', 16],    // link-local
                ['RFC1918', '10.0.0.0', 8],        // private
                ['RFC1918', '172.16.0.0', 12],     // private
                ['RFC1918', '192.168.0.0', 24],    // private
            ] as [$name, $ip, $mask]) {
                $reserved[substr(sprintf("%032b", ip2long($ip)), 0, $mask)] = [
                    'cidr'     => "$ip/$mask",
                    'registry' => $name,
                    'cc'       => null,
                    'date'     => null,
                ];
            }
            return $reserved;
        })(),
    ];
    foreach ($options['rir'] as $rir => $url) {
        $cachefile = "{$options['cachedir']}/$rir.php";
        if (!file_exists($cachefile) || (time() - filemtime($cachefile)) >= $options['ttl']) {
            $urls[$rir] = $url;
        }
        $files[$rir] = $cachefile;
    }

    http_requests($urls, [
        'cachedir' => $options['cachedir'],
        'callback' => function ($rir, $body) use ($files) {
            $tmpfile = tmpfile();
            fwrite($tmpfile, $body);
            rewind($tmpfile);

            $cidrs = [];
            while (($fields = fgetcsv($tmpfile, 0, "|")) !== false) {
                if (($fields[2] ?? '') === 'ipv4' && in_array($fields[6] ?? '', ['assigned', 'allocated'], true)) {
                    $subnet = 32 - strlen(sprintf("%b", $fields[4] - 1));
                    $key = substr(sprintf("%032b", ip2long($fields[3])), 0, $subnet);
                    $cidrs[$key] = [
                        'cidr'     => "{$fields[3]}/$subnet",
                        'registry' => $fields[0],
                        'cc'       => $fields[1],
                        'date'     => $fields[5],
                    ];
                }
            }

            $cachefile = $files[$rir];
            file_put_contents($cachefile, "<?php\nreturn " . var_export($cidrs, true) . ";", LOCK_EX);
            //file_put_contents($cachefile, php_strip_whitespace($cachefile));
            opcache_invalidate($cachefile, true);
        },
    ]);

    $all = [];
    foreach ($files as $file) {
        // サイズがでかいので static 等にはしない（opcache に完全に任せる）
        $rir = is_array($file) ? $file : include $file;

        if ($ipaddr === null) {
            $all += $rir;
            continue;
        }

        $binary = sprintf("%032b", ip2long($ipaddr));
        foreach (range(32, 1) as $n) {
            $key = substr($binary, 0, $n);
            if (isset($rir[$key])) {
                return $rir[$key];
            }
        }
    }

    if ($ipaddr === null) {
        return $all;
    }

    return null;
}