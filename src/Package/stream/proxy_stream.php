<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../url/uri_parse.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * ストリームをプロキシするストリームを構築する
 *
 * 例えば AWS 謹製の s3:// は「元となった S3Client」か「context で渡された S3Client」でしか指定できず、スキームも s3:// 固定になる。
 * 例えば phpseclib の sftp:// は元となる SFTP は不要だが「指定 URL」か「context で渡された SFTP」でしか指定できず、スキームも sftp:// 固定になる。
 * この時、この関数を通せばその時渡ってきた URL を元に好きに書き換えることができる。
 * ただし、対象ストリームが「$context で何かを受け取るストリーム」でないとほとんど意味はない（上記で言う S3Client, SFTP 等）。
 * 言うなれば「動的なストリームラッパー」として動作する。
 *
 * 例えば下記を異なる S3Client で動作させられるようになる。
 *
 * - file_put_contents('proxy://s3://hoge-bucket/path/to/object')
 * - file_put_contents('proxy://s3://fuga-bucket/path/to/object')
 *
 * 標準だと実はこれがあまり簡単ではない。
 * S3Client の使い分けが必要なので、StreamWrapper 登録だと下記のように（使うかも分からないのに）その瞬間 Client が必要になるし、スキームも別になる。
 *
 * - \Aws\S3\StreamWrapper::register($hogeS3Client, 's3-hoge')
 * - \Aws\S3\StreamWrapper::register($fugaS3Client, 's3-fuga')
 *
 * あるいは都度コンテキストを渡せば実現可能だが、使うたびに「このバケットはこのクライアントで…」等と意識したくないし、渡し忘れも多発する。
 *
 * - file_put_contents('s3://hoge-bucket/path/to/object', $hogeContext)
 * - file_put_contents('s3://fuga-bucket/path/to/object', $fugaContext)
 *
 * これを「動的なストリームラッパー」として扱って、クロージャ内で一元管理できるようになる、というのがこの関数の趣旨。
 * さらに別に S3 以外も混ぜてもよいので、ストリームラッパーを用いた「本当の意味での抽象化」がしやすくなる。
 *
 * また、stream wrapper は stat 系でコンテキストが渡らないので、
 *
 * - file_exists("sftp://host/path/to/file")
 * - file_exists("s3://bucket/path/to/object")
 *
 * これらは基本的に動作しない（コンテキストが渡せないので、前者は本当に指定 URL になるし、後者は最初に登録した S3Client になる）。
 * これをこの関数を使って
 *
 * - file_exists("proxy://sftp://host/path/to/file")
 * - file_exists("proxy://s3://bucket/path/to/object")
 *
 * このようにするだけで動作するようになる。
 *
 * 特に S3 はその気になれば
 *
 * - file_exists("proxy://s3://key:secret@endpoint/bucket/path/to/object")
 *
 * このような sftp と同様に「完全指定 URL で動作」させることも可能になる（まぁこんなことはしないだろうが…）。
 *
 * Example:
 * ```php
 * # このように登録し・・・
 * proxy_stream(function ($url, $context) {
 *     $scheme = parse_url($url, PHP_URL_SCHEME);
 *     if ($scheme === 's3') {
 *         // $url の情報に基づいて S3Client を使い分け
 *         stream_context_set_option($context, 's3', 'client', $s3);
 *         // 同じく $url の情報に基づいて bucket や key は好きに返せばよい
 *         return "s3://bucket-name/path/to/object";
 *     }
 *     if ($scheme === 'sftp') {
 *         // $url の情報に基づいて SFTP を使い分け
 *         stream_context_set_option($context, 'sftp', 'sftp', $sftp);
 *         // 同じく $url の情報に基づいて host や path は好きに返せばよい
 *         return "sftp://host:port/path/to/file";
 *     }
 * });
 *
 * # このようにアクセスすればプロキシされる
 * // echo file_get_contets('proxy://s3://dummy/path/to/target');
 * // echo file_get_contets('proxy://sftp://dummy/path/to/target');
 * ```
 *
 * @package ryunosuke\Functions\Package\stream
 */
