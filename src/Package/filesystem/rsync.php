<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/groupsort.php';
require_once __DIR__ . '/../filesystem/dir_diff.php';
require_once __DIR__ . '/../filesystem/file_equals.php';
require_once __DIR__ . '/../filesystem/strmode.php';
require_once __DIR__ . '/../info/ansi_colorize.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../pcre/glob2regex.php';
require_once __DIR__ . '/../strings/mb_ellipsis.php';
require_once __DIR__ . '/../strings/mb_monospace.php';
require_once __DIR__ . '/../strings/str_diff.php';
require_once __DIR__ . '/../syntax/try_close.php';
require_once __DIR__ . '/../var/si_prefix.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * php レイヤーで rsync 的なことをする
 *
 * rsync プロトコルを喋ったりオプションを完全網羅していたりはしない（意図的に合わせたりはしているが）。
 * 単純に必要に迫られて実装したものであり、効率も度外視。
 *
 * generator で実装されており、動作ログを generate する。
 * generator は返り値として統計情報を返す。
 *
 * ただの劣化 rsync だが php 実装なのでストリームラッパーさえ実装すればプロトコルを超えることができる。
 * やる気になればリモート間転送も可能（自身経由なので速度は劣悪になるが）。
 * つまり file -> S3 や S3 -> S3 等も可能。
 *
 * generate される文字列は互換性を担保しない。
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $src 送信側ディレクトリ
 * @param string $dst 受信側ディレクトリ
 * @param array $options オプション
 * @return \Generator 動作ログを返す generator
 */
