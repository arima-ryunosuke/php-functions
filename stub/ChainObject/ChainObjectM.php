<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectM
{
    /** @see \mktime() */
    public self $mktime;
    public function mktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }

    /** @see \mhash_get_block_size() */
    public self $mhash_get_block_size;
    public function mhash_get_block_size(int $algo): self { }
    public function mhash_get_block_size(): self { }

    /** @see \mhash_get_hash_name() */
    public self $mhash_get_hash_name;
    public function mhash_get_hash_name(int $algo): self { }
    public function mhash_get_hash_name(): self { }

    /** @see \mhash_keygen_s2k() */
    public self $mhash_keygen_s2k;
    public function mhash_keygen_s2k(int $algo, string $password, string $salt, int $length): self { }
    public function mhash_keygen_s2k(string $password, string $salt, int $length): self { }

    /** @see \mhash() */
    public self $mhash;
    public function mhash(int $algo, string $data, ?string $key = null): self { }
    public function mhash(string $data, ?string $key = null): self { }

    /** @see \min() */
    public self $min;
    public function min(mixed ...$values): self { }
    public function min(): self { }

    /** @see \max() */
    public self $max;
    public function max(mixed ...$values): self { }
    public function max(): self { }

    /** @see \move_uploaded_file() */
    public self $move_uploaded_file;
    public function move_uploaded_file(string $from, string $to): self { }
    public function move_uploaded_file(string $to): self { }

    /** @see \md5() */
    public self $md5;
    public function md5(string $string, bool $binary = false): self { }
    public function md5(bool $binary = false): self { }

    /** @see \md5_file() */
    public self $md5_file;
    public function md5_file(string $filename, bool $binary = false): self { }
    public function md5_file(bool $binary = false): self { }

    /** @see \metaphone() */
    public self $metaphone;
    public function metaphone(string $string, int $max_phonemes = 0): self { }
    public function metaphone(int $max_phonemes = 0): self { }

    /** @see \mkdir() */
    public self $mkdir;
    public function mkdir(string $directory, int $permissions = 511, bool $recursive = false, $context = null): self { }
    public function mkdir(int $permissions = 511, bool $recursive = false, $context = null): self { }

    /** @see \mail() */
    public self $mail;
    public function mail(string $to, string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }
    public function mail(string $subject, string $message, array|string $additional_headers = [], string $additional_params = ""): self { }

    /** @see \microtime() */
    public self $microtime;
    public function microtime(bool $as_float = false): self { }
    public function microtime(): self { }

    /** @see \mt_srand() */
    public self $mt_srand;
    public function mt_srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function mt_srand(int $mode = MT_RAND_MT19937): self { }

    /** @see \mt_rand() */
    public self $mt_rand;
    public function mt_rand(int $min, int $max): self { }
    public function mt_rand(int $max): self { }

    /** @see \memory_get_usage() */
    public self $memory_get_usage;
    public function memory_get_usage(bool $real_usage = false): self { }
    public function memory_get_usage(): self { }

    /** @see \memory_get_peak_usage() */
    public self $memory_get_peak_usage;
    public function memory_get_peak_usage(bool $real_usage = false): self { }
    public function memory_get_peak_usage(): self { }

    /** @see \mb_language() */
    public self $mb_language;
    public function mb_language(?string $language = null): self { }
    public function mb_language(): self { }

    /** @see \mb_internal_encoding() */
    public self $mb_internal_encoding;
    public function mb_internal_encoding(?string $encoding = null): self { }
    public function mb_internal_encoding(): self { }

    /** @see \mb_http_input() */
    public self $mb_http_input;
    public function mb_http_input(?string $type = null): self { }
    public function mb_http_input(): self { }

    /** @see \mb_http_output() */
    public self $mb_http_output;
    public function mb_http_output(?string $encoding = null): self { }
    public function mb_http_output(): self { }

    /** @see \mb_detect_order() */
    public self $mb_detect_order;
    public function mb_detect_order(array|string|null $encoding = null): self { }
    public function mb_detect_order(): self { }

    /** @see \mb_substitute_character() */
    public self $mb_substitute_character;
    public function mb_substitute_character(string|int|null $substitute_character = null): self { }
    public function mb_substitute_character(): self { }

    /** @see \mb_preferred_mime_name() */
    public self $mb_preferred_mime_name;
    public function mb_preferred_mime_name(string $encoding): self { }
    public function mb_preferred_mime_name(): self { }

    /** @see \mb_parse_str() */
    public self $mb_parse_str;
    public function mb_parse_str(string $string, &$result): self { }
    public function mb_parse_str(&$result): self { }

    /** @see \mb_output_handler() */
    public self $mb_output_handler;
    public function mb_output_handler(string $string, int $status): self { }
    public function mb_output_handler(int $status): self { }

    /** @see \mb_str_split() */
    public self $mb_str_split;
    public function mb_str_split(string $string, int $length = 1, ?string $encoding = null): self { }
    public function mb_str_split(int $length = 1, ?string $encoding = null): self { }

    /** @see \mb_strlen() */
    public self $mb_strlen;
    public function mb_strlen(string $string, ?string $encoding = null): self { }
    public function mb_strlen(?string $encoding = null): self { }

    /** @see \mb_strpos() */
    public self $mb_strpos;
    public function mb_strpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strpos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see \mb_strrpos() */
    public self $mb_strrpos;
    public function mb_strrpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strrpos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see \mb_stripos() */
    public self $mb_stripos;
    public function mb_stripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_stripos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see \mb_strripos() */
    public self $mb_strripos;
    public function mb_strripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strripos(string $needle, int $offset = 0, ?string $encoding = null): self { }

    /** @see \mb_strstr() */
    public self $mb_strstr;
    public function mb_strstr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strstr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see \mb_strrchr() */
    public self $mb_strrchr;
    public function mb_strrchr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrchr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see \mb_stristr() */
    public self $mb_stristr;
    public function mb_stristr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_stristr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see \mb_strrichr() */
    public self $mb_strrichr;
    public function mb_strrichr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrichr(string $needle, bool $before_needle = false, ?string $encoding = null): self { }

    /** @see \mb_substr_count() */
    public self $mb_substr_count;
    public function mb_substr_count(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_substr_count(string $needle, ?string $encoding = null): self { }

    /** @see \mb_substr() */
    public self $mb_substr;
    public function mb_substr(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_substr(int $start, ?int $length = null, ?string $encoding = null): self { }

    /** @see \mb_strcut() */
    public self $mb_strcut;
    public function mb_strcut(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_strcut(int $start, ?int $length = null, ?string $encoding = null): self { }

    /** @see \mb_strwidth() */
    public self $mb_strwidth;
    public function mb_strwidth(string $string, ?string $encoding = null): self { }
    public function mb_strwidth(?string $encoding = null): self { }

    /** @see \mb_strimwidth() */
    public self $mb_strimwidth;
    public function mb_strimwidth(string $string, int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth(int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }

    /** @see \mb_convert_encoding() */
    public self $mb_convert_encoding;
    public function mb_convert_encoding(array|string $string, string $to_encoding, array|string|null $from_encoding = null): self { }
    public function mb_convert_encoding(string $to_encoding, array|string|null $from_encoding = null): self { }

    /** @see \mb_convert_case() */
    public self $mb_convert_case;
    public function mb_convert_case(string $string, int $mode, ?string $encoding = null): self { }
    public function mb_convert_case(int $mode, ?string $encoding = null): self { }

    /** @see \mb_strtoupper() */
    public self $mb_strtoupper;
    public function mb_strtoupper(string $string, ?string $encoding = null): self { }
    public function mb_strtoupper(?string $encoding = null): self { }

    /** @see \mb_strtolower() */
    public self $mb_strtolower;
    public function mb_strtolower(string $string, ?string $encoding = null): self { }
    public function mb_strtolower(?string $encoding = null): self { }

    /** @see \mb_detect_encoding() */
    public self $mb_detect_encoding;
    public function mb_detect_encoding(string $string, array|string|null $encodings = null, bool $strict = false): self { }
    public function mb_detect_encoding(array|string|null $encodings = null, bool $strict = false): self { }

    /** @see \mb_encoding_aliases() */
    public self $mb_encoding_aliases;
    public function mb_encoding_aliases(string $encoding): self { }
    public function mb_encoding_aliases(): self { }

    /** @see \mb_encode_mimeheader() */
    public self $mb_encode_mimeheader;
    public function mb_encode_mimeheader(string $string, ?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader(?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }

    /** @see \mb_decode_mimeheader() */
    public self $mb_decode_mimeheader;
    public function mb_decode_mimeheader(string $string): self { }
    public function mb_decode_mimeheader(): self { }

    /** @see \mb_convert_kana() */
    public self $mb_convert_kana;
    public function mb_convert_kana(string $string, string $mode = "KV", ?string $encoding = null): self { }
    public function mb_convert_kana(string $mode = "KV", ?string $encoding = null): self { }

    /** @see \mb_convert_variables() */
    public self $mb_convert_variables;
    public function mb_convert_variables(string $to_encoding, array|string $from_encoding, mixed &$var, mixed &...$vars): self { }
    public function mb_convert_variables(array|string $from_encoding, mixed &$var, mixed &...$vars): self { }

    /** @see \mb_encode_numericentity() */
    public self $mb_encode_numericentity;
    public function mb_encode_numericentity(string $string, array $map, ?string $encoding = null, bool $hex = false): self { }
    public function mb_encode_numericentity(array $map, ?string $encoding = null, bool $hex = false): self { }

    /** @see \mb_decode_numericentity() */
    public self $mb_decode_numericentity;
    public function mb_decode_numericentity(string $string, array $map, ?string $encoding = null): self { }
    public function mb_decode_numericentity(array $map, ?string $encoding = null): self { }

    /** @see \mb_send_mail() */
    public self $mb_send_mail;
    public function mb_send_mail(string $to, string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail(string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }

    /** @see \mb_get_info() */
    public self $mb_get_info;
    public function mb_get_info(string $type = "all"): self { }
    public function mb_get_info(): self { }

    /** @see \mb_check_encoding() */
    public self $mb_check_encoding;
    public function mb_check_encoding(array|string|null $value = null, ?string $encoding = null): self { }
    public function mb_check_encoding(?string $encoding = null): self { }

    /** @see \mb_scrub() */
    public self $mb_scrub;
    public function mb_scrub(string $string, ?string $encoding = null): self { }
    public function mb_scrub(?string $encoding = null): self { }

    /** @see \mb_ord() */
    public self $mb_ord;
    public function mb_ord(string $string, ?string $encoding = null): self { }
    public function mb_ord(?string $encoding = null): self { }

    /** @see \mb_chr() */
    public self $mb_chr;
    public function mb_chr(int $codepoint, ?string $encoding = null): self { }
    public function mb_chr(?string $encoding = null): self { }

    /** @see \mb_regex_encoding() */
    public self $mb_regex_encoding;
    public function mb_regex_encoding(?string $encoding = null): self { }
    public function mb_regex_encoding(): self { }

    /** @see \mb_ereg() */
    public self $mb_ereg;
    public function mb_ereg(string $pattern, string $string, &$matches = null): self { }
    public function mb_ereg(string $string, &$matches = null): self { }

    /** @see \mb_eregi() */
    public self $mb_eregi;
    public function mb_eregi(string $pattern, string $string, &$matches = null): self { }
    public function mb_eregi(string $string, &$matches = null): self { }

    /** @see \mb_ereg_replace() */
    public self $mb_ereg_replace;
    public function mb_ereg_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_ereg_replace(string $replacement, string $string, ?string $options = null): self { }

    /** @see \mb_eregi_replace() */
    public self $mb_eregi_replace;
    public function mb_eregi_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_eregi_replace(string $replacement, string $string, ?string $options = null): self { }

    /** @see \mb_ereg_replace_callback() */
    public self $mb_ereg_replace_callback;
    public function mb_ereg_replace_callback(string $pattern, callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback(callable $callback, string $string, ?string $options = null): self { }

    /** @see \mb_split() */
    public self $mb_split;
    public function mb_split(string $pattern, string $string, int $limit = -1): self { }
    public function mb_split(string $string, int $limit = -1): self { }

    /** @see \mb_ereg_match() */
    public self $mb_ereg_match;
    public function mb_ereg_match(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_match(string $string, ?string $options = null): self { }

    /** @see \mb_ereg_search() */
    public self $mb_ereg_search;
    public function mb_ereg_search(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search(?string $options = null): self { }

    /** @see \mb_ereg_search_pos() */
    public self $mb_ereg_search_pos;
    public function mb_ereg_search_pos(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_pos(?string $options = null): self { }

    /** @see \mb_ereg_search_regs() */
    public self $mb_ereg_search_regs;
    public function mb_ereg_search_regs(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_regs(?string $options = null): self { }

    /** @see \mb_ereg_search_init() */
    public self $mb_ereg_search_init;
    public function mb_ereg_search_init(string $string, ?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_init(?string $pattern = null, ?string $options = null): self { }

    /** @see \mb_ereg_search_setpos() */
    public self $mb_ereg_search_setpos;
    public function mb_ereg_search_setpos(int $offset): self { }
    public function mb_ereg_search_setpos(): self { }

    /** @see \mb_regex_set_options() */
    public self $mb_regex_set_options;
    public function mb_regex_set_options(?string $options = null): self { }
    public function mb_regex_set_options(): self { }

    /** @see \mkdir_p() */
    public self $mkdir_p;
    public function mkdir_p($dirname, $umask = 2): self { }
    public function mkdir_p($umask = 2): self { }

    /** @see \memory_path() */
    public self $memory_path;
    public function memory_path($path): self { }
    public function memory_path(): self { }

    /** @see \minimum() */
    public self $minimum;
    public function minimum(...$variadic): self { }
    public function minimum(): self { }

    /** @see \maximum() */
    public self $maximum;
    public function maximum(...$variadic): self { }
    public function maximum(): self { }

    /** @see \mode() */
    public self $mode;
    public function mode(...$variadic): self { }
    public function mode(): self { }

    /** @see \mean() */
    public self $mean;
    public function mean(...$variadic): self { }
    public function mean(): self { }

    /** @see \median() */
    public self $median;
    public function median(...$variadic): self { }
    public function median(): self { }

    /** @see \multiexplode() */
    public self $multiexplode;
    public function multiexplode($delimiter, $string, $limit = PHP_INT_MAX): self { }
    public function multiexplode($string, $limit = PHP_INT_MAX): self { }

    /** @see \markdown_table() */
    public self $markdown_table;
    public function markdown_table(iterable $array, $option = []): self { }
    public function markdown_table($option = []): self { }

    /** @see \markdown_list() */
    public self $markdown_list;
    public function markdown_list(iterable $array, $option = []): self { }
    public function markdown_list($option = []): self { }

    /** @see \mb_substr_replace() */
    public self $mb_substr_replace;
    public function mb_substr_replace($string, $replacement, $start, $length = null): self { }
    public function mb_substr_replace($replacement, $start, $length = null): self { }

    /** @see \mb_str_pad() */
    public self $mb_str_pad;
    public function mb_str_pad($string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }
    public function mb_str_pad($width, $pad_string = " ", $pad_type = STR_PAD_RIGHT): self { }

    /** @see \mb_ellipsis() */
    public self $mb_ellipsis;
    public function mb_ellipsis($string, $width, $trimmarker = "...", $pos = null): self { }
    public function mb_ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see \mb_trim() */
    public self $mb_trim;
    public function mb_trim($string): self { }
    public function mb_trim(): self { }

}
