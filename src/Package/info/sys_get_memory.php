<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../exec/process.php';
require_once __DIR__ . '/../strings/str_array.php';
require_once __DIR__ . '/../utility/json_storage.php';
require_once __DIR__ . '/../var/si_unprefix.php';
// @codeCoverageIgnoreEnd

/**
 * システムのメモリを取得する
 *
 * php にはメモリ情報を返す関数が存在しないので共通のために作成。
 * Windows 版はかなりやっつけなので過度に呼んではならない。
 *
 * $cacheSecond を指定するとその秒数分はキャッシュを返すようになる。
 *
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\info
 *
 * @param int $cacheSecond キャッシュ秒数
 * @return array メモリ情報
 */
function sys_get_memory(int $cacheSecond = 0)
{
    if (DIRECTORY_SEPARATOR === '\\') {
        $provide = function () {
            process('powershell', ['-Command', 'ConvertTo-Json (Get-WmiObject win32_operatingsystem | Select-Object *)'], '', $stdout);
            $memory_info = json_decode($stdout, true);

            $memory_total = $memory_info['TotalVisibleMemorySize'] * 1024;
            $memory_free = $memory_info['FreePhysicalMemory'] * 1024;
            $memory_available = $memory_info['FreePhysicalMemory'] * 1024;

            $swap_total = ($memory_info['TotalVirtualMemorySize'] - $memory_info['TotalVisibleMemorySize']) * 1024;
            $swap_free = $memory_info['FreeVirtualMemory'] * 1024;

            return compact('memory_total', 'memory_free', 'memory_available', 'swap_total', 'swap_free');
        };
    }
    else {
        $provide = function () {
            $memory_info = str_array(trim(file_get_contents('/proc/meminfo')), ':', true);

            $memory_total = si_unprefix($memory_info['MemTotal'], 1024, '%d %sB');
            $memory_free = si_unprefix($memory_info['MemFree'], 1024, '%d %sB');
            $memory_available = si_unprefix($memory_info['MemAvailable'], 1024, '%d %sB');

            $swap_total = si_unprefix($memory_info['SwapTotal'], 1024, '%d %sB');
            $swap_free = si_unprefix($memory_info['SwapFree'], 1024, '%d %sB');

            return compact('memory_total', 'memory_free', 'memory_available', 'swap_total', 'swap_free');
        };
    }

    $storage = json_storage(__FUNCTION__, $cacheSecond);
    $storage['result'] ??= $provide();

    return $storage['result'];
}
