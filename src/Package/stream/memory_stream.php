<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * ファイルのように扱えるメモリ上のパスを返す
 *
 * 劣化 vfsStream のようなもの。
 * stream wrapper を用いて実装しており、そのプロトコルは初回呼び出し時に1度だけ登録される。
 * プロトコル名は決め打ちだが、 php.ini に "rfunc.memory_stream" というキーで文字列を指定するとそれが使用される。
 *
 * Example:
 * ```php
 * // ファイル名のように読み書きができるパスを返す（一時ファイルを使用するよりかなり高速に動作する）
 * $memory_stream = memory_stream('filename.txt');
 * // 呼んだだけでは何もしないので存在しない
 * that(file_exists($memory_stream))->isSame(false);
 * // file_put_contents が使える
 * that(file_put_contents($memory_stream, 'Hello, World'))->isSame(12);
 * // file_get_contents が使える
 * that(file_get_contents($memory_stream))->isSame('Hello, World');
 * // 上記の操作で実体が存在している
 * that(file_exists($memory_stream))->isSame(true);
 * // unlink が使える
 * that(unlink($memory_stream))->isSame(true);
 * // unlink したので存在しない
 * that(file_exists($memory_stream))->isSame(false);
 * ```
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @param string $path パス名（実質的に一意なファイル名）
 * @return string メモリ上のパス
 */