function proxy_stream(
    callable $proxy,
    bool     $throw = true,
    bool     $prepend = false,
) {
    static $wrapper = null;
    $wrapper ??= new class() {
        public static string $protocol;
        public static array  $proxies = [];

        public $resource; // stream_get_meta_data で抜けるように public にしてある
        public $context;

        private static function url(string $url, &$context)
        {
            $url = preg_replace('#^' . preg_quote(self::$protocol) . ':///?#', '', strtr($url, ['\\' => '/']));
            $context ??= stream_context_create();

            foreach (self::$proxies as $proxy) {
                $result = $proxy($url, $context);
                if ($result !== null) {
                    return $result;
                }
            }
            throw new \DomainException("invalid proxy for $url");
        }

        private function defaultContext(string $url)
        {
            $scheme = parse_url($url, PHP_URL_SCHEME);
            if ($scheme === false) {
                return fn() => null; // @codeCoverageIgnore
            }

            // stat や touch に $context 引数が無いので委譲ができず、仕方がないので default context に詰めて無理やり渡してるが注意点がある
            // - そのスキームだけの変更に留めなければならない
            // - 対象カスタムストリームが stream_context_get_default を見ているという前提が必要
            $default = stream_context_get_options(stream_context_get_default());
            $context = stream_context_get_options($this->context);
            $changed = $default;
            $changed[$scheme] = ($context[$scheme] ?? []) + ($default[$scheme] ?? []);

            stream_context_set_default($changed);
            return fn() => stream_context_set_default($default);
        }

        #<editor-fold desc="stream">

        public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
        {
            $url = self::url($path, $this->context);
            $parts = uri_parse($url);

            // S3 のようなディレクトリの概念が無いプロトコルに合わせるために自動ディレクトリ作成機能を備える
            if (strlen($parts['scheme'])) {
                $context_options = stream_context_get_options($this->context);
                if (($context_options[$parts['scheme']]['directoryMode'] ?? null) !== null) {
                    if (!str_contains($mode, 'r')) {
                        // この辺で $this->context は不要。is_dir が context 対応していないし、$path を元にしてるので暗黙的にオリジナルのスキームで呼ばれている
                        if (!is_dir($dirname = dirname($path))) {
                            mkdir($dirname, $context_options[$parts['scheme']]['directoryMode'], true);
                        }
                    }
                }
            }

            $use_include_path = $options & STREAM_USE_PATH;
            $report_errors = $options & STREAM_REPORT_ERRORS;

            $resource = fopen($url, $mode, $use_include_path, $this->context);
            if ($resource === false) {
                if ($report_errors) {
                    trigger_error("failed to open stream: $url", E_USER_WARNING); // @codeCoverageIgnore
                }
                return false;
            }

            if ($use_include_path) {
                $opened_path = $url;
            }

            $this->resource = $resource;
            return true;
        }

        public function stream_close(): bool
        {
            return fclose($this->resource);
        }

        public function stream_lock(int $operation): bool
        {
            return flock($this->resource, $operation);
        }

        public function stream_flush(): bool
        {
            return fflush($this->resource);
        }

        public function stream_eof(): bool
        {
            return feof($this->resource);
        }

        public function stream_read(int $count): string|false
        {
            return fread($this->resource, $count);
        }

        public function stream_write(string $data): int|false
        {
            return fwrite($this->resource, $data);
        }

        public function stream_truncate(int $new_size): bool
        {
            return ftruncate($this->resource, $new_size);
        }

        public function stream_tell(): int|false
        {
            return ftell($this->resource);
        }

        public function stream_seek(int $offset, int $whence): bool
        {
            return fseek($this->resource, $offset, $whence) === 0; // fseek は C が剥き出しで成功時に 0 を返す
        }

        public function stream_stat(): array|false
        {
            return fstat($this->resource);
        }

        public function stream_cast(int $cast_as)
        {
            if ($cast_as === STREAM_CAST_AS_STREAM) {
                return false;
            }
            return $this->resource;
        }

        public function stream_set_option(int $option, ?int $arg1, ?int $arg2): bool
        {
            return match ($option) {
                STREAM_OPTION_BLOCKING     => stream_set_blocking($this->resource, $arg1),
                STREAM_OPTION_READ_TIMEOUT => stream_set_timeout($this->resource, $arg1, $arg2),
                STREAM_OPTION_READ_BUFFER  => stream_set_read_buffer($this->resource, $arg2) === 0,  // C が剥き出しで成功時に 0 を返す
                STREAM_OPTION_WRITE_BUFFER => stream_set_write_buffer($this->resource, $arg2) === 0, // C が剥き出しで成功時に 0 を返す
            };
        }

        #</editor-fold>

        #<editor-fold desc="url">

        public function stream_metadata(string $path, int $option, mixed $var)
        {
            // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
            clearstatcache(true, $path);

            $url = self::url($path, $this->context);
            $default = $this->defaultContext($url);
            try {
                return match ($option) {
                    STREAM_META_TOUCH  => touch($url),
                    STREAM_META_ACCESS => chmod($url, $var & ~umask()),
                    STREAM_META_OWNER_NAME,
                    STREAM_META_OWNER  => chown($url, $var),
                    STREAM_META_GROUP_NAME,
                    STREAM_META_GROUP  => chgrp($url, $var),
                };
            }
            finally {
                $default();
            }
        }

        public function url_stat(string $path, int $flags): array|false
        {
            $url = self::url($path, $this->context);
            $default = $this->defaultContext($url);
            try {
                $fn = $flags & STREAM_URL_STAT_LINK ? 'lstat' : 'stat';
                if ($flags & STREAM_URL_STAT_QUIET) {
                    return @$fn($url);
                }
                else {
                    return $fn($url);
                }
            }
            finally {
                $default();
            }
        }

        public function rename(string $path_from, string $path_to): bool
        {
            return rename(self::url($path_from, $this->context), self::url($path_to, $this->context), $this->context);
        }

        public function unlink(string $path): bool
        {
            return unlink(self::url($path, $this->context), $this->context);
        }

        #</editor-fold>

        #<editor-fold desc="directory">

        public function mkdir($path, $mode, $options): bool
        {
            return mkdir(self::url($path, $this->context), $mode, $options & STREAM_MKDIR_RECURSIVE, $this->context);
        }

        public function rmdir($path, $options)
        {
            return rmdir(self::url($path, $this->context), $this->context);
        }

        public function dir_opendir(string $path, int $options)
        {
            return !!($this->resource = opendir(self::url($path, $this->context), $this->context));
        }

        public function dir_readdir()
        {
            return readdir($this->resource);
        }

        public function dir_rewinddir()
        {
            rewinddir($this->resource);
        }

        public function dir_closedir()
        {
            closedir($this->resource);
        }

        #</editor-fold>
    };

    $STREAM_NAME = function_configure('proxy_stream');
    if (!in_array($STREAM_NAME, stream_get_wrappers())) {
        if (!stream_wrapper_register($STREAM_NAME, get_class($wrapper)) && $throw) {
            throw new \RuntimeException("stream_wrapper_register failed, $STREAM_NAME is already defined"); // @codeCoverageIgnore
        }
    }

    $wrapper::$protocol = $STREAM_NAME;
    if ($prepend) {
        $wrapper::$proxies = [$proxy, ...$wrapper::$proxies];
    }
    else {
        $wrapper::$proxies = [...$wrapper::$proxies, $proxy];
    }
}
