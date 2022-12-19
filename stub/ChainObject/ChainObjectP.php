<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectP
{
    /** @see \preg_match() */
    public self $preg_match;
    public function preg_match(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }

    /** @see \preg_match_all() */
    public self $preg_match_all;
    public function preg_match_all(string $pattern, string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }
    public function preg_match_all(string $subject, &$matches = null, int $flags = 0, int $offset = 0): self { }

    /** @see \preg_replace() */
    public self $preg_replace;
    public function preg_replace(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_replace(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see \preg_filter() */
    public self $preg_filter;
    public function preg_filter(array|string $pattern, array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }
    public function preg_filter(array|string $replacement, array|string $subject, int $limit = -1, &$count = null): self { }

    /** @see \preg_replace_callback() */
    public self $preg_replace_callback;
    public function preg_replace_callback(array|string $pattern, callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback(callable $callback, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }

    /** @see \preg_replace_callback_array() */
    public self $preg_replace_callback_array;
    public function preg_replace_callback_array(array $pattern, array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }
    public function preg_replace_callback_array(array|string $subject, int $limit = -1, &$count = null, int $flags = 0): self { }

    /** @see \preg_split() */
    public self $preg_split;
    public function preg_split(string $pattern, string $subject, int $limit = -1, int $flags = 0): self { }
    public function preg_split(string $subject, int $limit = -1, int $flags = 0): self { }

    /** @see \preg_quote() */
    public self $preg_quote;
    public function preg_quote(string $str, ?string $delimiter = null): self { }
    public function preg_quote(?string $delimiter = null): self { }

    /** @see \preg_grep() */
    public self $preg_grep;
    public function preg_grep(string $pattern, array $array, int $flags = 0): self { }
    public function preg_grep(array $array, int $flags = 0): self { }

    /** @see \pos() */
    public self $pos;
    public function pos(object|array $array): self { }
    public function pos(): self { }

    /** @see \putenv() */
    public self $putenv;
    public function putenv(string $assignment): self { }
    public function putenv(): self { }

    /** @see \php_strip_whitespace() */
    public self $php_strip_whitespace;
    public function php_strip_whitespace(string $filename): self { }
    public function php_strip_whitespace(): self { }

    /** @see \print_r() */
    public self $print_r;
    public function print_r(mixed $value, bool $return = false): self { }
    public function print_r(bool $return = false): self { }

    /** @see \parse_ini_file() */
    public self $parse_ini_file;
    public function parse_ini_file(string $filename, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_file(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }

    /** @see \parse_ini_string() */
    public self $parse_ini_string;
    public function parse_ini_string(string $ini_string, bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }
    public function parse_ini_string(bool $process_sections = false, int $scanner_mode = INI_SCANNER_NORMAL): self { }

    /** @see \pathinfo() */
    public self $pathinfo;
    public function pathinfo(string $path, int $flags = PATHINFO_ALL): self { }
    public function pathinfo(int $flags = PATHINFO_ALL): self { }

    /** @see \parse_str() */
    public self $parse_str;
    public function parse_str(string $string, &$result): self { }
    public function parse_str(&$result): self { }

    /** @see \passthru() */
    public self $passthru;
    public function passthru(string $command, &$result_code = null): self { }
    public function passthru(&$result_code = null): self { }

    /** @see \pclose() */
    public self $pclose;
    public function pclose($handle): self { }
    public function pclose(): self { }

    /** @see \popen() */
    public self $popen;
    public function popen(string $command, string $mode): self { }
    public function popen(string $mode): self { }

    /** @see \printf() */
    public self $printf;
    public function printf(string $format, mixed ...$values): self { }
    public function printf(mixed ...$values): self { }

    /** @see \pfsockopen() */
    public self $pfsockopen;
    public function pfsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function pfsockopen(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }

    /** @see \phpinfo() */
    public self $phpinfo;
    public function phpinfo(int $flags = INFO_ALL): self { }
    public function phpinfo(): self { }

    /** @see \phpversion() */
    public self $phpversion;
    public function phpversion(?string $extension = null): self { }
    public function phpversion(): self { }

    /** @see \phpcredits() */
    public self $phpcredits;
    public function phpcredits(int $flags = CREDITS_ALL): self { }
    public function phpcredits(): self { }

    /** @see \php_uname() */
    public self $php_uname;
    public function php_uname(string $mode = "a"): self { }
    public function php_uname(): self { }

    /** @see \pow() */
    public self $pow;
    public function pow(mixed $num, mixed $exponent): self { }
    public function pow(mixed $exponent): self { }

    /** @see \pack() */
    public self $pack;
    public function pack(string $format, mixed ...$values): self { }
    public function pack(mixed ...$values): self { }

    /** @see \password_get_info() */
    public self $password_get_info;
    public function password_get_info(string $hash): self { }
    public function password_get_info(): self { }

    /** @see \password_hash() */
    public self $password_hash;
    public function password_hash(string $password, string|int|null $algo, array $options = []): self { }
    public function password_hash(string|int|null $algo, array $options = []): self { }

    /** @see \password_needs_rehash() */
    public self $password_needs_rehash;
    public function password_needs_rehash(string $hash, string|int|null $algo, array $options = []): self { }
    public function password_needs_rehash(string|int|null $algo, array $options = []): self { }

    /** @see \password_verify() */
    public self $password_verify;
    public function password_verify(string $password, string $hash): self { }
    public function password_verify(string $hash): self { }

    /** @see \parse_url() */
    public self $parse_url;
    public function parse_url(string $url, int $component = -1): self { }
    public function parse_url(int $component = -1): self { }

    /** @see \prev_key() */
    public self $prev_key;
    public function prev_key(iterable $array, $key): self { }
    public function prev_key($key): self { }

    /** @see \path_is_absolute() */
    public self $path_is_absolute;
    public function path_is_absolute($path): self { }
    public function path_is_absolute(): self { }

    /** @see \path_resolve() */
    public self $path_resolve;
    public function path_resolve(...$paths): self { }
    public function path_resolve(): self { }

    /** @see \path_relative() */
    public self $path_relative;
    public function path_relative($from, $to): self { }
    public function path_relative($to): self { }

    /** @see \path_normalize() */
    public self $path_normalize;
    public function path_normalize($path): self { }
    public function path_normalize(): self { }

    /** @see \path_parse() */
    public self $path_parse;
    public function path_parse($path): self { }
    public function path_parse(): self { }

    /** @see \parameter_length() */
    public self $parameter_length;
    public function parameter_length(callable $callable, $require_only = false, $thought_variadic = false): self { }
    public function parameter_length($require_only = false, $thought_variadic = false): self { }

    /** @see \parameter_default() */
    public self $parameter_default;
    public function parameter_default(callable $callable, $arguments = []): self { }
    public function parameter_default($arguments = []): self { }

    /** @see \parameter_wiring() */
    public self $parameter_wiring;
    public function parameter_wiring(callable $callable, $dependency): self { }
    public function parameter_wiring($dependency): self { }

    /** @see \probability() */
    public self $probability;
    public function probability($probability, $divisor = 100): self { }
    public function probability($divisor = 100): self { }

    /** @see \ping() */
    public self $ping;
    public function ping($host, $port = null, $timeout = 1, &$errstr = ""): self { }
    public function ping($port = null, $timeout = 1, &$errstr = ""): self { }

    /** @see \pascal_case() */
    public self $pascal_case;
    public function pascal_case($string, $delimiter = "_"): self { }
    public function pascal_case($delimiter = "_"): self { }

    /** @see \parse_uri() */
    public self $parse_uri;
    public function parse_uri($uri, $default = []): self { }
    public function parse_uri($default = []): self { }

    /** @see \parse_query() */
    public self $parse_query;
    public function parse_query($query): self { }
    public function parse_query(): self { }

    /** @see \paml_export() */
    public self $paml_export;
    public function paml_export(iterable $pamlarray, $options = []): self { }
    public function paml_export($options = []): self { }

    /** @see \paml_import() */
    public self $paml_import;
    public function paml_import($pamlstring, $options = []): self { }
    public function paml_import($options = []): self { }

    /** @see \preg_matches() */
    public self $preg_matches;
    public function preg_matches($pattern, $subject, $flags = 0, $offset = 0): self { }
    public function preg_matches($subject, $flags = 0, $offset = 0): self { }

    /** @see \preg_capture() */
    public self $preg_capture;
    public function preg_capture($pattern, $subject, $default): self { }
    public function preg_capture($subject, $default): self { }

    /** @see \preg_splice() */
    public self $preg_splice;
    public function preg_splice($pattern, $replacement, $subject, &$matches = []): self { }
    public function preg_splice($replacement, $subject, &$matches = []): self { }

    /** @see \preg_replaces() */
    public self $preg_replaces;
    public function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null): self { }
    public function preg_replaces($replacements, $subject, $limit = -1, &$count = null): self { }

    /** @see \parse_php() */
    public self $parse_php;
    public function parse_php($phpcode, $option = []): self { }
    public function parse_php($option = []): self { }

    /** @see \parse_namespace() */
    public self $parse_namespace;
    public function parse_namespace($filename, $options = []): self { }
    public function parse_namespace($options = []): self { }

    /** @see \parse_annotation() */
    public self $parse_annotation;
    public function parse_annotation($annotation, $schema = [], $nsfiles = []): self { }
    public function parse_annotation($schema = [], $nsfiles = []): self { }

    /** @see \process() */
    public self $process;
    public function process($command, $args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null): self { }
    public function process($args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null): self { }

    /** @see \process_async() */
    public self $process_async;
    public function process_async($command, $args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null): self { }
    public function process_async($args = [], $stdin = "", &$stdout = "", &$stderr = "", $cwd = null, ?array $env = null): self { }

    /** @see \process_parallel() */
    public self $process_parallel;
    public function process_parallel($tasks, $args = [], $autoload = null, $workdir = null, $env = null): self { }
    public function process_parallel($args = [], $autoload = null, $workdir = null, $env = null): self { }

    /** @see \profiler() */
    public self $profiler;
    public function profiler($options = []): self { }
    public function profiler(): self { }

    /** @see \phpval() */
    public self $phpval;
    public function phpval($var, $contextvars = []): self { }
    public function phpval($contextvars = []): self { }

}