function memory_stream($path = '')
{
    static $STREAM_NAME, $registered = false;
    if (!$registered) {
        $STREAM_NAME = $STREAM_NAME ?: function_configure('memory_stream');
        if (in_array($STREAM_NAME, stream_get_wrappers())) {
            throw new \DomainException("$STREAM_NAME is registered already.");
        }

        $registered = true;
        stream_wrapper_register($STREAM_NAME, get_class(new class() {
            private static $entries = [];

            private $entry;
            private $id;
            private $position;
            private $appendable;

            public $context;

            private static function id($path)
            {
                $parts = parse_url($path) ?: [];
                $id = ($parts['host'] ?? '') . ($parts['path'] ?? '');
                $id = strtr($id, ['\\' => '/']);
                return rtrim($id, '/');
            }

            private static function create($id, $mode)
            {
                // @todo time 系は一応用意しているだけでほとんど未実装（read/write のたびに更新する？）
                $now = time();
                self::$entries[$id] = (object) [
                    'mode'    => $mode | (0777 & ~umask()),
                    'owner'   => function_exists('posix_getuid') ? posix_getuid() : 0,
                    'group'   => function_exists('posix_getgid') ? posix_getgid() : 0,
                    'atime'   => $now,
                    'mtime'   => $now,
                    'ctime'   => $now,
                    'content' => '',
                ];
            }

            private static function stat($id)
            {
                $that = self::$entries[$id];
                return [
                    'dev'     => 0,
                    'ino'     => 0,
                    'mode'    => $that->mode,
                    'nlink'   => 0,
                    'uid'     => $that->owner,
                    'gid'     => $that->group,
                    'rdev'    => 0,
                    'size'    => array_reduce((array) $that->content, fn($carry, $item) => $carry + strlen($item), 0),
                    'atime'   => $that->atime,
                    'mtime'   => $that->mtime,
                    'ctime'   => $that->ctime,
                    'blksize' => -1,
                    'blocks'  => -1,
                ];
            }

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_set_option(int $option, int $arg1, int $arg2)
            {
                return false;
            }

            public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
            {
                assert(is_int($options));
                assert(is_null($opened_path) || !strlen($opened_path));
                $this->id = self::id($path);

                // t フラグはクソなので実装しない（デフォルトで b フラグとする）
                if (strpos($mode, 'r') !== false) {
                    // 普通の fopen でファイルが存在しないとエラーになるので模倣する
                    if (!isset(self::$entries[$this->id])) {
                        throw new \InvalidArgumentException("'$path' is not exist.");
                    }
                    $this->position = 0;
                    $this->appendable = false;
                }
                elseif (strpos($mode, 'w') !== false) {
                    // ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにします。
                    // ファイルが存在しない場合には、作成を試みます。
                    self::create($this->id, 010_0000);
                    $this->position = 0;
                    $this->appendable = false;
                }
                elseif (strpos($mode, 'a') !== false) {
                    // ファイルポインタをファイルの終端に置きます。
                    // ファイルが存在しない場合には、作成を試みます。
                    if (!isset(self::$entries[$this->id])) {
                        self::create($this->id, 010_0000);
                    }
                    $this->position = 0;
                    $this->appendable = true;
                }
                elseif (strpos($mode, 'x') !== false) {
                    // ファイルポインタをファイルの先頭に置きます。
                    // ファイルが既に存在する場合には fopen() は失敗し、 E_WARNING レベルのエラーを発行します。
                    // ファイルが存在しない場合には新規作成を試みます。
                    if (isset(self::$entries[$this->id])) {
                        throw new \InvalidArgumentException("'$path' is exist already.");
                    }
                    self::create($this->id, 010_0000);
                    $this->position = 0;
                    $this->appendable = false;
                }
                elseif (strpos($mode, 'c') !== false) {
                    // ファイルが存在しない場合には新規作成を試みます。
                    // ファイルが既に存在する場合でもそれを ('w' のように) 切り詰めたりせず、 また ('x' のように) 関数のコールが失敗することもありません。
                    // ファイルポインタをファイルの先頭に置きます。
                    if (!isset(self::$entries[$this->id])) {
                        self::create($this->id, 010_0000);
                    }
                    $this->position = 0;
                    $this->appendable = false;
                }

                $this->entry = self::$entries[$this->id];

                return true;
            }

            public function stream_close()
            {
            }

            public function stream_lock(int $operation): bool
            {
                assert(is_int($operation));
                // メモリアクセスは競合しないので常に true を返す
                return true;
            }

            public function stream_flush(): bool
            {
                // バッファしないので常に true を返す
                return true;
            }

            public function stream_eof(): bool
            {
                return $this->position >= strlen($this->entry->content);
            }

            public function stream_read(int $count): string
            {
                $result = substr($this->entry->content, $this->position, $count);
                $this->position += strlen($result);
                return $result;
            }

            public function stream_write(string $data): int
            {
                $datalen = strlen($data);
                $posision = $this->position;
                // このモードは、fseek() では何の効果もありません。書き込みは、常に追記となります。
                if ($this->appendable) {
                    $posision = strlen($this->entry->content);
                }
                // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                $current = str_pad($this->entry->content, $posision, "\0", STR_PAD_RIGHT);
                $this->entry->content = substr_replace($current, $data, $posision, $datalen);
                $this->position += $datalen;
                return $datalen;
            }

            public function stream_truncate(int $new_size): bool
            {
                $current = substr($this->entry->content, 0, $new_size);
                $this->entry->content = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                return true;
            }

            public function stream_tell(): int
            {
                return $this->position;
            }

            public function stream_seek(int $offset, int $whence = SEEK_SET): bool
            {
                if ($whence === SEEK_SET && $offset < 0) {
                    return false;
                }

                $strlen = strlen($this->entry->content);
                $this->position = match ($whence) {
                    SEEK_SET => $offset,
                    SEEK_CUR => $this->position + $offset,
                    SEEK_END => $strlen + $offset,
                };
                // ファイルの終端から数えた位置に移動するには、負の値を offset に渡して whence を SEEK_END に設定しなければなりません。
                if ($this->position < 0) {
                    $this->position = $strlen + $this->position;
                    if ($this->position < 0) {
                        $this->position = 0;
                        return false;
                    }
                }
                return true;
            }

            public function stream_stat()
            {
                return self::stat($this->id);
            }

            public function stream_metadata($path, $option, $var)
            {
                $id = self::id($path);
                if (!isset(self::$entries[$id])) {
                    if ($option === STREAM_META_TOUCH) {
                        self::create($id, 010_0000);
                    }
                    else {
                        return false;
                    }
                }

                $now = time();
                $set_entry = function (...$props) use ($id) {
                    foreach ($props as $prop => $value) {
                        self::$entries[$id]->$prop = $value;
                    }
                };
                match ($option) {
                    STREAM_META_TOUCH      => $set_entry(
                        mtime: $var[0] ?? $now,
                        atime: $var[1] ?? $var[0] ?? $now,
                    ),
                    STREAM_META_ACCESS     => $set_entry(
                        mode: (self::$entries[$id]->mode & 077_0000) | $var & ~umask(),
                        ctime: $now,
                    ),
                    STREAM_META_OWNER_NAME => $set_entry(
                        owner: function_exists('posix_getpwnam') ? posix_getpwnam($var)['uid'] ?? 0 : 0,
                        ctime: $now,
                    ),
                    STREAM_META_OWNER      => $set_entry(
                        owner: $var,
                        ctime: $now,
                    ),
                    STREAM_META_GROUP_NAME => $set_entry(
                        group: function_exists('posix_getgrnam') ? posix_getgrnam($var)['gid'] ?? 0 : 0,
                        ctime: $now,
                    ),
                    STREAM_META_GROUP      => $set_entry(
                        group: $var,
                        ctime: $now,
                    ),
                };

                // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                clearstatcache(true, $path);
                return true;
            }

            public function url_stat(string $path, int $flags)
            {
                assert(is_int($flags));
                $id = self::id($path);
                if (!isset(self::$entries[$id])) {
                    return false;
                }
                return self::stat($id);
            }

            public function rename(string $path_from, string $path_to): bool
            {
                // rename は同じプロトコルじゃないと使えない制約があるのでプロトコルは見ないで OK
                $id_from = self::id($path_from);
                if (!isset(self::$entries[$id_from])) {
                    return false;
                }
                $id_to = self::id($path_to);
                self::$entries[$id_to] = self::$entries[$id_from];
                unset(self::$entries[$id_from]);
                // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                clearstatcache(true, $path_from);
                return true;
            }

            public function unlink(string $path): bool
            {
                $id = self::id($path);
                if (!isset(self::$entries[$id])) {
                    return false;
                }
                unset(self::$entries[$id]);
                // もしファイルを作成した場合、 たとえファイルを削除したとしても TRUE を返します。しかし、unlink() はキャッシュを自動的にクリアします。
                clearstatcache(true, $path);
                return true;
            }

            public function mkdir($path, $mode, $options)
            {
                $id = self::id($path);
                if (isset(self::$entries[$id])) {
                    return false;
                }
                $parts = explode('/', $id);
                if (count($parts) > 1 && !($options & STREAM_MKDIR_RECURSIVE)) {
                    if (!isset(self::$entries[implode('/', array_slice($parts, 0, -1))])) {
                        return false;
                    }
                }
                $dirpath = '';
                foreach ($parts as $part) {
                    $dirpath .= "$part/";
                    self::create(rtrim($dirpath, '/'), 004_0000 | $mode);
                }
                return true;
            }

            public function rmdir($path, $options)
            {
                assert(is_int($options));
                $id = self::id($path);
                if (!isset(self::$entries[$id])) {
                    return false;
                }
                foreach (self::$entries as $eid => $entry) {
                    if (preg_match('#^' . preg_quote("$id/", '#') . '([^/]+)$#u', $eid)) {
                        return false;
                    }
                }
                unset(self::$entries[$id]);
                clearstatcache(true, $path);
                return true;
            }

            public function dir_opendir(string $path, int $options)
            {
                assert(is_int($options));
                $id = self::id($path);
                if (!isset(self::$entries[$id])) {
                    return false;
                }

                $files = ['.', '..'];
                foreach (self::$entries as $eid => $entry) {
                    if (preg_match('#^' . preg_quote("$id/", '#') . '([^/]+)$#u', $eid, $m)) {
                        $files[] = $m[1];
                    }
                }

                $this->entry = self::$entries[$id];
                $this->entry->content = $files;
                return true;
            }

            public function dir_readdir()
            {
                $result = current($this->entry->content);
                next($this->entry->content);
                return $result;
            }

            public function dir_rewinddir()
            {
                reset($this->entry->content);
                return true;
            }

            public function dir_closedir()
            {
                unset($this->entry);
                return true;
            }
        }));
    }

    return "$STREAM_NAME://" . trim($path, '\\/');
}
