<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../exec/process_async.php';
require_once __DIR__ . '/../network/ip_normalize.php';
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../var/si_prefix.php';
require_once __DIR__ . '/../var/si_unprefix.php';
// @codeCoverageIgnoreEnd

/**
 * システムの各種情報配列を返す
 *
 * Windows 版はオマケ実装。
 * この関数の結果は互換性を考慮しない。
 *
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\info
 */
function system_status(
    /** バイト系数値の単位 */ string $siunit = '',
    /** 日時系のフォーマット */ string $datetime_format = \DateTimeInterface::RFC3339,
): array {
    $unitize = function ($size) use ($siunit) {
        return match ($siunit) {
            'k'     => sprintf('%.3f', $size / 1024),
            'm'     => sprintf('%.3f', $size / 1024 / 1024),
            'g'     => sprintf('%.3f', $size / 1024 / 1024 / 1024),
            'h'     => si_prefix($size, 1024),
            ','     => number_format($size),
            ''      => $size,
            default => throw new \InvalidArgumentException("$siunit must be [k,m,g,h,'']"),
        };
    };
    $datetime = function ($time) use ($datetime_format) {
        if (strlen($datetime_format)) {
            return date($datetime_format, $time);
        }
        else {
            return $time;
        }
    };

    // counter 値だけは待機が長いので一括で取ってくる
    $counters = null;
    if (DIRECTORY_SEPARATOR === '\\') {
        $counters = process_async('powershell', [
            '-Command',
            'ConvertTo-Json @(
              Get-Counter -MaxSamples 1 -SampleInterval 1 -Counter "\System\Processor Queue Length","\Process(*)\% Privileged Time","\Process(*)\% User Time","\Processor(*)\% Processor Time"
            ).CounterSamples',
        ]);
        $counters->setCompleteAction(function () {
            /** @var \ProcessAsync $this */
            $data = json_decode($this->stdout, true);
            $counters = [
                'queue'  => [],
                'system' => [],
                'user'   => [],
                'time'   => [],
            ];
            foreach ($data as $stat) {
                if (str_ends_with($stat['Path'], '\\system\\processor queue length')) {
                    $counters['queue'] = $stat['CookedValue'];
                }
                elseif (str_ends_with($stat['Path'], '\\% privileged time')) {
                    $counters['system'][$stat['InstanceName']] = $stat['CookedValue'];
                }
                elseif (str_ends_with($stat['Path'], '\\% user time')) {
                    $counters['user'][$stat['InstanceName']] = $stat['CookedValue'];
                }
                elseif (str_ends_with($stat['Path'], '\\% processor time')) {
                    $counters['time'][$stat['InstanceName']] = $stat['CookedValue'];
                }
            }
            unset($counters['system']['_total'], $counters['system']['idle']);
            unset($counters['user']['_total'], $counters['user']['idle']);
            unset($counters['time']['_total']);
            return $counters;
        });
    }

    return array_map(fn($gather) => $gather(), [
        'os'         => (function () use ($datetime, $counters) {
            if (DIRECTORY_SEPARATOR === '\\') {
                $provide = process_async('powershell', ['-Command', 'ConvertTo-Json (Get-WmiObject win32_operatingsystem | Select-Object *)']);
                $provide->setCompleteAction(function () use ($counters) {
                    /** @var \ProcessAsync $this */
                    $data = json_decode($this->stdout, true);
                    return [
                        'name'    => $data['Caption'],
                        'version' => php_uname('r'),
                        'release' => $data['Version'],
                        'uptime'  => time() - date_create_from_format('YmdHis.u+', $data['LastBootUpTime'])->getTimestamp(),
                        'process' => [
                            'running' => count(array_filter($counters()['user'], fn($v) => $v > 0)),
                            'blocked' => count(array_filter($counters()['system'], fn($v) => $v > 0)),
                        ],
                        'loadavg' => [1 => (float) $counters()['queue']],
                    ];
                });
            }
            else {
                $provide = function () {
                    $os_release = parse_ini_file('/etc/os-release');
                    $proc_uptime = explode(' ', file_get_contents('/proc/uptime'));
                    preg_match_all('#^(procs_.+?)\s+(\d+)$#mu', file_get_contents('/proc/stat'), $matches, PREG_SET_ORDER);
                    $procs = [];
                    foreach ($matches as [, $name, $count]) {
                        $procs[$name] = $count;
                    }
                    return [
                        'name'    => $os_release['NAME'],
                        'version' => $os_release['VERSION_ID'],
                        'release' => php_uname('r'),
                        'uptime'  => (int) $proc_uptime[0],
                        'process' => [
                            'running' => (int) $procs['procs_running'],
                            'blocked' => (int) $procs['procs_blocked'],
                        ],
                        'loadavg' => array_combine([60, 300, 900], sys_getloadavg()),
                    ];
                };
            }

            return function () use ($provide, $datetime) {
                $misc = $provide();
                return [
                    'name'         => $misc['name'],
                    'version'      => $misc['version'],
                    'release'      => $misc['release'],
                    'architecture' => php_uname('m'),
                    'hostname'     => php_uname('n'),
                    'boottime'     => $datetime(time() - $misc['uptime']),
                    'uptime'       => $misc['uptime'],
                    'localtime'    => $datetime(time()),
                    'process'      => $misc['process'],
                    'loadavg'      => $misc['loadavg'],
                ];
            };
        })(),
        'cpu'        => (function () use ($unitize, $counters) {
            if (DIRECTORY_SEPARATOR === '\\') {
                $provide = process_async('powershell', ['-Command', 'ConvertTo-Json @(Get-WmiObject win32_processor | Select-Object *)']);
                $provide->setCompleteAction(function () use ($counters) {
                    /** @var \ProcessAsync $this */
                    $cpu_info = json_decode($this->stdout, true);
                    $rules = [
                        'id'     => fn($v) => $v['DeviceID'],
                        'bit'    => fn($v) => (int) $v['DataWidth'],
                        'clock'  => fn($v) => $v['MaxClockSpeed'] * 1024 * 1024,
                        'core'   => fn($v) => (int) $v['NumberOfCores'],
                        'thread' => fn($v) => (int) $v['NumberOfLogicalProcessors'],
                        'cache'  => fn($v) => ($v['L2CacheSize'] + $v['L3CacheSize']) * 1024,
                        'name'   => fn($v) => trim($v['Name']),
                        'vendor' => fn($v) => trim($v['Manufacturer']),
                    ];
                    $cpus = [];
                    foreach ($cpu_info as $cpu) {
                        $cpus[] = array_map(fn($rule) => $rule($cpu), $rules);
                    }
                    return [$cpus, array_map(fn($v) => $v / 100, $counters()['time'])];
                });
            }
            else {
                $provide = function () {
                    $CLK_TCK = 100; // sysconf(_SC_CLK_TCK);
                    $TIME_SPAN = 1000 / rand(5000, 10000);

                    $proc_stat = function () {
                        preg_match_all('#^cpu(\d+)\s+(.+)$#mu', file_get_contents('/proc/stat'), $matches, PREG_SET_ORDER);
                        $stats = [];
                        foreach ($matches as [, $core, $ticks]) {
                            [$user, $nice, $system, /*$idle*/, $iowait, $irq, $softirq, $steal, $guest, $guest_nice] = preg_split('#\s+#u', $ticks, -1, PREG_SPLIT_NO_EMPTY);
                            $stats[$core] = (int) $user + (int) $nice + (int) $system + (int) $iowait + (int) $irq + (int) $softirq + (int) $steal + (int) $guest + (int) $guest_nice;
                        }
                        return $stats;
                    };

                    $before = $proc_stat();
                    usleep((int) ($TIME_SPAN * 1000 * 1000));
                    $after = $proc_stat();

                    $times = [];
                    foreach ($after as $core => $ticks) {
                        $times[$core] = ($ticks - $before[$core]) / $CLK_TCK / $TIME_SPAN;
                    }

                    $rules = [
                        'id'     => fn($v) => (int) $v['physical id'],
                        'bit'    => fn($v) => (int) $v['clflush size'],
                        'clock'  => fn($v) => $v['cpu MHz'] * 1024 * 1024,
                        'core'   => fn($v) => (int) $v['cpu cores'],
                        'thread' => fn($v) => (int) $v['siblings'],
                        'cache'  => fn($v) => si_unprefix($v['cache size'], 1024, '%d %sB'),
                        'name'   => fn($v) => trim($v['model name']),
                        'vendor' => fn($v) => trim($v['vendor_id']),
                    ];
                    $cpu_info = preg_split("#\R\R#u", trim(file_get_contents('/proc/cpuinfo')));

                    $cpus = [];
                    foreach ($cpu_info as $info) {
                        $info = str_array($info, ':', true);
                        $cpu = array_map(fn($rule) => $rule($info), $rules);
                        $cpus[$cpu['id']] = $cpu;
                    }
                    return [$cpus, $times];
                };
            }

            return function () use ($provide, $unitize) {
                [$cpus, $times] = $provide();

                foreach ($cpus as $n => $cpu) {
                    $cpus[$n]['clock'] = $unitize($cpu['clock']);
                    $cpus[$n]['cache'] = $unitize($cpu['cache']);

                    $usages = array_splice($times, 0, $cpu['thread'], []);
                    $cpus[$n]['usage'] = array_sum($usages) / $cpu['thread'];
                    $cpus[$n]['usages'] = $usages;
                }
                return $cpus;
            };
        })(),
        'memory'     => (function () use ($unitize) {
            if (DIRECTORY_SEPARATOR === '\\') {
                $provide = process_async('powershell', ['-Command', 'ConvertTo-Json (Get-WmiObject win32_operatingsystem | Select-Object *)']);
                $provide->setCompleteAction(function () {
                    /** @var \ProcessAsync $this */
                    $memory_info = json_decode($this->stdout, true);

                    $memory_total = $memory_info['TotalVisibleMemorySize'] * 1024;
                    $memory_free = $memory_info['FreePhysicalMemory'] * 1024;
                    $memory_available = $memory_info['FreePhysicalMemory'] * 1024;

                    $swap_total = ($memory_info['TotalVirtualMemorySize'] - $memory_info['TotalVisibleMemorySize']) * 1024;
                    $swap_free = $memory_info['FreeVirtualMemory'] * 1024;

                    return [$memory_total, $memory_free, $memory_available, $swap_total, $swap_free];
                });
            }
            else {
                $provide = function () {
                    $memory_info = str_array(trim(file_get_contents('/proc/meminfo')), ':', true);

                    $memory_total = si_unprefix($memory_info['MemTotal'], 1024, '%d %sB');
                    $memory_free = si_unprefix($memory_info['MemFree'], 1024, '%d %sB');
                    $memory_available = si_unprefix($memory_info['MemAvailable'], 1024, '%d %sB');

                    $swap_total = si_unprefix($memory_info['SwapTotal'], 1024, '%d %sB');
                    $swap_free = si_unprefix($memory_info['SwapFree'], 1024, '%d %sB');

                    return [$memory_total, $memory_free, $memory_available, $swap_total, $swap_free];
                };
            }

            return function () use ($unitize, $provide) {
                [$memory_total, $memory_free, $memory_available, $swap_total, $swap_free] = $provide();

                $memory = [
                    'total'     => $memory_total,
                    'free'      => $memory_free,
                    'usage'     => $memory_total - $memory_free,
                    'available' => $memory_available,
                ];
                $swap = [
                    'total'     => $swap_total,
                    'free'      => $swap_free,
                    'usage'     => $swap_total - $swap_free,
                    'available' => $swap_free, // ミスではない。swap に available など存在せず free に等しいので利便性を考慮して free を返す
                ];

                return [
                    'memory'      => array_map($unitize, $memory),
                    'swap'        => array_map($unitize, $swap),
                    'memory+swap' => array_map($unitize, [
                        'total'     => $memory['total'] + $swap['total'],
                        'free'      => $memory['free'] + $swap['free'],
                        'usage'     => $memory['usage'] + $swap['usage'],
                        'available' => $memory['available'] + $swap['available'],
                    ]),
                ];
            };
        })(),
        'filesystem' => (function () use ($unitize) {
            if (DIRECTORY_SEPARATOR === '\\') {
                $provide = process_async('powershell', ['-Command', 'ConvertTo-Json @(Get-WmiObject win32_logicaldisk | Select-Object *)']);
                $provide->setCompleteAction(function () {
                    /** @var \ProcessAsync $this */
                    $mounts = json_decode($this->stdout, true);
                    $result = [];
                    foreach ($mounts as $mount) {
                        $result[] = [
                            'path' => $mount['DeviceID'],
                            'type' => $mount['FileSystem'],
                        ];
                    }
                    return $result;
                });
            }
            else {
                $provide = function () {
                    preg_match_all('#^(/.*?)\s+(/.*?)\s+(.*?)\s+#um', file_get_contents('/proc/mounts'), $matches, PREG_SET_ORDER);
                    $mounts = [];
                    foreach ($matches as [, $device, $path, $fstype]) {
                        if (!isset($mounts[$device])) {
                            $mounts[$device] = [
                                'path' => $path,
                                'type' => $fstype,
                            ];
                        }
                    }
                    return $mounts;
                };
            }

            return function () use ($provide, $unitize) {
                $mounts = $provide();

                $result = [];
                foreach ($mounts as $mount) {
                    $total = @disk_total_space($mount['path']);
                    if ($total === false) {
                        $result[$mount['path']] = [
                            'path'  => $mount['path'],
                            'type'  => $mount['type'],
                            'total' => null,
                            'free'  => null,
                            'usage' => null,
                        ];
                        continue;
                    }
                    $free = disk_free_space($mount['path']);
                    $result[$mount['path']] = [
                        'path'  => $mount['path'],
                        'type'  => $mount['type'],
                        'total' => $unitize((int) $total),
                        'free'  => $unitize((int) $free),
                        'usage' => $unitize((int) ($total - $free)),
                    ];
                }
                return $result;
            };
        })(),
        'network'    => (function () {
            if (DIRECTORY_SEPARATOR === '\\') {
                $provide = process_async('powershell', [
                    '-Command',
                    'ConvertTo-Json @{
                      tcp = (Get-NetTCPConnection | Select-Object State,LocalAddress,LocalPort)
                      udp = (Get-NetUDPEndpoint   | Select-Object State,LocalAddress,LocalPort)
                    }',
                ]);
                $provide->setCompleteAction(function () {
                    /** @var \ProcessAsync $this */
                    $parse = function ($rows, $st) {
                        $result = [4 => [], 6 => []];
                        foreach ($rows as $row) {
                            if ($row['State'] === $st) {
                                $address = $row['LocalAddress'];
                                if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                                    if ($address === '0.0.0.0') {
                                        $address = '*';
                                    }
                                    $result[4][$address][] = $row['LocalPort'];
                                }
                                if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                                    if ($address === '::') {
                                        $address = '*';
                                    }
                                    $result[6][$address][] = $row['LocalPort'];
                                }
                            }
                        }
                        return $result;
                    };
                    $netstat = json_decode($this->stdout, true);

                    $binds = array_merge(
                        array_combine(['tcp4', 'tcp6'], $parse($netstat['tcp'], 2)),
                        array_combine(['udp4', 'udp6'], $parse($netstat['udp'], null)), // @todo 取れない？
                    );
                    return [[], $binds];
                });
            }
            else {
                $provide = function () {
                    $nicdata = [];
                    foreach (glob('/sys/class/net/*') as $nic) {
                        $nicdata[basename($nic)] = [
                            'mtu' => (int) trim(file_get_contents("$nic/mtu")),
                            'mac' => trim(file_get_contents("$nic/address")),
                        ];
                    }

                    $parseV4 = function ($filename, $st) {
                        $result = [];
                        $rows = str_array(file_get_contents($filename), ' ', false, false);
                        foreach ($rows as $row) {
                            if ($row['st'] === $st) {
                                [$address, $port] = explode(':', $row['local_address']);
                                $address = implode('.', array_map('hexdec', array_reverse(str_split($address, 2))));
                                if ($address === '0.0.0.0') {
                                    $address = '*';
                                }
                                $result[$address][] = hexdec($port);
                            }
                        }
                        return $result;
                    };
                    $parseV6 = function ($filename, $st) {
                        $result = [];
                        $rows = str_array(file_get_contents($filename), ' ', false, false);
                        foreach ($rows as $row) {
                            if ($row['st'] === $st) {
                                [$address, $port] = explode(':', $row['local_address']);
                                $segments = str_split($address, 8);
                                foreach ($segments as $n => $segment) {
                                    $segments[$n] = vsprintf("%s%s:%s%s", array_map('strtolower', array_reverse(str_split($segment, 2))));
                                }
                                $address = implode(':', $segments);
                                if ($address === '0000:0000:0000:0000:0000:0000:0000:0000') {
                                    $address = '*';
                                }
                                $result[$address][] = hexdec($port);
                            }
                        }
                        return $result;
                    };

                    $binds = [
                        'tcp4' => $parseV4('/proc/net/tcp', '0A'),
                        'tcp6' => $parseV6('/proc/net/tcp6', '0A'),
                        'udp4' => $parseV4('/proc/net/udp', '07'),
                        'udp6' => $parseV6('/proc/net/udp6', '07'),
                    ];

                    return [$nicdata, $binds];
                };
            }

            return function () use ($provide) {
                [$nicdata, $binds] = $provide();

                $result = [];
                foreach (net_get_interfaces() as $name => $interface) {
                    foreach ($interface['unicast'] as $unicast) {
                        if (in_array($unicast['family'], [AF_INET, AF_INET6])) {
                            $version = $unicast['family'] === AF_INET ? 4 : 6;
                            $address = ip_normalize($unicast['address']);
                            $result[$unicast['address']] = [
                                'address'   => $unicast['address'],
                                'netmask'   => $unicast['netmask'],
                                'version'   => $version,
                                'tcp-ports' => array_merge($binds["tcp$version"][$address] ?? [], $binds["tcp$version"]['*'] ?? []),
                                'udp-ports' => array_merge($binds["udp$version"][$address] ?? [], $binds["udp$version"]['*'] ?? []),
                                'name'      => $name,
                                'mac'       => $interface['mac'] ?? $nicdata[$name]['mac'] ?? null,
                                'mtu'       => $interface['mtu'] ?? $nicdata[$name]['mtu'] ?? null,
                            ];
                        }
                    }
                }
                return $result;
            };
        })(),
    ]);
}
