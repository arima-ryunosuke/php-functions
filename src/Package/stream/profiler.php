<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 外部ツールに頼らない pure php なプロファイラを返す
 *
 * file プロトコル上書きと ticks と debug_backtrace によるかなり無理のある実装なので動かない環境・コードは多い。
 * その分お手軽だが下記の注意点がある。
 *
 * - file プロトコルを上書きするので、既に読み込み済みのファイルは計上されない
 * - tick されないステートメントは計上されない
 *     - 1行メソッドなどでありがち
 * - A->B->C という呼び出しで C が 3秒、B が 2秒、A が1秒かかった場合、 A は 6 秒、B は 5秒、C は 3 秒といて計上される
 *     - つまり、配下の呼び出しも重複して計上される
 *
 * この関数を呼んだ時点で計測は始まる。
 * 返り値としてイテレータを返すので、foreach で回せばコールスタック・回数・時間などが取得できる。
 * 配列で欲しい場合は直に呼べば良い。
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @param array $options オプション配列
 * @return \Traversable|callable プロファイライテレータ
 */
function profiler($options = [])
{
    static $declareProtocol = null;
    $declareProtocol ??= new
    /**
     * @method opendir($path, $context = null)
     * @method touch($filename, $time = null, $atime = null)
     * @method chmod($filename, $mode)
     * @method chown($filename, $user)
     * @method chgrp($filename, $group)
     * @method fopen($filename, $mode, $use_include_path = false, $context = null)
     */
    class {
        const DECLARE_TICKS = "<?php declare(ticks=1) ?>";

        /** @var int https://github.com/php/php-src/blob/php-7.2.11/main/php_streams.h#L528-L529 */
        private const STREAM_OPEN_FOR_INCLUDE = 0x00000080;

        /** @var resource https://www.php.net/manual/class.streamwrapper.php */
        public $context;

        private $require;
        private $prepend;
        private $handle;

        public function __call($name, $arguments)
        {
            $fname = preg_replace(['#^dir_#', '#^stream_#'], ['', 'f'], $name, 1, $count);
            if ($count) {
                // flock は特別扱い（file_put_contents (LOCK_EX) を呼ぶと 0 で来ることがある）
                // __call で特別扱いもおかしいけど、個別に定義するほうが逆にわかりにくい
                if ($fname === 'flock' && ($arguments[0] ?? null) === 0) {
                    return true;
                }
                return $fname($this->handle, ...$arguments);
            }

            stream_wrapper_restore('file');
            try {
                switch ($name) {
                    default:
                        // mkdir, rename, unlink, ...
                        return $name(...$arguments);
                    case 'rmdir':
                        [$path, $options] = $arguments + [1 => 0];
                        assert(isset($options)); // @todo It is used?
                        return rmdir($path, $this->context);
                    case 'url_stat':
                        [$path, $flags] = $arguments + [1 => 0];
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
                }
            }
            finally {
                stream_wrapper_unregister('file');
                stream_wrapper_register('file', get_class($this));
            }
        }

        /** @noinspection PhpUnusedParameterInspection */
        public function dir_opendir($path, $options)
        {
            return !!$this->handle = $this->opendir(...$this->context ? [$path, $this->context] : [$path]);
        }

        public function stream_open($path, $mode, $options, &$opened_path)
        {
            $this->require = $options & self::STREAM_OPEN_FOR_INCLUDE;
            $this->prepend = false;
            $use_path = $options & STREAM_USE_PATH;
            if ($options & STREAM_REPORT_ERRORS) {
                $this->handle = $this->fopen($path, $mode, $use_path); // @codeCoverageIgnore
            }
            else {
                $this->handle = @$this->fopen($path, $mode, $use_path);
            }
            if ($use_path && $this->handle) {
                $opened_path = stream_get_meta_data($this->handle)['uri']; // @codeCoverageIgnore
            }
            return !!$this->handle;
        }

        public function stream_read($count)
        {
            if (!$this->prepend && $this->require && ftell($this->handle) === 0) {
                $this->prepend = true;
                return self::DECLARE_TICKS;
            }
            return fread($this->handle, $count);
        }

        public function stream_stat()
        {
            $stat = fstat($this->handle);
            if ($this->require) {
                $decsize = strlen(self::DECLARE_TICKS);
                $stat[7] += $decsize;
                $stat['size'] += $decsize;
            }
            return $stat;
        }

        public function stream_set_option($option, $arg1, $arg2)
        {
            // Windows の file スキームでは呼ばれない？（確かにブロッキングやタイムアウトは無縁そう）
            // @codeCoverageIgnoreStart
            switch ($option) {
                default:
                    throw new \Exception();
                case STREAM_OPTION_BLOCKING:
                    return stream_set_blocking($this->handle, $arg1);
                case STREAM_OPTION_READ_TIMEOUT:
                    return stream_set_timeout($this->handle, $arg1, $arg2);
                case STREAM_OPTION_READ_BUFFER:
                    return stream_set_read_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
                case STREAM_OPTION_WRITE_BUFFER:
                    return stream_set_write_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
            }
            // @codeCoverageIgnoreEnd
        }

        public function stream_metadata($path, $option, $value)
        {
            switch ($option) {
                default:
                    throw new \Exception(); // @codeCoverageIgnore
                case STREAM_META_TOUCH:
                    return $this->touch($path, ...$value);
                case STREAM_META_ACCESS:
                    return $this->chmod($path, $value);
                case STREAM_META_OWNER_NAME:
                case STREAM_META_OWNER:
                    return $this->chown($path, $value);
                case STREAM_META_GROUP_NAME:
                case STREAM_META_GROUP:
                    return $this->chgrp($path, $value);
            }
        }

        public function stream_cast($cast_as) { /* @todo I'm not sure */ } // @codeCoverageIgnore
    };

    $profiler = new class(get_class($declareProtocol), $options) implements \IteratorAggregate {
        private $result = [];
        private $ticker;

        public function __construct($wrapper, $options = [])
        {
            $options = array_replace([
                'callee'   => null,
                'location' => null,
            ], $options);
            $last_trace = [];
            $result = &$this->result;
            $this->ticker = static function () use ($options, &$last_trace, &$result) {
                $now = microtime(true);
                $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                $last_count = count($last_trace);
                $current_count = count($traces);

                // スタック数が変わってない（=同じメソッドを処理している？）
                if ($current_count === $last_count) {
                    // dummy
                    assert($current_count === $last_count);
                }
                // スタック数が増えた（=新しいメソッドが開始された？）
                elseif ($current_count > $last_count) {
                    foreach (array_slice($traces, 1, $current_count - $last_count) as $last) {
                        $last['time'] = $now;
                        $last['callee'] = (isset($last['class'], $last['type']) ? $last['class'] . $last['type'] : '') . $last['function'];
                        $last['location'] = isset($last['file'], $last['line']) ? $last['file'] . '#' . $last['line'] : null;
                        array_unshift($last_trace, $last);
                    }
                }
                // スタック数が減った（=処理してたメソッドを抜けた？）
                elseif ($current_count < $last_count) {
                    $prev = null; // array_map などの内部関数はスタックが一気に2つ増減する
                    foreach (array_splice($last_trace, 0, $last_count - $current_count) as $last) {
                        $time = $now - $last['time'];
                        $callee = $last['callee'];
                        $location = $last['location'] ?? ($prev['file'] ?? '') . '#' . ($prev['line'] ?? '');
                        $prev = $last;

                        foreach (['callee', 'location'] as $key) {
                            $condition = $options[$key];
                            $value = $$key;
                            if ($condition !== null) {
                                if ($condition instanceof \Closure) {
                                    if (!$condition($value)) {
                                        continue 2;
                                    }
                                }
                                else {
                                    if (!preg_match($condition, $value)) {
                                        continue 2;
                                    }
                                }
                            }
                        }
                        $result[$callee][$location][] = $time;
                    }
                }
            };

            stream_wrapper_unregister('file');
            stream_wrapper_register('file', $wrapper);

            register_tick_function($this->ticker);
            opcache_reset();
        }

        public function __destruct()
        {
            unregister_tick_function($this->ticker);

            stream_wrapper_restore('file');
        }

        public function __invoke()
        {
            return $this->result;
        }

        public function getIterator(): \Traversable
        {
            return yield from $this->result;
        }
    };

    return $profiler;
}
