<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_3
{
    /** @see \fnmatch() */
    public function fnmatch(string $pattern, string $filename, int $flags = 0): self { }
    public function fnmatch0(string $filename, int $flags = 0): self { }
    public function fnmatch1(string $pattern, int $flags = 0): self { }
    public function fnmatch2(string $pattern, string $filename): self { }

    /** @see \fopen() */
    public function fopen(string $filename, string $mode, bool $use_include_path = false, $context = null): self { }
    public function fopen0(string $mode, bool $use_include_path = false, $context = null): self { }
    public function fopen1(string $filename, bool $use_include_path = false, $context = null): self { }
    public function fopen2(string $filename, string $mode, $context = null): self { }
    public function fopen3(string $filename, string $mode, bool $use_include_path = false): self { }

    /** @see \forward_static_call() */
    public self $forward_static_call;
    public function forward_static_call(callable $callback, mixed ...$args): self { }
    public function forward_static_call0(mixed ...$args): self { }
    public function forward_static_call1(callable $callback): self { }
    public function forward_static_callP(callable $callback, mixed ...$args): self { }
    public function forward_static_call0P(mixed ...$args): self { }
    public function forward_static_call1P(callable $callback): self { }
    public function forward_static_callE(callable $callback, mixed ...$args): self { }
    public function forward_static_call0E(mixed ...$args): self { }
    public function forward_static_call1E(callable $callback): self { }

    /** @see \forward_static_call_array() */
    public function forward_static_call_array(callable $callback, array $args): self { }
    public function forward_static_call_array0(array $args): self { }
    public function forward_static_call_array1(callable $callback): self { }
    public function forward_static_call_arrayP(callable $callback, array $args): self { }
    public function forward_static_call_array0P(array $args): self { }
    public function forward_static_call_array1P(callable $callback): self { }
    public function forward_static_call_arrayE(callable $callback, array $args): self { }
    public function forward_static_call_array0E(array $args): self { }
    public function forward_static_call_array1E(callable $callback): self { }

    /** @see \fpassthru() */
    public self $fpassthru;
    public function fpassthru($stream): self { }
    public function fpassthru0(): self { }

    /** @see \fprintf() */
    public function fprintf($stream, string $format, mixed ...$values): self { }
    public function fprintf0(string $format, mixed ...$values): self { }
    public function fprintf1($stream, mixed ...$values): self { }
    public function fprintf2($stream, string $format): self { }

    /** @see \fputcsv() */
    public function fputcsv($stream, array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv0(array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv1($stream, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv2($stream, array $fields, string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv3($stream, array $fields, string $separator = ",", string $escape = "\\"): self { }
    public function fputcsv4($stream, array $fields, string $separator = ",", string $enclosure = "\""): self { }

    /** @see \fputs() */
    public function fputs($stream, string $data, ?int $length = null): self { }
    public function fputs0(string $data, ?int $length = null): self { }
    public function fputs1($stream, ?int $length = null): self { }
    public function fputs2($stream, string $data): self { }

    /** @see \fread() */
    public function fread($stream, int $length): self { }
    public function fread0(int $length): self { }
    public function fread1($stream): self { }

    /** @see \fscanf() */
    public function fscanf($stream, string $format, mixed &...$vars): self { }
    public function fscanf0(string $format, mixed &...$vars): self { }
    public function fscanf1($stream, mixed &...$vars): self { }
    public function fscanf2($stream, string $format): self { }

    /** @see \fseek() */
    public function fseek($stream, int $offset, int $whence = SEEK_SET): self { }
    public function fseek0(int $offset, int $whence = SEEK_SET): self { }
    public function fseek1($stream, int $whence = SEEK_SET): self { }
    public function fseek2($stream, int $offset): self { }

    /** @see \fsockopen() */
    public self $fsockopen;
    public function fsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen0(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen1(string $hostname, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen2(string $hostname, int $port = -1, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen3(string $hostname, int $port = -1, &$error_code = null, ?float $timeout = null): self { }
    public function fsockopen4(string $hostname, int $port = -1, &$error_code = null, &$error_message = null): self { }

    /** @see \fstat() */
    public self $fstat;
    public function fstat($stream): self { }
    public function fstat0(): self { }

    /** @see \ftell() */
    public self $ftell;
    public function ftell($stream): self { }
    public function ftell0(): self { }

    /** @see \ftok() */
    public function ftok(string $filename, string $project_id): self { }
    public function ftok0(string $project_id): self { }
    public function ftok1(string $filename): self { }

    /** @see \ftruncate() */
    public function ftruncate($stream, int $size): self { }
    public function ftruncate0(int $size): self { }
    public function ftruncate1($stream): self { }

    /** @see \fwrite() */
    public function fwrite($stream, string $data, ?int $length = null): self { }
    public function fwrite0(string $data, ?int $length = null): self { }
    public function fwrite1($stream, ?int $length = null): self { }
    public function fwrite2($stream, string $data): self { }

    /** @see \get_browser() */
    public function get_browser(?string $user_agent = null, bool $return_array = false): self { }
    public function get_browser0(bool $return_array = false): self { }
    public function get_browser1(?string $user_agent = null): self { }

    /** @see \get_cfg_var() */
    public self $get_cfg_var;
    public function get_cfg_var(string $option): self { }
    public function get_cfg_var0(): self { }

    /** @see \get_debug_type() */
    public self $get_debug_type;
    public function get_debug_type(mixed $value): self { }
    public function get_debug_type0(): self { }

    /** @see \get_headers() */
    public self $get_headers;
    public function get_headers(string $url, bool $associative = false, $context = null): self { }
    public function get_headers0(bool $associative = false, $context = null): self { }
    public function get_headers1(string $url, $context = null): self { }
    public function get_headers2(string $url, bool $associative = false): self { }

    /** @see \get_html_translation_table() */
    public function get_html_translation_table(int $table = HTML_SPECIALCHARS, int $flags = ENT_COMPAT, string $encoding = "UTF-8"): self { }
    public function get_html_translation_table0(int $flags = ENT_COMPAT, string $encoding = "UTF-8"): self { }
    public function get_html_translation_table1(int $table = HTML_SPECIALCHARS, string $encoding = "UTF-8"): self { }
    public function get_html_translation_table2(int $table = HTML_SPECIALCHARS, int $flags = ENT_COMPAT): self { }

    /** @see \get_meta_tags() */
    public self $get_meta_tags;
    public function get_meta_tags(string $filename, bool $use_include_path = false): self { }
    public function get_meta_tags0(bool $use_include_path = false): self { }
    public function get_meta_tags1(string $filename): self { }

    /** @see \getenv() */
    public function getenv(?string $name = null, bool $local_only = false): self { }
    public function getenv0(bool $local_only = false): self { }
    public function getenv1(?string $name = null): self { }

    /** @see \gethostbyaddr() */
    public self $gethostbyaddr;
    public function gethostbyaddr(string $ip): self { }
    public function gethostbyaddr0(): self { }

    /** @see \gethostbyname() */
    public self $gethostbyname;
    public function gethostbyname(string $hostname): self { }
    public function gethostbyname0(): self { }

    /** @see \gethostbynamel() */
    public self $gethostbynamel;
    public function gethostbynamel(string $hostname): self { }
    public function gethostbynamel0(): self { }

    /** @see \getimagesize() */
    public self $getimagesize;
    public function getimagesize(string $filename, &$image_info = null): self { }
    public function getimagesize0(&$image_info = null): self { }
    public function getimagesize1(string $filename): self { }

    /** @see \getimagesizefromstring() */
    public self $getimagesizefromstring;
    public function getimagesizefromstring(string $string, &$image_info = null): self { }
    public function getimagesizefromstring0(&$image_info = null): self { }
    public function getimagesizefromstring1(string $string): self { }

    /** @see \getmxrr() */
    public function getmxrr(string $hostname, &$hosts, &$weights = null): self { }
    public function getmxrr0(&$hosts, &$weights = null): self { }
    public function getmxrr1(string $hostname, &$weights = null): self { }
    public function getmxrr2(string $hostname, &$hosts): self { }

    /** @see \getopt() */
    public self $getopt;
    public function getopt(string $short_options, array $long_options = [], &$rest_index = null): self { }
    public function getopt0(array $long_options = [], &$rest_index = null): self { }
    public function getopt1(string $short_options, &$rest_index = null): self { }
    public function getopt2(string $short_options, array $long_options = []): self { }

    /** @see \getprotobyname() */
    public self $getprotobyname;
    public function getprotobyname(string $protocol): self { }
    public function getprotobyname0(): self { }

    /** @see \getprotobynumber() */
    public self $getprotobynumber;
    public function getprotobynumber(int $protocol): self { }
    public function getprotobynumber0(): self { }

    /** @see \getrusage() */
    public function getrusage(int $mode = 0): self { }
    public function getrusage0(): self { }

    /** @see \getservbyname() */
    public function getservbyname(string $service, string $protocol): self { }
    public function getservbyname0(string $protocol): self { }
    public function getservbyname1(string $service): self { }

    /** @see \getservbyport() */
    public function getservbyport(int $port, string $protocol): self { }
    public function getservbyport0(string $protocol): self { }
    public function getservbyport1(int $port): self { }

    /** @see \gettimeofday() */
    public function gettimeofday(bool $as_float = false): self { }
    public function gettimeofday0(): self { }

    /** @see \gettype() */
    public self $gettype;
    public function gettype(mixed $value): self { }
    public function gettype0(): self { }

    /** @see \glob() */
    public self $glob;
    public function glob(string $pattern, int $flags = 0): self { }
    public function glob0(int $flags = 0): self { }
    public function glob1(string $pattern): self { }

    /** @see \header() */
    public self $header;
    public function header(string $header, bool $replace = true, int $response_code = 0): self { }
    public function header0(bool $replace = true, int $response_code = 0): self { }
    public function header1(string $header, int $response_code = 0): self { }
    public function header2(string $header, bool $replace = true): self { }

    /** @see \header_register_callback() */
    public self $header_register_callback;
    public function header_register_callback(callable $callback): self { }
    public function header_register_callback0(): self { }
    public function header_register_callbackP(callable $callback): self { }
    public function header_register_callback0P(): self { }
    public function header_register_callbackE(callable $callback): self { }
    public function header_register_callback0E(): self { }

    /** @see \header_remove() */
    public function header_remove(?string $name = null): self { }
    public function header_remove0(): self { }

    /** @see \hebrev() */
    public self $hebrev;
    public function hebrev(string $string, int $max_chars_per_line = 0): self { }
    public function hebrev0(int $max_chars_per_line = 0): self { }
    public function hebrev1(string $string): self { }

    /** @see \hex2bin() */
    public self $hex2bin;
    public function hex2bin(string $string): self { }
    public function hex2bin0(): self { }

    /** @see \hexdec() */
    public self $hexdec;
    public function hexdec(string $hex_string): self { }
    public function hexdec0(): self { }

    /** @see \highlight_file() */
    public self $highlight_file;
    public function highlight_file(string $filename, bool $return = false): self { }
    public function highlight_file0(bool $return = false): self { }
    public function highlight_file1(string $filename): self { }

    /** @see \highlight_string() */
    public self $highlight_string;
    public function highlight_string(string $string, bool $return = false): self { }
    public function highlight_string0(bool $return = false): self { }
    public function highlight_string1(string $string): self { }

    /** @see \hrtime() */
    public function hrtime(bool $as_number = false): self { }
    public function hrtime0(): self { }

    /** @see \html_entity_decode() */
    public self $html_entity_decode;
    public function html_entity_decode(string $string, int $flags = ENT_COMPAT, ?string $encoding = null): self { }
    public function html_entity_decode0(int $flags = ENT_COMPAT, ?string $encoding = null): self { }
    public function html_entity_decode1(string $string, ?string $encoding = null): self { }
    public function html_entity_decode2(string $string, int $flags = ENT_COMPAT): self { }

    /** @see \htmlentities() */
    public self $htmlentities;
    public function htmlentities(string $string, int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlentities0(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlentities1(string $string, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlentities2(string $string, int $flags = ENT_COMPAT, bool $double_encode = true): self { }
    public function htmlentities3(string $string, int $flags = ENT_COMPAT, ?string $encoding = null): self { }

    /** @see \htmlspecialchars() */
    public self $htmlspecialchars;
    public function htmlspecialchars(string $string, int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlspecialchars0(int $flags = ENT_COMPAT, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlspecialchars1(string $string, ?string $encoding = null, bool $double_encode = true): self { }
    public function htmlspecialchars2(string $string, int $flags = ENT_COMPAT, bool $double_encode = true): self { }
    public function htmlspecialchars3(string $string, int $flags = ENT_COMPAT, ?string $encoding = null): self { }

    /** @see \htmlspecialchars_decode() */
    public self $htmlspecialchars_decode;
    public function htmlspecialchars_decode(string $string, int $flags = ENT_COMPAT): self { }
    public function htmlspecialchars_decode0(int $flags = ENT_COMPAT): self { }
    public function htmlspecialchars_decode1(string $string): self { }

    /** @see \http_build_query() */
    public self $http_build_query;
    public function http_build_query(object|array $data, string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query0(string $numeric_prefix = "", ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query1(object|array $data, ?string $arg_separator = null, int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query2(object|array $data, string $numeric_prefix = "", int $encoding_type = PHP_QUERY_RFC1738): self { }
    public function http_build_query3(object|array $data, string $numeric_prefix = "", ?string $arg_separator = null): self { }

    /** @see \http_response_code() */
    public function http_response_code(int $response_code = 0): self { }
    public function http_response_code0(): self { }

    /** @see \hypot() */
    public function hypot(float $x, float $y): self { }
    public function hypot0(float $y): self { }
    public function hypot1(float $x): self { }

    /** @see \ignore_user_abort() */
    public function ignore_user_abort(?bool $enable = null): self { }
    public function ignore_user_abort0(): self { }

    /** @see \image_type_to_extension() */
    public self $image_type_to_extension;
    public function image_type_to_extension(int $image_type, bool $include_dot = true): self { }
    public function image_type_to_extension0(bool $include_dot = true): self { }
    public function image_type_to_extension1(int $image_type): self { }

    /** @see \image_type_to_mime_type() */
    public self $image_type_to_mime_type;
    public function image_type_to_mime_type(int $image_type): self { }
    public function image_type_to_mime_type0(): self { }

    /** @see \implode() */
    public self $implode;
    public function implode(array|string $separator, ?array $array = null): self { }
    public function implode0(?array $array = null): self { }
    public function implode1(array|string $separator): self { }

    /** @see \in_array() */
    public function in_array(mixed $needle, array $haystack, bool $strict = false): self { }
    public function in_array0(array $haystack, bool $strict = false): self { }
    public function in_array1(mixed $needle, bool $strict = false): self { }
    public function in_array2(mixed $needle, array $haystack): self { }

    /** @see \inet_ntop() */
    public self $inet_ntop;
    public function inet_ntop(string $ip): self { }
    public function inet_ntop0(): self { }

    /** @see \inet_pton() */
    public self $inet_pton;
    public function inet_pton(string $ip): self { }
    public function inet_pton0(): self { }

    /** @see \ini_alter() */
    public function ini_alter(string $option, string $value): self { }
    public function ini_alter0(string $value): self { }
    public function ini_alter1(string $option): self { }

    /** @see \ini_get() */
    public self $ini_get;
    public function ini_get(string $option): self { }
    public function ini_get0(): self { }

}
