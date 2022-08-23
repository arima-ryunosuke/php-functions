<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_2
{
    /** @see \chr() */
    public self $chr;
    public function chr(int $codepoint): self { }
    public function chr0(): self { }

    /** @see \chunk_split() */
    public self $chunk_split;
    public function chunk_split(string $string, int $length = 76, string $separator = "\r\n"): self { }
    public function chunk_split0(int $length = 76, string $separator = "\r\n"): self { }
    public function chunk_split1(string $string, string $separator = "\r\n"): self { }
    public function chunk_split2(string $string, int $length = 76): self { }

    /** @see \clearstatcache() */
    public function clearstatcache(bool $clear_realpath_cache = false, string $filename = ""): self { }
    public function clearstatcache0(string $filename = ""): self { }
    public function clearstatcache1(bool $clear_realpath_cache = false): self { }

    /** @see \cli_set_process_title() */
    public self $cli_set_process_title;
    public function cli_set_process_title(string $title): self { }
    public function cli_set_process_title0(): self { }

    /** @see \closedir() */
    public function closedir($dir_handle = null): self { }
    public function closedir0(): self { }

    /** @see \compact() */
    public self $compact;
    public function compact($var_name, ...$var_names): self { }
    public function compact0(...$var_names): self { }
    public function compact1($var_name): self { }

    /** @see \constant() */
    public self $constant;
    public function constant(string $name): self { }
    public function constant0(): self { }

    /** @see \convert_uudecode() */
    public self $convert_uudecode;
    public function convert_uudecode(string $string): self { }
    public function convert_uudecode0(): self { }

    /** @see \convert_uuencode() */
    public self $convert_uuencode;
    public function convert_uuencode(string $string): self { }
    public function convert_uuencode0(): self { }

    /** @see \copy() */
    public function copy(string $from, string $to, $context = null): self { }
    public function copy0(string $to, $context = null): self { }
    public function copy1(string $from, $context = null): self { }
    public function copy2(string $from, string $to): self { }

    /** @see \cos() */
    public self $cos;
    public function cos(float $num): self { }
    public function cos0(): self { }

    /** @see \cosh() */
    public self $cosh;
    public function cosh(float $num): self { }
    public function cosh0(): self { }

    /** @see \count() */
    public self $count;
    public function count(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function count0(int $mode = COUNT_NORMAL): self { }
    public function count1(\Countable|array $value): self { }

    /** @see \count_chars() */
    public self $count_chars;
    public function count_chars(string $string, int $mode = 0): self { }
    public function count_chars0(int $mode = 0): self { }
    public function count_chars1(string $string): self { }

    /** @see \crc32() */
    public self $crc32;
    public function crc32(string $string): self { }
    public function crc320(): self { }

    /** @see \crypt() */
    public function crypt(string $string, string $salt): self { }
    public function crypt0(string $salt): self { }
    public function crypt1(string $string): self { }

    /** @see \current() */
    public self $current;
    public function current(object|array $array): self { }
    public function current0(): self { }

    /** @see \debug_zval_dump() */
    public self $debug_zval_dump;
    public function debug_zval_dump(mixed $value, mixed ...$values): self { }
    public function debug_zval_dump0(mixed ...$values): self { }
    public function debug_zval_dump1(mixed $value): self { }

    /** @see \decbin() */
    public self $decbin;
    public function decbin(int $num): self { }
    public function decbin0(): self { }

    /** @see \dechex() */
    public self $dechex;
    public function dechex(int $num): self { }
    public function dechex0(): self { }

    /** @see \decoct() */
    public self $decoct;
    public function decoct(int $num): self { }
    public function decoct0(): self { }

    /** @see \deg2rad() */
    public self $deg2rad;
    public function deg2rad(float $num): self { }
    public function deg2rad0(): self { }

    /** @see \dir() */
    public self $dir;
    public function dir(string $directory, $context = null): self { }
    public function dir0($context = null): self { }
    public function dir1(string $directory): self { }

    /** @see \dirname() */
    public self $dirname;
    public function dirname(string $path, int $levels = 1): self { }
    public function dirname0(int $levels = 1): self { }
    public function dirname1(string $path): self { }

    /** @see \disk_free_space() */
    public self $disk_free_space;
    public function disk_free_space(string $directory): self { }
    public function disk_free_space0(): self { }

    /** @see \disk_total_space() */
    public self $disk_total_space;
    public function disk_total_space(string $directory): self { }
    public function disk_total_space0(): self { }

    /** @see \diskfreespace() */
    public self $diskfreespace;
    public function diskfreespace(string $directory): self { }
    public function diskfreespace0(): self { }

    /** @see \dl() */
    public self $dl;
    public function dl(string $extension_filename): self { }
    public function dl0(): self { }

    /** @see \dns_check_record() */
    public self $dns_check_record;
    public function dns_check_record(string $hostname, string $type = "MX"): self { }
    public function dns_check_record0(string $type = "MX"): self { }
    public function dns_check_record1(string $hostname): self { }

    /** @see \dns_get_mx() */
    public function dns_get_mx(string $hostname, &$hosts, &$weights = null): self { }
    public function dns_get_mx0(&$hosts, &$weights = null): self { }
    public function dns_get_mx1(string $hostname, &$weights = null): self { }
    public function dns_get_mx2(string $hostname, &$hosts): self { }

    /** @see \dns_get_record() */
    public self $dns_get_record;
    public function dns_get_record(string $hostname, int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record0(int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record1(string $hostname, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record2(string $hostname, int $type = DNS_ANY, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record3(string $hostname, int $type = DNS_ANY, &$authoritative_name_servers = null, bool $raw = false): self { }
    public function dns_get_record4(string $hostname, int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null): self { }

    /** @see \doubleval() */
    public self $doubleval;
    public function doubleval(mixed $value): self { }
    public function doubleval0(): self { }

    /** @see \error_log() */
    public self $error_log;
    public function error_log(string $message, int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }
    public function error_log0(int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }
    public function error_log1(string $message, ?string $destination = null, ?string $additional_headers = null): self { }
    public function error_log2(string $message, int $message_type = 0, ?string $additional_headers = null): self { }
    public function error_log3(string $message, int $message_type = 0, ?string $destination = null): self { }

    /** @see \escapeshellarg() */
    public self $escapeshellarg;
    public function escapeshellarg(string $arg): self { }
    public function escapeshellarg0(): self { }

    /** @see \escapeshellcmd() */
    public self $escapeshellcmd;
    public function escapeshellcmd(string $command): self { }
    public function escapeshellcmd0(): self { }

    /** @see \exec() */
    public self $exec;
    public function exec(string $command, &$output = null, &$result_code = null): self { }
    public function exec0(&$output = null, &$result_code = null): self { }
    public function exec1(string $command, &$result_code = null): self { }
    public function exec2(string $command, &$output = null): self { }

    /** @see \exp() */
    public self $exp;
    public function exp(float $num): self { }
    public function exp0(): self { }

    /** @see \explode() */
    public function explode(string $separator, string $string, int $limit = PHP_INT_MAX): self { }
    public function explode0(string $string, int $limit = PHP_INT_MAX): self { }
    public function explode1(string $separator, int $limit = PHP_INT_MAX): self { }
    public function explode2(string $separator, string $string): self { }

    /** @see \expm1() */
    public self $expm1;
    public function expm1(float $num): self { }
    public function expm10(): self { }

    /** @see \extract() */
    public self $extract;
    public function extract(array &$array, int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }
    public function extract0(int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }
    public function extract1(array &$array, string $prefix = ""): self { }
    public function extract2(array &$array, int $flags = EXTR_OVERWRITE): self { }

    /** @see \fclose() */
    public self $fclose;
    public function fclose($stream): self { }
    public function fclose0(): self { }

    /** @see \fdiv() */
    public function fdiv(float $num1, float $num2): self { }
    public function fdiv0(float $num2): self { }
    public function fdiv1(float $num1): self { }

    /** @see \feof() */
    public self $feof;
    public function feof($stream): self { }
    public function feof0(): self { }

    /** @see \fflush() */
    public self $fflush;
    public function fflush($stream): self { }
    public function fflush0(): self { }

    /** @see \fgetc() */
    public self $fgetc;
    public function fgetc($stream): self { }
    public function fgetc0(): self { }

    /** @see \fgetcsv() */
    public self $fgetcsv;
    public function fgetcsv($stream, ?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv0(?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv1($stream, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv2($stream, ?int $length = null, string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv3($stream, ?int $length = null, string $separator = ",", string $escape = "\\"): self { }
    public function fgetcsv4($stream, ?int $length = null, string $separator = ",", string $enclosure = "\""): self { }

    /** @see \fgets() */
    public self $fgets;
    public function fgets($stream, ?int $length = null): self { }
    public function fgets0(?int $length = null): self { }
    public function fgets1($stream): self { }

    /** @see \file() */
    public self $file;
    public function file(string $filename, int $flags = 0, $context = null): self { }
    public function file0(int $flags = 0, $context = null): self { }
    public function file1(string $filename, $context = null): self { }
    public function file2(string $filename, int $flags = 0): self { }

    /** @see \file_exists() */
    public self $file_exists;
    public function file_exists(string $filename): self { }
    public function file_exists0(): self { }

    /** @see \file_get_contents() */
    public self $file_get_contents;
    public function file_get_contents(string $filename, bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents0(bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents1(string $filename, $context = null, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents2(string $filename, bool $use_include_path = false, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents3(string $filename, bool $use_include_path = false, $context = null, ?int $length = null): self { }
    public function file_get_contents4(string $filename, bool $use_include_path = false, $context = null, int $offset = 0): self { }

    /** @see \file_put_contents() */
    public function file_put_contents(string $filename, mixed $data, int $flags = 0, $context = null): self { }
    public function file_put_contents0(mixed $data, int $flags = 0, $context = null): self { }
    public function file_put_contents1(string $filename, int $flags = 0, $context = null): self { }
    public function file_put_contents2(string $filename, mixed $data, $context = null): self { }
    public function file_put_contents3(string $filename, mixed $data, int $flags = 0): self { }

    /** @see \fileatime() */
    public self $fileatime;
    public function fileatime(string $filename): self { }
    public function fileatime0(): self { }

    /** @see \filectime() */
    public self $filectime;
    public function filectime(string $filename): self { }
    public function filectime0(): self { }

    /** @see \filegroup() */
    public self $filegroup;
    public function filegroup(string $filename): self { }
    public function filegroup0(): self { }

    /** @see \fileinode() */
    public self $fileinode;
    public function fileinode(string $filename): self { }
    public function fileinode0(): self { }

    /** @see \filemtime() */
    public self $filemtime;
    public function filemtime(string $filename): self { }
    public function filemtime0(): self { }

    /** @see \fileowner() */
    public self $fileowner;
    public function fileowner(string $filename): self { }
    public function fileowner0(): self { }

    /** @see \fileperms() */
    public self $fileperms;
    public function fileperms(string $filename): self { }
    public function fileperms0(): self { }

    /** @see \filesize() */
    public self $filesize;
    public function filesize(string $filename): self { }
    public function filesize0(): self { }

    /** @see \filetype() */
    public self $filetype;
    public function filetype(string $filename): self { }
    public function filetype0(): self { }

    /** @see \floatval() */
    public self $floatval;
    public function floatval(mixed $value): self { }
    public function floatval0(): self { }

    /** @see \flock() */
    public function flock($stream, int $operation, &$would_block = null): self { }
    public function flock0(int $operation, &$would_block = null): self { }
    public function flock1($stream, &$would_block = null): self { }
    public function flock2($stream, int $operation): self { }

    /** @see \floor() */
    public self $floor;
    public function floor(int|float $num): self { }
    public function floor0(): self { }

    /** @see \fmod() */
    public function fmod(float $num1, float $num2): self { }
    public function fmod0(float $num2): self { }
    public function fmod1(float $num1): self { }

}