function rsync($src, $dst, $options = [])
{
    $rsyncer = new class($options + [
            // important
            'dry-run'          => false,         // 実際には転送せずログのみを出す
            'block-size'       => 4096,          // ファイル比較に使用するチャンクサイズ
            // transmit
            'exclude'          => [],            // 除外パターン（**が使える glob パターン。~始まりで正規表現）
            'include'          => [],            // 許可パターン（除外されていてもこれにマッチすれば転送される）
            'update'           => false,         // 受信側の方が新しい場合は転送しない
            'delete'           => false,         // 送信側にないファイルを削除する
            'delete-excluded'  => false,         // ファイルリスト外のファイルを削除する
            // transfer
            'times'            => true,          // タイムスタンプを維持する
            'perms'            => true,          // パーミッションを維持する
            'owner'            => true,          // ファイルオーナーを維持する
            'group'            => true,          // ファイルグループを維持する
            // output
            'log-format'       => '%-6s %s=>%s, %s=>%s, %s:%s=>%s:%s, %s=>%s', // null 指定で raw な配列で返ってくる（実質的にデバッグ用）
            'diff'             => 'split=1,160', // ファイル差分も合わせて表示するときのオプション（null 指定で差分表示なし）
            'human-readable'   => false,         // 出力を見やすく整形する
            'verbose'          => 0,             // ログの詳細度（0:出力なし, 1:ファイルリストのみ, 2:1+記号, 3:2+詳細）
            'verbose-excluded' => true,          // excluded されたものでも verbose ログに含める
            'ansi'             => null,          // ansi color フラグ
        ]) {
        const DIFF_TIMES   = 1 << 1;
        const DIFF_PERMS   = 1 << 2;
        const DIFF_OWNER   = 1 << 3;
        const DIFF_GROUP   = 1 << 4;
        const DIFF_CONTENT = 1 << 32;

        const OPERATION_SIGNS = [
            'exclude' => '!',
            'mkdir'   => '+',
            'rmdir'   => '-',
            'create'  => '+',
            'delete'  => '-',
            'update'  => '*',
        ];

        const OPERATION_STYLES = [
            'exclude' => 'gray',
            'mkdir'   => 'green',
            'create'  => 'green',
            'update'  => 'yellow',
            'rmdir'   => 'red',
            'delete'  => 'red',
        ];

        private array $options;
        private array $stats = [];

        public function __construct(array $options)
        {
            $options['verbose'] = (int) $options['verbose'];
            $options['ansi'] ??= is_ansi(STDOUT);
            $toregex = function ($pattern) {
                if ($pattern[0] === '~') {
                    return substr($pattern, 1);
                }
                // この動作は rsync に合わせてある
                $regex = glob2regex($pattern, GLOB_RECURSIVE) . '$';
                if ($pattern[0] === '/') {
                    return '^' . $regex;
                }
                else {
                    return '(^|/)' . $regex;
                }
            };
            $options['exclude'] = array_map($toregex, (array) $options['exclude']);
            $options['include'] = array_map($toregex, (array) $options['include']);

            $this->options = $options;
        }

        public function __invoke(string $src, string $dst): \Generator
        {
            if (!is_dir($src)) {
                throw new \UnexpectedValueException("$src is not directory");
            }
            if (is_file($dst)) {
                throw new \UnexpectedValueException("$dst is not directory");
            }

            $reports = array_fill_keys(['mkdir', 'rmdir', 'create', 'update', 'delete', 'size'], 0);
            $reports += array_fill_keys(array_map(fn($k) => "!$k", array_keys($reports)), 0);
            $reports['errors'] = [];
            $reports['start'] = microtime(true);

            $shortnames = [];
            $fileist = array_filter($this->filelist($src, $dst), function ($diff, $filename) use (&$shortnames) {
                // 差分がない場合 delete-excluded でない限りはファイルリストとして不要（逆に言えば delete-excluded の時は必要）
                if ($diff === 0 && !$this->options['delete-excluded']) {
                    return false;
                }
                $shortnames[$filename] = mb_ellipsis($filename, 80, '...');
                return true;
            }, ARRAY_FILTER_USE_BOTH);
            $reports['listing'] = microtime(true);

            $maxlength = max(array_map(fn($v) => mb_monospace($v), $shortnames ?: ['']));

            set_error_handler(function ($errno, $errstr, $errfile, $errline) use (&$reports) {
                if (!(error_reporting() & $errno)) {
                    return false;
                }
                // @codeCoverageIgnoreStart 除外パターン次第でたまにエラーが出るがテストまではしない
                $reports['errors'][] = [
                    'severity' => $errno,
                    'message'  => $errstr,
                    'filename' => $errfile,
                    'line'     => $errline,
                ];
                // @codeCoverageIgnoreEnd
            });
            try {
                foreach ($fileist as $filename => $diff) {
                    $srcfile = "$src/$filename";
                    $dstfile = "$dst/$filename";

                    $matches = true;
                    foreach ($this->options['exclude'] as $exclude) {
                        if (preg_match("<$exclude>u", "/$filename")) {
                            $matches = false;
                            foreach ($this->options['include'] as $include) {
                                if (preg_match("<$include>u", "/$filename")) {
                                    $matches = true;
                                    break;
                                }
                            }
                            break;
                        }
                    }

                    // 自分だけに有る時
                    if ($diff === true) {
                        $operation = ($this->stat($srcfile)['mode'] & 0040_000) ? 'mkdir' : 'create';
                        $excluded = !$matches;
                        $reports[($excluded ? '!' : '') . $operation]++;
                        $reports[($excluded ? '!' : '') . 'size'] += $this->stat($srcfile)['size'];
                    }
                    // 相手だけに有る時
                    elseif ($diff === false) {
                        $operation = ($this->stat($dstfile)['mode'] & 0040_000) ? 'rmdir' : 'delete';
                        $excluded = !$this->options['delete'] || !$matches;
                        $reports[($excluded ? '!' : '') . $operation]++;
                        $reports[($excluded ? '!' : '') . 'size'] += 0;
                    }
                    // 自分にも相手にも有る時
                    else {
                        // マッチしておらず delete-excluded の時は実質的に削除処理（超危険だが rsync はそうなってる）
                        if (!$matches && $this->options['delete-excluded']) {
                            $operation = ($this->stat($dstfile)['mode'] & 0040_000) ? 'rmdir' : 'delete';
                            $excluded = false;
                        }
                        else {
                            $operation = 'update';
                            $excluded = $this->options['update'] && $this->stat($srcfile)['mtime'] < $this->stat($dstfile)['mtime'] || !$matches;
                        }
                        $reports[($excluded ? '!' : '') . $operation]++;
                        $reports[($excluded ? '!' : '') . 'size'] += $this->stat($srcfile)['size'];
                    }

                    yield from $this->sync($shortnames[$filename], $srcfile, $dstfile, $operation, $excluded, $maxlength);
                }
            }
            finally {
                restore_error_handler();
            }
            $reports['syncing'] = microtime(true);

            $results = [
                'time'     => [
                    'total'   => microtime(true) - $reports['start'],
                    'listing' => $reports['listing'] - $reports['start'],
                    'syncing' => $reports['syncing'] - $reports['listing'],
                ],
                'count'    => [
                    'files' => count($fileist),
                ],
                'transfer' => [
                    'mkdir'  => $reports['mkdir'],
                    'rmdir'  => $reports['rmdir'],
                    'create' => $reports['create'],
                    'update' => $reports['update'],
                    'delete' => $reports['delete'],
                    'size'   => $reports['size'],
                ],
                'excluded' => [
                    'mkdir'  => $reports['!mkdir'],
                    'rmdir'  => $reports['!rmdir'],
                    'create' => $reports['!create'],
                    'update' => $reports['!update'],
                    'delete' => $reports['!delete'],
                    'size'   => $reports['!size'],
                ],
                'errors'   => $reports['errors'],
            ];

            if ($this->options['log-format'] !== null) {
                $outstats = function ($data) {
                    return sprintf("mkdir: %s, rmdir: %s, create: %s, update: %s, delete: %s, size: %s",
                        $this->format('int', $data['mkdir']),
                        $this->format('int', $data['rmdir']),
                        $this->format('int', $data['create']),
                        $this->format('int', $data['update']),
                        $this->format('int', $data['delete']),
                        $this->format('byte', $data['size']),
                    );
                };
                $results = <<<STATS
                    times total: {$this->format('float', $results['time']['total'])}, listing: {$this->format('float', $results['time']['listing'])}, syncing: {$this->format('float', $results['time']['syncing'])} seconds
                    total file: {$this->format('int', $results['count']['files'])} files
                    transfer {$outstats($results['transfer'])}
                    excluded {$outstats($results['excluded'])}
                    errors: {$this->format('int', count($results['errors']))}
                    STATS;
            }
            return $results;
        }

        private function filelist(string $src, string $dst): array
        {
            // ファイルリスト
            $filelist = dir_diff($src, $dst, [
                'unixpath' => true,
                'differ'   => function ($file1, $file2) {
                    $stat1 = $this->stat($file1);
                    $stat2 = $this->stat($file2);

                    // メタ系の差分はメタ系だけで返す（どうせコピーするので中身を比較するまでもない）
                    $meta = 0;
                    $meta |= ($this->options['times'] && $stat1['mtime'] !== $stat2['mtime']) ? self::DIFF_TIMES : 0;
                    $meta |= ($this->options['perms'] && $stat1['mode'] !== $stat2['mode']) ? self::DIFF_PERMS : 0;
                    $meta |= ($this->options['owner'] && $stat1['uid'] !== $stat2['uid']) ? self::DIFF_OWNER : 0;
                    $meta |= ($this->options['group'] && $stat1['gid'] !== $stat2['gid']) ? self::DIFF_GROUP : 0;
                    if ($meta) {
                        return $meta;
                    }

                    if (!file_equals($file1, $file2, $this->options['block-size'])) {
                        return self::DIFF_CONTENT;
                    }
                    return 0;
                },
            ]);

            // 追加は親から、削除は子からになるように並べ替え
            $filelist = groupsort($filelist, function ($v, $k) {
                static $current = null;
                if ($v !== false) {
                    return $current = null;
                }
                if ($current === null || strpos($k, $current) === false) {
                    return $current = $k;
                }
                return $current; // @codeCoverageIgnore
            }, fn($a, $b, $ak, $bk) => $bk <=> $ak);

            // 受信側に大本が存在しない場合はリストに加える
            if (!$this->stat($dst)) {
                $filelist = ['/' => true] + $filelist;
            }

            return $filelist;
        }

        private function sync(string $filename, string $srcfile, string $dstfile, string $operation, bool $excluded, int $maxlength)
        {
            $log = null;
            if (!$excluded || $this->options['verbose-excluded']) {
                if ($this->options['verbose'] >= 1) {
                    $log = [
                        'sign' => null,
                        'src'  => null,
                        'dst'  => null,
                        'diff' => null,
                    ];

                    if ($this->options['verbose'] >= 2) {
                        $log['sign'] = ($excluded ? '!' : '') . self::OPERATION_SIGNS[$operation];
                    }

                    if ($this->options['verbose'] >= 3) {
                        $log['src'] = $this->stat($srcfile);
                        $log['dst'] = $this->stat($dstfile);

                        if ($this->options['diff'] && $operation === 'update') {
                            $log['diff'] = try_close(function ($dstfp, $srcfp) {
                                return rtrim(str_diff($dstfp, $srcfp, [
                                    'allow-binary' => null,
                                    'stringify'    => $this->options['diff'],
                                ]));
                            }, fopen($dstfile, 'rb'), fopen($srcfile, 'rb'));
                        }
                    }

                    if ($this->options['log-format'] !== null) {
                        $prefix = $filename;
                        if (isset($log['sign'])) {
                            $prefix = $log['sign'] . $prefix;
                        }
                        $logstring = $this->options['ansi'] ? ansi_colorize($prefix, self::OPERATION_STYLES[$excluded ? 'exclude' : $operation]) : $prefix;

                        if (isset($log['src'], $log['dst'])) {
                            $logstring .= str_repeat(' ', $maxlength - mb_monospace($prefix) + 3);
                            $logstring .= sprintf($this->options['log-format'],
                                $operation,
                                $this->format('mode', $log['dst']['mode'] ?? null) ?? '(none)',
                                $this->format('mode', $log['src']['mode'] ?? null) ?? '(none)',
                                $this->format('time', $log['dst']['mtime'] ?? null) ?? '(none)',
                                $this->format('time', $log['src']['mtime'] ?? null) ?? '(none)',
                                $this->format('owner', $log['dst']['uid'] ?? null) ?? '(none)',
                                $this->format('group', $log['dst']['gid'] ?? null) ?? '(none)',
                                $this->format('owner', $log['src']['uid'] ?? null) ?? '(none)',
                                $this->format('group', $log['src']['gid'] ?? null) ?? '(none)',
                                $this->format('byte', $log['dst']['size'] ?? null) ?? '(none)',
                                $this->format('byte', $log['src']['size'] ?? null) ?? '(none)',
                            );
                        }
                        if (strlen($log['diff'] ?? '')) {
                            $logstring .= "\n" . $log['diff'];
                        }
                        $log = $logstring;
                    }
                }
            }

            if (!$this->options['dry-run'] && !$excluded) {
                static $functions = null;
                $functions ??= [
                    'mkdir'  => static fn($src, $dst) => mkdir($dst, 0777, true),
                    'rmdir'  => static fn($src, $dst) => rmdir($dst),
                    'create' => static fn($src, $dst) => copy($src, $dst),
                    'update' => static fn($src, $dst) => copy($src, $dst),
                    'delete' => static fn($src, $dst) => unlink($dst),
                ];
                $functions[$operation]($srcfile, $dstfile);

                // メタだけの変更を検出してメタ変更だけする、ということはしない
                // 「メタだけの変更」を検出するためには中身を比較して同じである、という検出が必要
                // そんなことをするくらいなら比較せずコピーしてしまった方がマシまである
                if (in_array($operation, ['mkdir', 'create', 'update'], true)) {
                    if ($this->options['times']) {
                        touch($dstfile, $this->stat($srcfile)['mtime']);
                    }
                    if ($this->options['perms']) {
                        chmod($dstfile, $this->stat($srcfile)['mode'] & 0777);
                    }
                    if ($this->options['owner']) {
                        chown($dstfile, $this->stat($srcfile)['uid']);
                    }
                    if ($this->options['group']) {
                        chgrp($dstfile, $this->stat($srcfile)['gid']);
                    }
                }
            }

            return isset($log) ? [$filename => $log] : [];
        }

        private function stat(string $fullpath): array
        {
            // リモートを扱うこともあるので stat を完全にキャッシュする
            $fullpath = strtr($fullpath, [DIRECTORY_SEPARATOR => '/']);
            return $this->stats[$fullpath] ??= (function ($fullpath) {
                $stat = @stat($fullpath);
                if ($stat === false) {
                    return [];
                }
                // array モードで邪魔なので数値は伏せる
                $stat = array_filter($stat, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                // ディレクトリのサイズ（ブロックサイズ）が得られることがあるが無視して強制0とする
                if ($stat['mode'] & 0040_000) {
                    $stat['size'] = 0;
                }
                return $stat;
            })($fullpath);
        }

        private function format(string $mode, null|int|float $var): ?string
        {
            if ($var === null) {
                return null;
            }
            if ($this->options['human-readable']) {
                switch ($mode) {
                    case 'int':
                        return number_format($var);
                    case 'float':
                        return number_format($var, 3);
                    case 'byte':
                        return si_prefix($var, 1024, '%.1f %sbytes');
                    case 'time':
                        return date('Y/m/d H:i:s', $var);
                    case 'mode':
                        return strmode($var);
                    case 'owner':
                        return function_exists('posix_getpwuid') ? posix_getpwuid($var)['name'] : $var;
                    case 'group':
                        return function_exists('posix_getgrgid') ? posix_getgrgid($var)['name'] : $var;
                }
            }
            else {
                switch ($mode) {
                    default:
                        return $var;
                    case 'byte':
                        return "$var byte";
                    case 'time':
                        return date('Ymd\THis', $var);
                    case 'mode':
                        return str_pad(decoct($var), 7, '0', STR_PAD_LEFT);
                }
            }
        }
    };

    return $rsyncer($src, $dst);
}
