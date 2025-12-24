<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * ストリームの雑多な情報を返す
 *
 * - descriptor: ファイルデスクリプタ番号
 * - inode: ファイル inode
 * - realpath: 現在のファイル名（ファイスシステム上に残っておらず、デスクリプタだけが存在する場合は null）
 * - filename: 開いた時のファイル名
 *
 * procfs を用いていて Windows はテスト用に模倣しているだけなので使用してはならない。
 *
 * @package ryunosuke\Functions\Package\stream
 */
function stream_describe($stream = null): ?array
{
    // fd の蒐集（同じファイルを複数のリソースで開いていることもあるので inode 単位で集約する）
    $descriptors = [];
    if (DIRECTORY_SEPARATOR === '\\') {
        exec('handle -v -p ' . getmypid(), $output);
        foreach (array_slice($output, 6) as $descriptor) {
            [, , , $fd, $type, , $realpath] = str_getcsv($descriptor);
            if ($type === 'File') {
                clearstatcache(true, $realpath);
                if (file_exists($realpath)) {
                    $inode = hexdec(trim(explode(' ', shell_exec('fsutil file queryfileid ' . escapeshellarg($realpath)))[3]));
                    $descriptors[$inode][] = [
                        'realpath'   => $realpath,
                        'descriptor' => hexdec($fd),
                    ];
                }
            }
        }
    }
    else {
        // @codeCoverageIgnoreStart
        foreach (glob("/proc/self/fd/*") as $descriptor) {
            clearstatcache(true, $descriptor);
            $fd = (int) basename($descriptor);
            // always failing
            // $stat = stat("php://fd/$fd");

            // fd は残っているがファイルが消されていると realpath は失敗する
            // もはやファイル名が存在しないので fileinode は使えない（幸いにも fd から resource を開く機能があるので代替する）
            $realpath = realpath($descriptor);
            if ($realpath === false) {
                $fp = @fopen("php://fd/$fd", "r");
                if ($fp === false) {
                    continue;
                }
                $fstat = fstat($fp);
                $inode = $fstat['ino'];
                $realpath = null;
                fclose($fp);
            }
            else {
                $inode = fileinode($realpath);
            }

            $descriptors[$inode][] = [
                'realpath'   => $realpath,
                'descriptor' => $fd,
            ];
        }
        // @codeCoverageIgnoreEnd
    }

    $results = [];
    foreach (get_resources('stream') as $resource) {
        $metadata = stream_get_meta_data($resource);
        if (isset($metadata['uri'])) {
            $fstat = fstat($resource);
            if ($fstat) {
                if (isset($descriptors[$fstat['ino']])) {
                    // resource と fd は id は一致しないが時系列での増減は同じなので順番に取り出せば一致する
                    $descriptor = array_shift($descriptors[$fstat['ino']]);
                    $results[(int) $resource] = [
                        'type'       => $metadata['wrapper_type'],
                        'descriptor' => $descriptor['descriptor'],
                        'inode'      => $fstat['ino'],
                        'realpath'   => $descriptor['realpath'],
                        'filename'   => $metadata['uri'],
                    ];
                    if ($stream === $resource) {
                        return $results[(int) $resource];
                    }
                }
            }
        }
    }

    return $results;
}
