<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectS
{
    /** @see \strtotime() */
    public self $strtotime;
    public function strtotime(string $datetime, ?int $baseTimestamp = null): self { }
    public function strtotime(?int $baseTimestamp = null): self { }

    /** @see \strftime() */
    public self $strftime;
    public function strftime(string $format, ?int $timestamp = null): self { }
    public function strftime(?int $timestamp = null): self { }

    /** @see \set_time_limit() */
    public self $set_time_limit;
    public function set_time_limit(int $seconds): self { }
    public function set_time_limit(): self { }

    /** @see \sizeof() */
    public self $sizeof;
    public function sizeof(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function sizeof(int $mode = COUNT_NORMAL): self { }

    /** @see \sort() */
    public self $sort;
    public function sort(array &$array, int $flags = SORT_REGULAR): self { }
    public function sort(int $flags = SORT_REGULAR): self { }

    /** @see \sleep() */
    public self $sleep;
    public function sleep(int $seconds): self { }
    public function sleep(): self { }

    /** @see \show_source() */
    public self $show_source;
    public function show_source(string $filename, bool $return = false): self { }
    public function show_source(bool $return = false): self { }

    /** @see \set_include_path() */
    public self $set_include_path;
    public function set_include_path(string $include_path): self { }
    public function set_include_path(): self { }

    /** @see \sha1() */
    public self $sha1;
    public function sha1(string $string, bool $binary = false): self { }
    public function sha1(bool $binary = false): self { }

    /** @see \sha1_file() */
    public self $sha1_file;
    public function sha1_file(string $filename, bool $binary = false): self { }
    public function sha1_file(bool $binary = false): self { }

    /** @see \syslog() */
    public self $syslog;
    public function syslog(int $priority, string $message): self { }
    public function syslog(string $message): self { }

    /** @see \setrawcookie() */
    public self $setrawcookie;
    public function setrawcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setrawcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }

    /** @see \setcookie() */
    public self $setcookie;
    public function setcookie(string $name, string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }
    public function setcookie(string $value = "", array|int $expires_or_options = 0, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false): self { }

    /** @see \strspn() */
    public self $strspn;
    public function strspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strspn(string $characters, int $offset = 0, ?int $length = null): self { }

    /** @see \strcspn() */
    public self $strcspn;
    public function strcspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strcspn(string $characters, int $offset = 0, ?int $length = null): self { }

    /** @see \strcoll() */
    public self $strcoll;
    public function strcoll(string $string1, string $string2): self { }
    public function strcoll(string $string2): self { }

    /** @see \strtok() */
    public self $strtok;
    public function strtok(string $string, ?string $token = null): self { }
    public function strtok(?string $token = null): self { }

    /** @see \strtoupper() */
    public self $strtoupper;
    public function strtoupper(string $string): self { }
    public function strtoupper(): self { }

    /** @see \strtolower() */
    public self $strtolower;
    public function strtolower(string $string): self { }
    public function strtolower(): self { }

    /** @see \stristr() */
    public self $stristr;
    public function stristr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function stristr(string $needle, bool $before_needle = false): self { }

    /** @see \strstr() */
    public self $strstr;
    public function strstr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strstr(string $needle, bool $before_needle = false): self { }

    /** @see \strchr() */
    public self $strchr;
    public function strchr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strchr(string $needle, bool $before_needle = false): self { }

    /** @see \strpos() */
    public self $strpos;
    public function strpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strpos(string $needle, int $offset = 0): self { }

    /** @see \stripos() */
    public self $stripos;
    public function stripos(string $haystack, string $needle, int $offset = 0): self { }
    public function stripos(string $needle, int $offset = 0): self { }

    /** @see \strrpos() */
    public self $strrpos;
    public function strrpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strrpos(string $needle, int $offset = 0): self { }

    /** @see \strripos() */
    public self $strripos;
    public function strripos(string $haystack, string $needle, int $offset = 0): self { }
    public function strripos(string $needle, int $offset = 0): self { }

    /** @see \strrchr() */
    public self $strrchr;
    public function strrchr(string $haystack, string $needle): self { }
    public function strrchr(string $needle): self { }

    /** @see \str_contains() */
    public self $str_contains;
    public function str_contains(string $haystack, string $needle): self { }
    public function str_contains(string $needle): self { }

    /** @see \str_contains() */
    public self $contains;
    public function contains(string $haystack, string $needle): self { }
    public function contains(string $needle): self { }

    /** @see \str_starts_with() */
    public self $str_starts_with;
    public function str_starts_with(string $haystack, string $needle): self { }
    public function str_starts_with(string $needle): self { }

    /** @see \str_starts_with() */
    public self $starts_with;
    public function starts_with(string $haystack, string $needle): self { }
    public function starts_with(string $needle): self { }

    /** @see \str_ends_with() */
    public self $str_ends_with;
    public function str_ends_with(string $haystack, string $needle): self { }
    public function str_ends_with(string $needle): self { }

    /** @see \str_ends_with() */
    public self $ends_with;
    public function ends_with(string $haystack, string $needle): self { }
    public function ends_with(string $needle): self { }

    /** @see \substr() */
    public self $substr;
    public function substr(string $string, int $offset, ?int $length = null): self { }
    public function substr(int $offset, ?int $length = null): self { }

    /** @see \substr_replace() */
    public self $substr_replace;
    public function substr_replace(array|string $string, array|string $replace, array|int $offset, array|int|null $length = null): self { }
    public function substr_replace(array|string $replace, array|int $offset, array|int|null $length = null): self { }

    /** @see \strtr() */
    public self $strtr;
    public function strtr(string $string, array|string $from, ?string $to = null): self { }
    public function strtr(array|string $from, ?string $to = null): self { }

    /** @see \strrev() */
    public self $strrev;
    public function strrev(string $string): self { }
    public function strrev(): self { }

    /** @see \similar_text() */
    public self $similar_text;
    public function similar_text(string $string1, string $string2, &$percent = null): self { }
    public function similar_text(string $string2, &$percent = null): self { }

    /** @see \stripcslashes() */
    public self $stripcslashes;
    public function stripcslashes(string $string): self { }
    public function stripcslashes(): self { }

    /** @see \stripslashes() */
    public self $stripslashes;
    public function stripslashes(string $string): self { }
    public function stripslashes(): self { }

    /** @see \str_replace() */
    public self $str_replace;
    public function str_replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_replace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \str_replace() */
    public self $replace;
    public function replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function replace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \str_ireplace() */
    public self $str_ireplace;
    public function str_ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_ireplace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \str_ireplace() */
    public self $ireplace;
    public function ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function ireplace(array|string $replace, array|string $subject, &$count = null): self { }

    /** @see \strip_tags() */
    public self $strip_tags;
    public function strip_tags(string $string, array|string|null $allowed_tags = null): self { }
    public function strip_tags(array|string|null $allowed_tags = null): self { }

    /** @see \setlocale() */
    public self $setlocale;
    public function setlocale(int $category, $locales, ...$rest): self { }
    public function setlocale($locales, ...$rest): self { }

    /** @see \str_getcsv() */
    public self $str_getcsv;
    public function str_getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function str_getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see \str_getcsv() */
    public self $getcsv;
    public function getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function getcsv(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see \str_repeat() */
    public self $str_repeat;
    public function str_repeat(string $string, int $times): self { }
    public function str_repeat(int $times): self { }

    /** @see \str_repeat() */
    public self $repeat;
    public function repeat(string $string, int $times): self { }
    public function repeat(int $times): self { }

    /** @see \strnatcmp() */
    public self $strnatcmp;
    public function strnatcmp(string $string1, string $string2): self { }
    public function strnatcmp(string $string2): self { }

    /** @see \strnatcasecmp() */
    public self $strnatcasecmp;
    public function strnatcasecmp(string $string1, string $string2): self { }
    public function strnatcasecmp(string $string2): self { }

    /** @see \substr_count() */
    public self $substr_count;
    public function substr_count(string $haystack, string $needle, int $offset = 0, ?int $length = null): self { }
    public function substr_count(string $needle, int $offset = 0, ?int $length = null): self { }

    /** @see \str_pad() */
    public self $str_pad;
    public function str_pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }

    /** @see \str_pad() */
    public self $pad;
    public function pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function pad(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }

    /** @see \sscanf() */
    public self $sscanf;
    public function sscanf(string $string, string $format, mixed &...$vars): self { }
    public function sscanf(string $format, mixed &...$vars): self { }

    /** @see \str_rot13() */
    public self $str_rot13;
    public function str_rot13(string $string): self { }
    public function str_rot13(): self { }

    /** @see \str_rot13() */
    public self $rot13;
    public function rot13(string $string): self { }
    public function rot13(): self { }

    /** @see \str_shuffle() */
    public self $str_shuffle;
    public function str_shuffle(string $string): self { }
    public function str_shuffle(): self { }

    /** @see \str_shuffle() */
    public self $shuffle;
    public function shuffle(string $string): self { }
    public function shuffle(): self { }

    /** @see \str_word_count() */
    public self $str_word_count;
    public function str_word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function str_word_count(int $format = 0, ?string $characters = null): self { }

    /** @see \str_word_count() */
    public self $word_count;
    public function word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function word_count(int $format = 0, ?string $characters = null): self { }

    /** @see \str_split() */
    public self $str_split;
    public function str_split(string $string, int $length = 1): self { }
    public function str_split(int $length = 1): self { }

    /** @see \str_split() */
    public self $split;
    public function split(string $string, int $length = 1): self { }
    public function split(int $length = 1): self { }

    /** @see \strpbrk() */
    public self $strpbrk;
    public function strpbrk(string $string, string $characters): self { }
    public function strpbrk(string $characters): self { }

    /** @see \substr_compare() */
    public self $substr_compare;
    public function substr_compare(string $haystack, string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare(string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }

    /** @see \scandir() */
    public self $scandir;
    public function scandir(string $directory, int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }
    public function scandir(int $sorting_order = SCANDIR_SORT_ASCENDING, $context = null): self { }

    /** @see \system() */
    public self $system;
    public function system(string $command, &$result_code = null): self { }
    public function system(&$result_code = null): self { }

    /** @see \shell_exec() */
    public self $shell_exec;
    public function shell_exec(string $command): self { }
    public function shell_exec(): self { }

    /** @see \stat() */
    public self $stat;
    public function stat(string $filename): self { }
    public function stat(): self { }

    /** @see \sprintf() */
    public self $sprintf;
    public function sprintf(string $format, mixed ...$values): self { }
    public function sprintf(mixed ...$values): self { }

    /** @see \symlink() */
    public self $symlink;
    public function symlink(string $target, string $link): self { }
    public function symlink(string $link): self { }

    /** @see \sin() */
    public self $sin;
    public function sin(float $num): self { }
    public function sin(): self { }

    /** @see \sinh() */
    public self $sinh;
    public function sinh(float $num): self { }
    public function sinh(): self { }

    /** @see \sqrt() */
    public self $sqrt;
    public function sqrt(float $num): self { }
    public function sqrt(): self { }

    /** @see \srand() */
    public self $srand;
    public function srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function srand(int $mode = MT_RAND_MT19937): self { }

    /** @see \soundex() */
    public self $soundex;
    public function soundex(string $string): self { }
    public function soundex(): self { }

    /** @see \set_file_buffer() */
    public self $set_file_buffer;
    public function set_file_buffer($stream, int $size): self { }
    public function set_file_buffer(int $size): self { }

    /** @see \settype() */
    public self $settype;
    public function settype(mixed &$var, string $type): self { }
    public function settype(string $type): self { }

    /** @see \strval() */
    public self $strval;
    public function strval(mixed $value): self { }
    public function strval(): self { }

    /** @see \serialize() */
    public self $serialize;
    public function serialize(mixed $value): self { }
    public function serialize(): self { }

    /** @see \stdclass() */
    public self $stdclass;
    public function stdclass(iterable $fields = []): self { }
    public function stdclass(): self { }

    /** @see \sum() */
    public self $sum;
    public function sum(...$variadic): self { }
    public function sum(): self { }

    /** @see \sql_quote() */
    public self $sql_quote;
    public function sql_quote($value): self { }
    public function sql_quote(): self { }

    /** @see \sql_bind() */
    public self $sql_bind;
    public function sql_bind($sql, $values): self { }
    public function sql_bind($values): self { }

    /** @see \sql_format() */
    public self $sql_format;
    public function sql_format($sql, $options = []): self { }
    public function sql_format($options = []): self { }

    /** @see \strcat() */
    public self $strcat;
    public function strcat(...$variadic): self { }
    public function strcat(): self { }

    /** @see \split_noempty() */
    public self $split_noempty;
    public function split_noempty($delimiter, $string, $trimchars = true): self { }
    public function split_noempty($string, $trimchars = true): self { }

    /** @see \strrstr() */
    public self $strrstr;
    public function strrstr($haystack, $needle, $after_needle = true): self { }
    public function strrstr($needle, $after_needle = true): self { }

    /** @see \strpos_array() */
    public self $strpos_array;
    public function strpos_array($haystack, $needles, $offset = 0): self { }
    public function strpos_array($needles, $offset = 0): self { }

    /** @see \strpos_escaped() */
    public self $strpos_escaped;
    public function strpos_escaped($haystack, $needle, $offset = 0, $escape = "\\", &$found = null): self { }
    public function strpos_escaped($needle, $offset = 0, $escape = "\\", &$found = null): self { }

    /** @see \strpos_quoted() */
    public self $strpos_quoted;
    public function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted($needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }

    /** @see \strtr_escaped() */
    public self $strtr_escaped;
    public function strtr_escaped($string, $replace_pairs, $escape = "\\"): self { }
    public function strtr_escaped($replace_pairs, $escape = "\\"): self { }

    /** @see \str_bytes() */
    public self $str_bytes;
    public function str_bytes($string, $base = 10): self { }
    public function str_bytes($base = 10): self { }

    /** @see \str_bytes() */
    public self $bytes;
    public function bytes($string, $base = 10): self { }
    public function bytes($base = 10): self { }

    /** @see \str_chunk() */
    public self $str_chunk;
    public function str_chunk($string, ...$chunks): self { }
    public function str_chunk(...$chunks): self { }

    /** @see \str_chunk() */
    public self $chunk;
    public function chunk($string, ...$chunks): self { }
    public function chunk(...$chunks): self { }

    /** @see \str_anyof() */
    public self $str_anyof;
    public function str_anyof($needle, $haystack, $case_insensitivity = false): self { }
    public function str_anyof($haystack, $case_insensitivity = false): self { }

    /** @see \str_anyof() */
    public self $anyof;
    public function anyof($needle, $haystack, $case_insensitivity = false): self { }
    public function anyof($haystack, $case_insensitivity = false): self { }

    /** @see \str_equals() */
    public self $str_equals;
    public function str_equals($str1, $str2, $case_insensitivity = false): self { }
    public function str_equals($str2, $case_insensitivity = false): self { }

    /** @see \str_equals() */
    public self $equals;
    public function equals($str1, $str2, $case_insensitivity = false): self { }
    public function equals($str2, $case_insensitivity = false): self { }

    /** @see \str_exists() */
    public self $str_exists;
    public function str_exists($haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function str_exists($needle, $case_insensitivity = false, $and_flag = false): self { }

    /** @see \str_exists() */
    public self $exists;
    public function exists($haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function exists($needle, $case_insensitivity = false, $and_flag = false): self { }

    /** @see \str_chop() */
    public self $str_chop;
    public function str_chop($string, $prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function str_chop($prefix = "", $suffix = "", $case_insensitivity = false): self { }

    /** @see \str_chop() */
    public self $chop;
    public function chop($string, $prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function chop($prefix = "", $suffix = "", $case_insensitivity = false): self { }

    /** @see \str_lchop() */
    public self $str_lchop;
    public function str_lchop($string, $prefix, $case_insensitivity = false): self { }
    public function str_lchop($prefix, $case_insensitivity = false): self { }

    /** @see \str_lchop() */
    public self $lchop;
    public function lchop($string, $prefix, $case_insensitivity = false): self { }
    public function lchop($prefix, $case_insensitivity = false): self { }

    /** @see \str_rchop() */
    public self $str_rchop;
    public function str_rchop($string, $suffix, $case_insensitivity = false): self { }
    public function str_rchop($suffix, $case_insensitivity = false): self { }

    /** @see \str_rchop() */
    public self $rchop;
    public function rchop($string, $suffix, $case_insensitivity = false): self { }
    public function rchop($suffix, $case_insensitivity = false): self { }

    /** @see \str_putcsv() */
    public self $str_putcsv;
    public function str_putcsv(iterable $array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function str_putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }

    /** @see \str_putcsv() */
    public self $putcsv;
    public function putcsv(iterable $array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function putcsv($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }

    /** @see \str_subreplace() */
    public self $str_subreplace;
    public function str_subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function str_subreplace($search, $replaces, $case_insensitivity = false): self { }

    /** @see \str_subreplace() */
    public self $subreplace;
    public function subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function subreplace($search, $replaces, $case_insensitivity = false): self { }

    /** @see \str_submap() */
    public self $str_submap;
    public function str_submap($subject, $replaces, $case_insensitivity = false): self { }
    public function str_submap($replaces, $case_insensitivity = false): self { }

    /** @see \str_submap() */
    public self $submap;
    public function submap($subject, $replaces, $case_insensitivity = false): self { }
    public function submap($replaces, $case_insensitivity = false): self { }

    /** @see \str_embed() */
    public self $str_embed;
    public function str_embed($string, $replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_embed($replacemap, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see \str_embed() */
    public self $embed;
    public function embed($string, $replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function embed($replacemap, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see \str_between() */
    public self $str_between;
    public function str_between($string, $from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between($from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see \str_between() */
    public self $between;
    public function between($string, $from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between($from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }

    /** @see \str_ellipsis() */
    public self $str_ellipsis;
    public function str_ellipsis($string, $width, $trimmarker = "...", $pos = null): self { }
    public function str_ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see \str_ellipsis() */
    public self $ellipsis;
    public function ellipsis($string, $width, $trimmarker = "...", $pos = null): self { }
    public function ellipsis($width, $trimmarker = "...", $pos = null): self { }

    /** @see \str_diff() */
    public self $str_diff;
    public function str_diff($xstring, $ystring, $options = []): self { }
    public function str_diff($ystring, $options = []): self { }

    /** @see \str_diff() */
    public self $diff;
    public function diff($xstring, $ystring, $options = []): self { }
    public function diff($ystring, $options = []): self { }

    /** @see \starts_with() */
    public self $starts_with;
    public function starts_with($string, $with, $case_insensitivity = false): self { }
    public function starts_with($with, $case_insensitivity = false): self { }

    /** @see \snake_case() */
    public self $snake_case;
    public function snake_case($string, $delimiter = "_"): self { }
    public function snake_case($delimiter = "_"): self { }

    /** @see \str_guess() */
    public self $str_guess;
    public function str_guess($string, $candidates, &$percent = null): self { }
    public function str_guess($candidates, &$percent = null): self { }

    /** @see \str_guess() */
    public self $guess;
    public function guess($string, $candidates, &$percent = null): self { }
    public function guess($candidates, &$percent = null): self { }

    /** @see \str_array() */
    public self $str_array;
    public function str_array($string, $delimiter, $hashmode): self { }
    public function str_array($delimiter, $hashmode): self { }

    /** @see \str_array() */
    public self $array;
    public function array($string, $delimiter, $hashmode): self { }
    public function array($delimiter, $hashmode): self { }

    /** @see \str_common_prefix() */
    public self $str_common_prefix;
    public function str_common_prefix(...$strings): self { }
    public function str_common_prefix(): self { }

    /** @see \str_common_prefix() */
    public self $common_prefix;
    public function common_prefix(...$strings): self { }
    public function common_prefix(): self { }

    /** @see \strip_php() */
    public self $strip_php;
    public function strip_php($phtml, $option = [], &$mapping = []): self { }
    public function strip_php($option = [], &$mapping = []): self { }

    /** @see \switchs() */
    public self $switchs;
    public function switchs($value, $cases, $default = null): self { }
    public function switchs($cases, $default = null): self { }

    /** @see \setenvs() */
    public self $setenvs;
    public function setenvs($env_vars): self { }
    public function setenvs(): self { }

    /** @see \stacktrace() */
    public self $stacktrace;
    public function stacktrace($traces = null, $option = []): self { }
    public function stacktrace($option = []): self { }

    /** @see \stringify() */
    public self $stringify;
    public function stringify($var): self { }
    public function stringify(): self { }

    /** @see \si_prefix() */
    public self $si_prefix;
    public function si_prefix($var, $unit = 1000, $format = "%.3f %s"): self { }
    public function si_prefix($unit = 1000, $format = "%.3f %s"): self { }

    /** @see \si_unprefix() */
    public self $si_unprefix;
    public function si_unprefix($var, $unit = 1000): self { }
    public function si_unprefix($unit = 1000): self { }

}
