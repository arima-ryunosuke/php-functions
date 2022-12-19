<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectH
{
    /** @see \hash() */
    public self $hash;
    public function hash(string $algo, string $data, bool $binary = false): self { }
    public function hash(string $data, bool $binary = false): self { }

    /** @see \hash_file() */
    public self $hash_file;
    public function hash_file(string $algo, string $filename, bool $binary = false): self { }
    public function hash_file(string $filename, bool $binary = false): self { }

    /** @see \hash_hmac() */
    public self $hash_hmac;
    public function hash_hmac(string $algo, string $data, string $key, bool $binary = false): self { }
    public function hash_hmac(string $data, string $key, bool $binary = false): self { }

    /** @see \hash_hmac_file() */
    public self $hash_hmac_file;
    public function hash_hmac_file(string $algo, string $filename, string $key, bool $binary = false): self { }
    public function hash_hmac_file(string $filename, string $key, bool $binary = false): self { }

    /** @see \hash_init() */
    public self $hash_init;
    public function hash_init(string $algo, int $flags = 0, string $key = ""): self { }
    public function hash_init(int $flags = 0, string $key = ""): self { }

    /** @see \hash_update() */
    public self $hash_update;
    public function hash_update(\HashContext $context, string $data): self { }
    public function hash_update(string $data): self { }

    /** @see \hash_update_stream() */
    public self $hash_update_stream;
    public function hash_update_stream(\HashContext $context, $stream, int $length = -1): self { }
    public function hash_update_stream($stream, int $length = -1): self { }

    /** @see \hash_update_file() */
    public self $hash_update_file;
    public function hash_update_file(\HashContext $context, string $filename, $stream_context = null): self { }
    public function hash_update_file(string $filename, $stream_context = null): self { }

    /** @see \hash_final() */
    public self $hash_final;
    public function hash_final(\HashContext $context, bool $binary = false): self { }
    public function hash_final(bool $binary = false): self { }

    /** @see \hash_copy() */
    public self $hash_copy;
    public function hash_copy(\HashContext $context): self { }
    public function hash_copy(): self { }

    /** @see \hash_pbkdf2() */
    public self $hash_pbkdf2;
    public function hash_pbkdf2(string $algo, string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }
    public function hash_pbkdf2(string $password, string $salt, int $iterations, int $length = 0, bool $binary = false): self { }

    /** @see \hash_equals() */
    public self $hash_equals;
    public function hash_equals(string $known_string, string $user_string): self { }
    public function hash_equals(string $user_string): self { }

    /** @see \hash_hkdf() */
    public self $hash_hkdf;
    public function hash_hkdf(string $algo, string $key, int $length = 0, string $info = "", string $salt = ""): self { }
    public function hash_hkdf(string $key, int $length = 0, string $info = "", string $salt = ""): self { }

    /** @see \header_register_callback() */
    public self $header_register_callback;
    public function header_register_callback(callable $callback): self { }
    public function header_register_callback(): self { }

    /** @see \highlight_file() */
    public self $highlight_file;
    public function highlight_file(string $filename, bool $return = false): self { }
    public function highlight_file(bool $return = false): self { }

    /** @see \highlight_string() */
    public self $highlight_string;
    public function highlight_string(string $string, bool $return = false): self { }
    public function highlight_string(bool $return = false): self { }

    /** @see \hrtime() */
    public self $hrtime;
    public function hrtime(bool $as_number = false): self { }
    public function hrtime(): self { }

    /** @see \header() */
    public self $header;
    public function header(string $header, bool $replace = true, int $response_code = 0): self { }
    public function header(bool $replace = true, int $response_code = 0): self { }

    /** @see \header_remove() */
    public self $header_remove;
    public function header_remove(?string $name = null): self { }
    public function header_remove(): self { }

    /** @see \http_response_code() */
    public self $http_response_code;
    public function http_response_code(int $response_code = 0): self { }
    public function http_response_code(): self { }

    /** @see \htmlspecialchars() */
    public self $htmlspecialchars;
    public function htmlspecialchars(string $string, int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlspecialchars(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }

    /** @see \htmlspecialchars_decode() */
    public self $htmlspecialchars_decode;
    public function htmlspecialchars_decode(string $string, int $flags = ENT_COMPAT): self { }
    public function htmlspecialchars_decode(int $flags = ENT_COMPAT): self { }

    /** @see \html_entity_decode() */
    public self $html_entity_decode;
    public function html_entity_decode(string $string, int $flags = ENT_COMPAT, ?string $encoding = null): self { }
    public function html_entity_decode(int $flags = ENT_COMPAT, ?string $encoding = null): self { }

    /** @see \htmlentities() */
    public self $htmlentities;
    public function htmlentities(string $string, int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlentities(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }

    /** @see \hex2bin() */
    public self $hex2bin;
    public function hex2bin(string $string): self { }
    public function hex2bin(): self { }

    /** @see \hebrev() */
    public self $hebrev;
    public function hebrev(string $string, int $max_chars_per_line = 0): self { }
    public function hebrev(int $max_chars_per_line = 0): self { }

    /** @see \http_build_query() */
    public self $http_build_query;
    public function http_build_query(object|array $data, string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query(string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }

    /** @see \hypot() */
    public self $hypot;
    public function hypot(float $x, float $y): self { }
    public function hypot(float $y): self { }

    /** @see \hexdec() */
    public self $hexdec;
    public function hexdec(string $hex_string): self { }
    public function hexdec(): self { }

    /** @see \http_requests() */
    public self $http_requests;
    public function http_requests($urls, $single_options = [], $multi_options = [], &$infos = []): self { }
    public function http_requests($single_options = [], $multi_options = [], &$infos = []): self { }

    /** @see \http_request() */
    public self $http_request;
    public function http_request($options = [], &$response_header = [], &$info = []): self { }
    public function http_request(&$response_header = [], &$info = []): self { }

    /** @see \http_head() */
    public self $http_head;
    public function http_head($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_head($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \http_get() */
    public self $http_get;
    public function http_get($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_get($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \http_post() */
    public self $http_post;
    public function http_post($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_post($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \http_put() */
    public self $http_put;
    public function http_put($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_put($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \http_patch() */
    public self $http_patch;
    public function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_patch($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \http_delete() */
    public self $http_delete;
    public function http_delete($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_delete($data = [], $options = [], &$response_header = [], &$info = []): self { }

    /** @see \html_strip() */
    public self $html_strip;
    public function html_strip($html, $options = []): self { }
    public function html_strip($options = []): self { }

    /** @see \html_attr() */
    public self $html_attr;
    public function html_attr(iterable $array, $options = []): self { }
    public function html_attr($options = []): self { }

    /** @see \htmltag() */
    public self $htmltag;
    public function htmltag($selector): self { }
    public function htmltag(): self { }

    /** @see \highlight_php() */
    public self $highlight_php;
    public function highlight_php($phpcode, $options = []): self { }
    public function highlight_php($options = []): self { }

    /** @see \hashvar() */
    public self $hashvar;
    public function hashvar(...$vars): self { }
    public function hashvar(): self { }

}
