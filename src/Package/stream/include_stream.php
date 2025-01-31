<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * file スキームを上書きして include/require をフックできるストリームオブジェクトを返す
 *
 * register で include/require しようとしている $filename が渡ってくる callable を登録する。
 * restore で登録を解除する。
 *
 * stream wrapper にはスタッキングや取得系関数がないため、この関数を使うと file:// の登録は全て解除されるので注意。
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @return \IncludeStream|object stream wrapper オブジェクト
 */
function include_stream()
{
    static $declareProtocol;
    /**
     * file スキームで STREAM_OPEN_FOR_INCLUDE だけを特別扱いしたプロトコル
     *
     * include/require で呼ばれるメソッドはたかが知れているが、その前後等で通常操作がある可能性があるため、結局全部の実装が必要。
     */
    $declareProtocol ??= new class() {
        /** @var int https://github.com/php/php-src/blob/php-7.2.11/main/php_streams.h#L528-L529 */
        private const STREAM_OPEN_FOR_INCLUDE = 0x00000080;

        private static $hooks = [];

        private $handle;

        private $position;
        private $contents;
        private $stat;

        public $context;

        #<editor-fold desc="directory">

        public function dir_opendir($path, $options)
        {
            assert(isset($options)); // @todo It is used?
            return !!$this->handle = $this->call_original(fn() => opendir($path, ...$this->context ? [$this->context] : []));
        }

        public function dir_readdir()
        {
            return $this->call_original(fn() => readdir($this->handle));
        }

        public function dir_rewinddir()
        {
            return $this->call_original(fn() => rewinddir($this->handle));
        }

        public function dir_closedir()
        {
            return $this->call_original(fn() => closedir($this->handle));
        }

        #</editor-fold>

        #<editor-fold desc="stream">

        public function stream_open($path, $mode, $options, &$opened_path)
        {
            $use_path = $options & STREAM_USE_PATH;
            $report_errors = $options & STREAM_REPORT_ERRORS;
            $open_for_include = $options & self::STREAM_OPEN_FOR_INCLUDE;

            if ($open_for_include) {
                if (!$this->call_original(function ($hook) use ($path) {
                    $contents = $hook($path) ?? @file_get_contents($path);
                    if (!is_string($contents)) {
                        return false;
                    }
                    $this->position = 0;
                    $this->contents = $contents;
                    $this->stat = stat($path);
                    $this->stat[7] = $this->stat['size'] = strlen($this->contents);
                    return true;
                })) {
                    return false;
                }
                if ($use_path) {
                    $opened_path = stream_resolve_include_path($path); // @codeCoverageIgnore
                }
                return true;
            }

            $this->handle = $this->call_original(function ($hook) use ($path, $mode, $use_path, $report_errors) {
                if ($report_errors) {
                    return fopen($path, $mode, $use_path, $this->context); // @codeCoverageIgnore
                }
                else {
                    return @fopen($path, $mode, $use_path, $this->context);
                }
            });
            if ($use_path && $this->handle) {
                $opened_path = stream_get_meta_data($this->handle)['uri']; // @codeCoverageIgnore
            }
            return !!$this->handle;
        }

        public function stream_lock($operation)
        {
            assert($this->handle, 'never call this method');
            // file_put_contents (LOCK_EX) を呼ぶと 0 で来ることがある
            if ($operation === 0) {
                return true;
            }
            return flock($this->handle, $operation);
        }

        public function stream_tell()
        {
            assert($this->handle, 'never call this method');
            return $this->call_original(fn() => ftell($this->handle));
        }

        public function stream_seek(int $offset, int $whence = SEEK_SET)
        {
            assert($this->handle, 'never call this method');
            return $this->call_original(fn() => fseek($this->handle, $offset, $whence)) === 0;
        }

        public function stream_eof()
        {
            if (!$this->handle) {
                return $this->position >= $this->stat['size'];
            }
            return feof($this->handle);
        }

        public function stream_read($count)
        {
            if (!$this->handle) {
                $buffer = substr($this->contents, $this->position, $count);
                $this->position += $count;
                return $buffer;
            }
            return fread($this->handle, $count);
        }

        public function stream_write(string $data)
        {
            assert($this->handle, 'never call this method');
            return $this->call_original(fn() => fwrite($this->handle, $data));
        }

        public function stream_truncate(int $new_size): bool
        {
            assert($this->handle, 'never call this method');
            return $this->call_original(fn() => ftruncate($this->handle, $new_size));
        }

        public function stream_flush(): bool
        {
            assert($this->handle, 'never call this method');
            return $this->call_original(fn() => fflush($this->handle));
        }

        public function stream_close()
        {
            if (!$this->handle) {
                return true;
            }
            return fclose($this->handle);
        }

        public function stream_stat()
        {
            if (!$this->handle) {
                return $this->stat;
            }
            return fstat($this->handle);
        }

        public function stream_set_option($option, $arg1, $arg2)
        {
            if (!$this->handle) {
                return true;
            }

            // Windows の file スキームでは呼ばれない？（確かにブロッキングやタイムアウトは無縁そう）
            // @codeCoverageIgnoreStart
            return match ($option) {
                default                    => throw new \Exception(),
                STREAM_OPTION_BLOCKING     => stream_set_blocking($this->handle, $arg1),
                STREAM_OPTION_READ_TIMEOUT => stream_set_timeout($this->handle, $arg1, $arg2),
                STREAM_OPTION_READ_BUFFER  => stream_set_read_buffer($this->handle, $arg2) === 0,  // @todo $arg1 is used?
                STREAM_OPTION_WRITE_BUFFER => stream_set_write_buffer($this->handle, $arg2) === 0, // @todo $arg1 is used?
            };
            // @codeCoverageIgnoreEnd
        }

        public function stream_cast(int $cast_as)
        {
            assert(is_int($cast_as));
            return $this->handle;
        }

        #</editor-fold>

        #<editor-fold desc="url">

        public function stream_metadata($path, $option, $value)
        {
            return $this->call_original(function () use ($path, $option, $value) {
                return match ($option) {
                    default            => throw new \Exception(),
                    STREAM_META_TOUCH  => touch($path, ...$value),
                    STREAM_META_ACCESS => chmod($path, $value),
                    STREAM_META_OWNER_NAME,
                    STREAM_META_OWNER  => chown($path, $value),
                    STREAM_META_GROUP_NAME,
                    STREAM_META_GROUP  => chgrp($path, $value),
                };
            });
        }

        public function url_stat($path, $flags)
        {
            return $this->call_original(function () use ($path, $flags) {
                if ($flags & STREAM_URL_STAT_LINK) {
                    $func = 'lstat';
                }
                else {
                    $func = 'stat';
                }
                if ($flags & STREAM_URL_STAT_QUIET) {
                    return @$func($path);
                }
                else {
                    return $func($path);
                }
            });
        }

        public function mkdir(string $path, int $mode, int $options)
        {
            return $this->call_original(fn() => mkdir($path, $mode, !!($options & STREAM_MKDIR_RECURSIVE), $this->context));
        }

        public function rmdir(string $path, int $options)
        {
            assert(isset($options)); // @todo It is used?
            return $this->call_original(fn() => rmdir($path, $this->context));
        }

        public function rename(string $path_from, string $path_to)
        {
            return $this->call_original(fn() => rename($path_from, $path_to, $this->context));
        }

        public function unlink(string $path)
        {
            return $this->call_original(fn() => unlink($path, $this->context));
        }

        #</editor-fold>

        public function register($hook)
        {
            stream_wrapper_unregister('file');
            stream_wrapper_register('file', get_class($this));
            self::$hooks[] = $hook;
            return $this;
        }

        public function restore()
        {
            stream_wrapper_unregister('file');
            stream_wrapper_restore('file');
            return array_pop(self::$hooks);
        }

        private function call_original($function)
        {
            $current = $this->restore();
            try {
                return $function($current);
            }
            finally {
                $this->register($current);
            }
        }
    };

    return $declareProtocol;
}
