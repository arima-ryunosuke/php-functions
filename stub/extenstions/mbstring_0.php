<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait mbstring_0
{
    /** @see \mb_check_encoding() */
    public function mb_check_encoding(array|string|null $value = null, ?string $encoding = null): self { }
    public function mb_check_encoding0(?string $encoding = null): self { }
    public function mb_check_encoding1(array|string|null $value = null): self { }

    /** @see \mb_chr() */
    public self $mb_chr;
    public function mb_chr(int $codepoint, ?string $encoding = null): self { }
    public function mb_chr0(?string $encoding = null): self { }
    public function mb_chr1(int $codepoint): self { }

    /** @see \mb_convert_case() */
    public function mb_convert_case(string $string, int $mode, ?string $encoding = null): self { }
    public function mb_convert_case0(int $mode, ?string $encoding = null): self { }
    public function mb_convert_case1(string $string, ?string $encoding = null): self { }
    public function mb_convert_case2(string $string, int $mode): self { }

    /** @see \mb_convert_encoding() */
    public function mb_convert_encoding(array|string $string, string $to_encoding, array|string|null $from_encoding = null): self { }
    public function mb_convert_encoding0(string $to_encoding, array|string|null $from_encoding = null): self { }
    public function mb_convert_encoding1(array|string $string, array|string|null $from_encoding = null): self { }
    public function mb_convert_encoding2(array|string $string, string $to_encoding): self { }

    /** @see \mb_convert_kana() */
    public self $mb_convert_kana;
    public function mb_convert_kana(string $string, string $mode = "KV", ?string $encoding = null): self { }
    public function mb_convert_kana0(string $mode = "KV", ?string $encoding = null): self { }
    public function mb_convert_kana1(string $string, ?string $encoding = null): self { }
    public function mb_convert_kana2(string $string, string $mode = "KV"): self { }

    /** @see \mb_convert_variables() */
    public function mb_convert_variables(string $to_encoding, array|string $from_encoding, mixed &$var, mixed &...$vars): self { }
    public function mb_convert_variables0(array|string $from_encoding, mixed &$var, mixed &...$vars): self { }
    public function mb_convert_variables1(string $to_encoding, mixed &$var, mixed &...$vars): self { }
    public function mb_convert_variables2(string $to_encoding, array|string $from_encoding, mixed &...$vars): self { }
    public function mb_convert_variables3(string $to_encoding, array|string $from_encoding, mixed &$var): self { }

    /** @see \mb_decode_mimeheader() */
    public self $mb_decode_mimeheader;
    public function mb_decode_mimeheader(string $string): self { }
    public function mb_decode_mimeheader0(): self { }

    /** @see \mb_decode_numericentity() */
    public function mb_decode_numericentity(string $string, array $map, ?string $encoding = null): self { }
    public function mb_decode_numericentity0(array $map, ?string $encoding = null): self { }
    public function mb_decode_numericentity1(string $string, ?string $encoding = null): self { }
    public function mb_decode_numericentity2(string $string, array $map): self { }

    /** @see \mb_detect_encoding() */
    public self $mb_detect_encoding;
    public function mb_detect_encoding(string $string, array|string|null $encodings = null, bool $strict = false): self { }
    public function mb_detect_encoding0(array|string|null $encodings = null, bool $strict = false): self { }
    public function mb_detect_encoding1(string $string, bool $strict = false): self { }
    public function mb_detect_encoding2(string $string, array|string|null $encodings = null): self { }

    /** @see \mb_detect_order() */
    public function mb_detect_order(array|string|null $encoding = null): self { }
    public function mb_detect_order0(): self { }

    /** @see \mb_encode_mimeheader() */
    public self $mb_encode_mimeheader;
    public function mb_encode_mimeheader(string $string, ?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader0(?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader1(string $string, ?string $transfer_encoding = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader2(string $string, ?string $charset = null, string $newline = "\r\n", int $indent = 0): self { }
    public function mb_encode_mimeheader3(string $string, ?string $charset = null, ?string $transfer_encoding = null, int $indent = 0): self { }
    public function mb_encode_mimeheader4(string $string, ?string $charset = null, ?string $transfer_encoding = null, string $newline = "\r\n"): self { }

    /** @see \mb_encode_numericentity() */
    public function mb_encode_numericentity(string $string, array $map, ?string $encoding = null, bool $hex = false): self { }
    public function mb_encode_numericentity0(array $map, ?string $encoding = null, bool $hex = false): self { }
    public function mb_encode_numericentity1(string $string, ?string $encoding = null, bool $hex = false): self { }
    public function mb_encode_numericentity2(string $string, array $map, bool $hex = false): self { }
    public function mb_encode_numericentity3(string $string, array $map, ?string $encoding = null): self { }

    /** @see \mb_encoding_aliases() */
    public self $mb_encoding_aliases;
    public function mb_encoding_aliases(string $encoding): self { }
    public function mb_encoding_aliases0(): self { }

    /** @see \mb_ereg() */
    public function mb_ereg(string $pattern, string $string, &$matches = null): self { }
    public function mb_ereg0(string $string, &$matches = null): self { }
    public function mb_ereg1(string $pattern, &$matches = null): self { }
    public function mb_ereg2(string $pattern, string $string): self { }

    /** @see \mb_ereg_match() */
    public function mb_ereg_match(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_match0(string $string, ?string $options = null): self { }
    public function mb_ereg_match1(string $pattern, ?string $options = null): self { }
    public function mb_ereg_match2(string $pattern, string $string): self { }

    /** @see \mb_ereg_replace() */
    public function mb_ereg_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_ereg_replace0(string $replacement, string $string, ?string $options = null): self { }
    public function mb_ereg_replace1(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_replace2(string $pattern, string $replacement, ?string $options = null): self { }
    public function mb_ereg_replace3(string $pattern, string $replacement, string $string): self { }

    /** @see \mb_ereg_replace_callback() */
    public function mb_ereg_replace_callback(string $pattern, callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback0(callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback1(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback2(string $pattern, callable $callback, ?string $options = null): self { }
    public function mb_ereg_replace_callback3(string $pattern, callable $callback, string $string): self { }
    public function mb_ereg_replace_callbackP(string $pattern, callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback0P(callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback1P(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback2P(string $pattern, callable $callback, ?string $options = null): self { }
    public function mb_ereg_replace_callback3P(string $pattern, callable $callback, string $string): self { }
    public function mb_ereg_replace_callbackE(string $pattern, callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback0E(callable $callback, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback1E(string $pattern, string $string, ?string $options = null): self { }
    public function mb_ereg_replace_callback2E(string $pattern, callable $callback, ?string $options = null): self { }
    public function mb_ereg_replace_callback3E(string $pattern, callable $callback, string $string): self { }

    /** @see \mb_ereg_search() */
    public function mb_ereg_search(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search0(?string $options = null): self { }
    public function mb_ereg_search1(?string $pattern = null): self { }

    /** @see \mb_ereg_search_init() */
    public self $mb_ereg_search_init;
    public function mb_ereg_search_init(string $string, ?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_init0(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_init1(string $string, ?string $options = null): self { }
    public function mb_ereg_search_init2(string $string, ?string $pattern = null): self { }

    /** @see \mb_ereg_search_pos() */
    public function mb_ereg_search_pos(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_pos0(?string $options = null): self { }
    public function mb_ereg_search_pos1(?string $pattern = null): self { }

    /** @see \mb_ereg_search_regs() */
    public function mb_ereg_search_regs(?string $pattern = null, ?string $options = null): self { }
    public function mb_ereg_search_regs0(?string $options = null): self { }
    public function mb_ereg_search_regs1(?string $pattern = null): self { }

    /** @see \mb_ereg_search_setpos() */
    public self $mb_ereg_search_setpos;
    public function mb_ereg_search_setpos(int $offset): self { }
    public function mb_ereg_search_setpos0(): self { }

    /** @see \mb_eregi() */
    public function mb_eregi(string $pattern, string $string, &$matches = null): self { }
    public function mb_eregi0(string $string, &$matches = null): self { }
    public function mb_eregi1(string $pattern, &$matches = null): self { }
    public function mb_eregi2(string $pattern, string $string): self { }

    /** @see \mb_eregi_replace() */
    public function mb_eregi_replace(string $pattern, string $replacement, string $string, ?string $options = null): self { }
    public function mb_eregi_replace0(string $replacement, string $string, ?string $options = null): self { }
    public function mb_eregi_replace1(string $pattern, string $string, ?string $options = null): self { }
    public function mb_eregi_replace2(string $pattern, string $replacement, ?string $options = null): self { }
    public function mb_eregi_replace3(string $pattern, string $replacement, string $string): self { }

    /** @see \mb_get_info() */
    public function mb_get_info(string $type = "all"): self { }
    public function mb_get_info0(): self { }

    /** @see \mb_http_input() */
    public function mb_http_input(?string $type = null): self { }
    public function mb_http_input0(): self { }

    /** @see \mb_http_output() */
    public function mb_http_output(?string $encoding = null): self { }
    public function mb_http_output0(): self { }

    /** @see \mb_internal_encoding() */
    public function mb_internal_encoding(?string $encoding = null): self { }
    public function mb_internal_encoding0(): self { }

    /** @see \mb_language() */
    public function mb_language(?string $language = null): self { }
    public function mb_language0(): self { }

    /** @see \mb_ord() */
    public self $mb_ord;
    public function mb_ord(string $string, ?string $encoding = null): self { }
    public function mb_ord0(?string $encoding = null): self { }
    public function mb_ord1(string $string): self { }

    /** @see \mb_output_handler() */
    public function mb_output_handler(string $string, int $status): self { }
    public function mb_output_handler0(int $status): self { }
    public function mb_output_handler1(string $string): self { }

    /** @see \mb_parse_str() */
    public function mb_parse_str(string $string, &$result): self { }
    public function mb_parse_str0(&$result): self { }
    public function mb_parse_str1(string $string): self { }

    /** @see \mb_preferred_mime_name() */
    public self $mb_preferred_mime_name;
    public function mb_preferred_mime_name(string $encoding): self { }
    public function mb_preferred_mime_name0(): self { }

    /** @see \mb_regex_encoding() */
    public function mb_regex_encoding(?string $encoding = null): self { }
    public function mb_regex_encoding0(): self { }

    /** @see \mb_regex_set_options() */
    public function mb_regex_set_options(?string $options = null): self { }
    public function mb_regex_set_options0(): self { }

    /** @see \mb_scrub() */
    public self $mb_scrub;
    public function mb_scrub(string $string, ?string $encoding = null): self { }
    public function mb_scrub0(?string $encoding = null): self { }
    public function mb_scrub1(string $string): self { }

    /** @see \mb_send_mail() */
    public function mb_send_mail(string $to, string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail0(string $subject, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail1(string $to, string $message, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail2(string $to, string $subject, array|string $additional_headers = [], ?string $additional_params = null): self { }
    public function mb_send_mail3(string $to, string $subject, string $message, ?string $additional_params = null): self { }
    public function mb_send_mail4(string $to, string $subject, string $message, array|string $additional_headers = []): self { }

    /** @see \mb_split() */
    public function mb_split(string $pattern, string $string, int $limit = -1): self { }
    public function mb_split0(string $string, int $limit = -1): self { }
    public function mb_split1(string $pattern, int $limit = -1): self { }
    public function mb_split2(string $pattern, string $string): self { }

    /** @see \mb_str_split() */
    public self $mb_str_split;
    public function mb_str_split(string $string, int $length = 1, ?string $encoding = null): self { }
    public function mb_str_split0(int $length = 1, ?string $encoding = null): self { }
    public function mb_str_split1(string $string, ?string $encoding = null): self { }
    public function mb_str_split2(string $string, int $length = 1): self { }

    /** @see \mb_strcut() */
    public function mb_strcut(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_strcut0(int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_strcut1(string $string, ?int $length = null, ?string $encoding = null): self { }
    public function mb_strcut2(string $string, int $start, ?string $encoding = null): self { }
    public function mb_strcut3(string $string, int $start, ?int $length = null): self { }

    /** @see \mb_strimwidth() */
    public function mb_strimwidth(string $string, int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth0(int $start, int $width, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth1(string $string, int $width, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth2(string $string, int $start, string $trim_marker = "", ?string $encoding = null): self { }
    public function mb_strimwidth3(string $string, int $start, int $width, ?string $encoding = null): self { }
    public function mb_strimwidth4(string $string, int $start, int $width, string $trim_marker = ""): self { }

    /** @see \mb_stripos() */
    public function mb_stripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_stripos0(string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_stripos1(string $haystack, int $offset = 0, ?string $encoding = null): self { }
    public function mb_stripos2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_stripos3(string $haystack, string $needle, int $offset = 0): self { }

    /** @see \mb_stristr() */
    public function mb_stristr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_stristr0(string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_stristr1(string $haystack, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_stristr2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_stristr3(string $haystack, string $needle, bool $before_needle = false): self { }

    /** @see \mb_strlen() */
    public self $mb_strlen;
    public function mb_strlen(string $string, ?string $encoding = null): self { }
    public function mb_strlen0(?string $encoding = null): self { }
    public function mb_strlen1(string $string): self { }

    /** @see \mb_strpos() */
    public function mb_strpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strpos0(string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strpos1(string $haystack, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strpos2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strpos3(string $haystack, string $needle, int $offset = 0): self { }

    /** @see \mb_strrchr() */
    public function mb_strrchr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrchr0(string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrchr1(string $haystack, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrchr2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strrchr3(string $haystack, string $needle, bool $before_needle = false): self { }

    /** @see \mb_strrichr() */
    public function mb_strrichr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrichr0(string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrichr1(string $haystack, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strrichr2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strrichr3(string $haystack, string $needle, bool $before_needle = false): self { }

    /** @see \mb_strripos() */
    public function mb_strripos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strripos0(string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strripos1(string $haystack, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strripos2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strripos3(string $haystack, string $needle, int $offset = 0): self { }

    /** @see \mb_strrpos() */
    public function mb_strrpos(string $haystack, string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strrpos0(string $needle, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strrpos1(string $haystack, int $offset = 0, ?string $encoding = null): self { }
    public function mb_strrpos2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strrpos3(string $haystack, string $needle, int $offset = 0): self { }

    /** @see \mb_strstr() */
    public function mb_strstr(string $haystack, string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strstr0(string $needle, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strstr1(string $haystack, bool $before_needle = false, ?string $encoding = null): self { }
    public function mb_strstr2(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_strstr3(string $haystack, string $needle, bool $before_needle = false): self { }

    /** @see \mb_strtolower() */
    public self $mb_strtolower;
    public function mb_strtolower(string $string, ?string $encoding = null): self { }
    public function mb_strtolower0(?string $encoding = null): self { }
    public function mb_strtolower1(string $string): self { }

    /** @see \mb_strtoupper() */
    public self $mb_strtoupper;
    public function mb_strtoupper(string $string, ?string $encoding = null): self { }
    public function mb_strtoupper0(?string $encoding = null): self { }
    public function mb_strtoupper1(string $string): self { }

    /** @see \mb_strwidth() */
    public self $mb_strwidth;
    public function mb_strwidth(string $string, ?string $encoding = null): self { }
    public function mb_strwidth0(?string $encoding = null): self { }
    public function mb_strwidth1(string $string): self { }

    /** @see \mb_substitute_character() */
    public function mb_substitute_character(string|int|null $substitute_character = null): self { }
    public function mb_substitute_character0(): self { }

    /** @see \mb_substr() */
    public function mb_substr(string $string, int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_substr0(int $start, ?int $length = null, ?string $encoding = null): self { }
    public function mb_substr1(string $string, ?int $length = null, ?string $encoding = null): self { }
    public function mb_substr2(string $string, int $start, ?string $encoding = null): self { }
    public function mb_substr3(string $string, int $start, ?int $length = null): self { }

    /** @see \mb_substr_count() */
    public function mb_substr_count(string $haystack, string $needle, ?string $encoding = null): self { }
    public function mb_substr_count0(string $needle, ?string $encoding = null): self { }
    public function mb_substr_count1(string $haystack, ?string $encoding = null): self { }
    public function mb_substr_count2(string $haystack, string $needle): self { }

}
