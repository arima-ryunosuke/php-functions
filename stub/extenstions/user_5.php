<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait user_5
{
    /** @see \profiler() */
    public function profiler($options = []): self { }
    public function profiler0(): self { }

    /** @see \quoteexplode() */
    public function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = "\\"): self { }
    public function quoteexplode0($string, $limit = null, $enclosures = "'\"", $escape = "\\"): self { }
    public function quoteexplode1($delimiter, $limit = null, $enclosures = "'\"", $escape = "\\"): self { }
    public function quoteexplode2($delimiter, $string, $enclosures = "'\"", $escape = "\\"): self { }
    public function quoteexplode3($delimiter, $string, $limit = null, $escape = "\\"): self { }
    public function quoteexplode4($delimiter, $string, $limit = null, $enclosures = "'\""): self { }

    /** @see \random_at() */
    public function random_at(...$args): self { }
    public function random_at0(): self { }

    /** @see \random_string() */
    public function random_string($length = 8, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function random_string0($charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function random_string1($length = 8): self { }

    /** @see \rbind() */
    public self $rbind;
    public function rbind($callable, ...$variadic): self { }
    public function rbind0(...$variadic): self { }
    public function rbind1($callable): self { }
    public function rbindP($callable, ...$variadic): self { }
    public function rbind0P(...$variadic): self { }
    public function rbind1P($callable): self { }
    public function rbindE($callable, ...$variadic): self { }
    public function rbind0E(...$variadic): self { }
    public function rbind1E($callable): self { }

    /** @see \reflect_callable() */
    public self $reflect_callable;
    public function reflect_callable($callable): self { }
    public function reflect_callable0(): self { }
    public function reflect_callableP($callable): self { }
    public function reflect_callable0P(): self { }
    public function reflect_callableE($callable): self { }
    public function reflect_callable0E(): self { }

    /** @see \reflect_types() */
    public function reflect_types($reflection_type = null): self { }
    public function reflect_types0(): self { }

    /** @see \render_file() */
    public function render_file($template_file, $array): self { }
    public function render_file0($array): self { }
    public function render_file1($template_file): self { }

    /** @see \render_string() */
    public function render_string($template, $array): self { }
    public function render_string0($array): self { }
    public function render_string1($template): self { }

    /** @see \render_template() */
    public function render_template($template, $vars): self { }
    public function render_template0($vars): self { }
    public function render_template1($template): self { }

    /** @see \resolve_symbol() */
    public function resolve_symbol(string $shortname, $nsfiles, $targets = ["const", "function", "alias"]): self { }
    public function resolve_symbol0($nsfiles, $targets = ["const", "function", "alias"]): self { }
    public function resolve_symbol1(string $shortname, $targets = ["const", "function", "alias"]): self { }
    public function resolve_symbol2(string $shortname, $nsfiles): self { }

    /** @see \rm_rf() */
    public self $rm_rf;
    public function rm_rf($dirname, $self = true): self { }
    public function rm_rf0($self = true): self { }
    public function rm_rf1($dirname): self { }

    /** @see \setenvs() */
    public self $setenvs;
    public function setenvs($env_vars): self { }
    public function setenvs0(): self { }

    /** @see \si_prefix() */
    public self $si_prefix;
    public function si_prefix($var, $unit = 1000, $format = "%.3f %s"): self { }
    public function si_prefix0($unit = 1000, $format = "%.3f %s"): self { }
    public function si_prefix1($var, $format = "%.3f %s"): self { }
    public function si_prefix2($var, $unit = 1000): self { }

    /** @see \si_unprefix() */
    public self $si_unprefix;
    public function si_unprefix($var, $unit = 1000): self { }
    public function si_unprefix0($unit = 1000): self { }
    public function si_unprefix1($var): self { }

    /** @see \snake_case() */
    public self $snake_case;
    public function snake_case($string, $delimiter = "_"): self { }
    public function snake_case0($delimiter = "_"): self { }
    public function snake_case1($string): self { }

    /** @see \split_noempty() */
    public function split_noempty($delimiter, $string, $trimchars = true): self { }
    public function split_noempty0($string, $trimchars = true): self { }
    public function split_noempty1($delimiter, $trimchars = true): self { }
    public function split_noempty2($delimiter, $string): self { }

    /** @see \sql_bind() */
    public function sql_bind($sql, $values): self { }
    public function sql_bind0($values): self { }
    public function sql_bind1($sql): self { }

    /** @see \sql_format() */
    public self $sql_format;
    public function sql_format($sql, $options = []): self { }
    public function sql_format0($options = []): self { }
    public function sql_format1($sql): self { }

    /** @see \sql_quote() */
    public self $sql_quote;
    public function sql_quote($value): self { }
    public function sql_quote0(): self { }

    /** @see \stacktrace() */
    public function stacktrace($traces = null, $option = []): self { }
    public function stacktrace0($option = []): self { }
    public function stacktrace1($traces = null): self { }

    /** @see \starts_with() */
    public function starts_with($string, $with, $case_insensitivity = false): self { }
    public function starts_with0($with, $case_insensitivity = false): self { }
    public function starts_with1($string, $case_insensitivity = false): self { }
    public function starts_with2($string, $with): self { }

    /** @see \stdclass() */
    public function stdclass(iterable $fields = []): self { }
    public function stdclass0(): self { }

    /** @see \str_anyof() */
    public function str_anyof($needle, $haystack, $case_insensitivity = false): self { }
    public function str_anyof0($haystack, $case_insensitivity = false): self { }
    public function str_anyof1($needle, $case_insensitivity = false): self { }
    public function str_anyof2($needle, $haystack): self { }

    /** @see \str_anyof() */
    public function anyof($needle, $haystack, $case_insensitivity = false): self { }
    public function anyof0($haystack, $case_insensitivity = false): self { }
    public function anyof1($needle, $case_insensitivity = false): self { }
    public function anyof2($needle, $haystack): self { }

    /** @see \str_array() */
    public function str_array($string, $delimiter, $hashmode): self { }
    public function str_array0($delimiter, $hashmode): self { }
    public function str_array1($string, $hashmode): self { }
    public function str_array2($string, $delimiter): self { }

    /** @see \str_array() */
    public function array($string, $delimiter, $hashmode): self { }
    public function array0($delimiter, $hashmode): self { }
    public function array1($string, $hashmode): self { }
    public function array2($string, $delimiter): self { }

    /** @see \str_between() */
    public function str_between($string, $from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between0($from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between1($string, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between2($string, $from, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between3($string, $from, $to, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_between4($string, $from, $to, &$position = 0, $escape = "\\"): self { }
    public function str_between5($string, $from, $to, &$position = 0, $enclosure = "'\""): self { }

    /** @see \str_between() */
    public function between($string, $from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between0($from, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between1($string, $to, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between2($string, $from, &$position = 0, $enclosure = "'\"", $escape = "\\"): self { }
    public function between3($string, $from, $to, $enclosure = "'\"", $escape = "\\"): self { }
    public function between4($string, $from, $to, &$position = 0, $escape = "\\"): self { }
    public function between5($string, $from, $to, &$position = 0, $enclosure = "'\""): self { }

    /** @see \str_bytes() */
    public self $str_bytes;
    public function str_bytes($string, $base = 10): self { }
    public function str_bytes0($base = 10): self { }
    public function str_bytes1($string): self { }

    /** @see \str_bytes() */
    public self $bytes;
    public function bytes($string, $base = 10): self { }
    public function bytes0($base = 10): self { }
    public function bytes1($string): self { }

    /** @see \str_chop() */
    public self $str_chop;
    public function str_chop($string, $prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function str_chop0($prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function str_chop1($string, $suffix = "", $case_insensitivity = false): self { }
    public function str_chop2($string, $prefix = "", $case_insensitivity = false): self { }
    public function str_chop3($string, $prefix = "", $suffix = ""): self { }

    /** @see \str_chop() */
    public self $chop;
    public function chop($string, $prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function chop0($prefix = "", $suffix = "", $case_insensitivity = false): self { }
    public function chop1($string, $suffix = "", $case_insensitivity = false): self { }
    public function chop2($string, $prefix = "", $case_insensitivity = false): self { }
    public function chop3($string, $prefix = "", $suffix = ""): self { }

    /** @see \str_chunk() */
    public self $str_chunk;
    public function str_chunk($string, ...$chunks): self { }
    public function str_chunk0(...$chunks): self { }
    public function str_chunk1($string): self { }

    /** @see \str_chunk() */
    public self $chunk;
    public function chunk($string, ...$chunks): self { }
    public function chunk0(...$chunks): self { }
    public function chunk1($string): self { }

    /** @see \str_common_prefix() */
    public function str_common_prefix(...$strings): self { }
    public function str_common_prefix0(): self { }

    /** @see \str_common_prefix() */
    public function common_prefix(...$strings): self { }
    public function common_prefix0(): self { }

    /** @see \str_diff() */
    public function str_diff($xstring, $ystring, $options = []): self { }
    public function str_diff0($ystring, $options = []): self { }
    public function str_diff1($xstring, $options = []): self { }
    public function str_diff2($xstring, $ystring): self { }

    /** @see \str_diff() */
    public function diff($xstring, $ystring, $options = []): self { }
    public function diff0($ystring, $options = []): self { }
    public function diff1($xstring, $options = []): self { }
    public function diff2($xstring, $ystring): self { }

    /** @see \str_ellipsis() */
    public function str_ellipsis($string, $width, $trimmarker = "...", $pos = null): self { }
    public function str_ellipsis0($width, $trimmarker = "...", $pos = null): self { }
    public function str_ellipsis1($string, $trimmarker = "...", $pos = null): self { }
    public function str_ellipsis2($string, $width, $pos = null): self { }
    public function str_ellipsis3($string, $width, $trimmarker = "..."): self { }

    /** @see \str_ellipsis() */
    public function ellipsis($string, $width, $trimmarker = "...", $pos = null): self { }
    public function ellipsis0($width, $trimmarker = "...", $pos = null): self { }
    public function ellipsis1($string, $trimmarker = "...", $pos = null): self { }
    public function ellipsis2($string, $width, $pos = null): self { }
    public function ellipsis3($string, $width, $trimmarker = "..."): self { }

    /** @see \str_embed() */
    public function str_embed($string, $replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_embed0($replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_embed1($string, $enclosure = "'\"", $escape = "\\"): self { }
    public function str_embed2($string, $replacemap, $escape = "\\"): self { }
    public function str_embed3($string, $replacemap, $enclosure = "'\""): self { }

    /** @see \str_embed() */
    public function embed($string, $replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function embed0($replacemap, $enclosure = "'\"", $escape = "\\"): self { }
    public function embed1($string, $enclosure = "'\"", $escape = "\\"): self { }
    public function embed2($string, $replacemap, $escape = "\\"): self { }
    public function embed3($string, $replacemap, $enclosure = "'\""): self { }

    /** @see \str_equals() */
    public function str_equals($str1, $str2, $case_insensitivity = false): self { }
    public function str_equals0($str2, $case_insensitivity = false): self { }
    public function str_equals1($str1, $case_insensitivity = false): self { }
    public function str_equals2($str1, $str2): self { }

    /** @see \str_equals() */
    public function equals($str1, $str2, $case_insensitivity = false): self { }
    public function equals0($str2, $case_insensitivity = false): self { }
    public function equals1($str1, $case_insensitivity = false): self { }
    public function equals2($str1, $str2): self { }

    /** @see \str_exists() */
    public function str_exists($haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function str_exists0($needle, $case_insensitivity = false, $and_flag = false): self { }
    public function str_exists1($haystack, $case_insensitivity = false, $and_flag = false): self { }
    public function str_exists2($haystack, $needle, $and_flag = false): self { }
    public function str_exists3($haystack, $needle, $case_insensitivity = false): self { }

    /** @see \str_exists() */
    public function exists($haystack, $needle, $case_insensitivity = false, $and_flag = false): self { }
    public function exists0($needle, $case_insensitivity = false, $and_flag = false): self { }
    public function exists1($haystack, $case_insensitivity = false, $and_flag = false): self { }
    public function exists2($haystack, $needle, $and_flag = false): self { }
    public function exists3($haystack, $needle, $case_insensitivity = false): self { }

    /** @see \str_guess() */
    public function str_guess($string, $candidates, &$percent = null): self { }
    public function str_guess0($candidates, &$percent = null): self { }
    public function str_guess1($string, &$percent = null): self { }
    public function str_guess2($string, $candidates): self { }

    /** @see \str_guess() */
    public function guess($string, $candidates, &$percent = null): self { }
    public function guess0($candidates, &$percent = null): self { }
    public function guess1($string, &$percent = null): self { }
    public function guess2($string, $candidates): self { }

    /** @see \str_lchop() */
    public function str_lchop($string, $prefix, $case_insensitivity = false): self { }
    public function str_lchop0($prefix, $case_insensitivity = false): self { }
    public function str_lchop1($string, $case_insensitivity = false): self { }
    public function str_lchop2($string, $prefix): self { }

    /** @see \str_lchop() */
    public function lchop($string, $prefix, $case_insensitivity = false): self { }
    public function lchop0($prefix, $case_insensitivity = false): self { }
    public function lchop1($string, $case_insensitivity = false): self { }
    public function lchop2($string, $prefix): self { }

    /** @see \str_putcsv() */
    public self $str_putcsv;
    public function str_putcsv($array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function str_putcsv0($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function str_putcsv1($array, $enclosure = "\"", $escape = "\\"): self { }
    public function str_putcsv2($array, $delimiter = ",", $escape = "\\"): self { }
    public function str_putcsv3($array, $delimiter = ",", $enclosure = "\""): self { }

    /** @see \str_putcsv() */
    public self $putcsv;
    public function putcsv($array, $delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function putcsv0($delimiter = ",", $enclosure = "\"", $escape = "\\"): self { }
    public function putcsv1($array, $enclosure = "\"", $escape = "\\"): self { }
    public function putcsv2($array, $delimiter = ",", $escape = "\\"): self { }
    public function putcsv3($array, $delimiter = ",", $enclosure = "\""): self { }

    /** @see \str_rchop() */
    public function str_rchop($string, $suffix, $case_insensitivity = false): self { }
    public function str_rchop0($suffix, $case_insensitivity = false): self { }
    public function str_rchop1($string, $case_insensitivity = false): self { }
    public function str_rchop2($string, $suffix): self { }

    /** @see \str_rchop() */
    public function rchop($string, $suffix, $case_insensitivity = false): self { }
    public function rchop0($suffix, $case_insensitivity = false): self { }
    public function rchop1($string, $case_insensitivity = false): self { }
    public function rchop2($string, $suffix): self { }

    /** @see \str_submap() */
    public function str_submap($subject, $replaces, $case_insensitivity = false): self { }
    public function str_submap0($replaces, $case_insensitivity = false): self { }
    public function str_submap1($subject, $case_insensitivity = false): self { }
    public function str_submap2($subject, $replaces): self { }

    /** @see \str_submap() */
    public function submap($subject, $replaces, $case_insensitivity = false): self { }
    public function submap0($replaces, $case_insensitivity = false): self { }
    public function submap1($subject, $case_insensitivity = false): self { }
    public function submap2($subject, $replaces): self { }

    /** @see \str_subreplace() */
    public function str_subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function str_subreplace0($search, $replaces, $case_insensitivity = false): self { }
    public function str_subreplace1($subject, $replaces, $case_insensitivity = false): self { }
    public function str_subreplace2($subject, $search, $case_insensitivity = false): self { }
    public function str_subreplace3($subject, $search, $replaces): self { }

    /** @see \str_subreplace() */
    public function subreplace($subject, $search, $replaces, $case_insensitivity = false): self { }
    public function subreplace0($search, $replaces, $case_insensitivity = false): self { }
    public function subreplace1($subject, $replaces, $case_insensitivity = false): self { }
    public function subreplace2($subject, $search, $case_insensitivity = false): self { }
    public function subreplace3($subject, $search, $replaces): self { }

    /** @see \strcat() */
    public function strcat(...$variadic): self { }
    public function strcat0(): self { }

    /** @see \stringify() */
    public self $stringify;
    public function stringify($var): self { }
    public function stringify0(): self { }

    /** @see \strip_php() */
    public self $strip_php;
    public function strip_php($phtml, $option = [], &$mapping = []): self { }
    public function strip_php0($option = [], &$mapping = []): self { }
    public function strip_php1($phtml, &$mapping = []): self { }
    public function strip_php2($phtml, $option = []): self { }

    /** @see \strpos_array() */
    public function strpos_array($haystack, $needles, $offset = 0): self { }
    public function strpos_array0($needles, $offset = 0): self { }
    public function strpos_array1($haystack, $offset = 0): self { }
    public function strpos_array2($haystack, $needles): self { }

    /** @see \strpos_quoted() */
    public function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted0($needle, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted1($haystack, $offset = 0, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted2($haystack, $needle, $enclosure = "'\"", $escape = "\\", &$found = null): self { }
    public function strpos_quoted3($haystack, $needle, $offset = 0, $escape = "\\", &$found = null): self { }
    public function strpos_quoted4($haystack, $needle, $offset = 0, $enclosure = "'\"", &$found = null): self { }
    public function strpos_quoted5($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = "\\"): self { }

}
