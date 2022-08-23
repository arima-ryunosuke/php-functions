<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_6
{
    /** @see \shell_exec() */
    public self $shell_exec;
    public function shell_exec(string $command): self { }
    public function shell_exec0(): self { }

    /** @see \show_source() */
    public self $show_source;
    public function show_source(string $filename, bool $return = false): self { }
    public function show_source0(bool $return = false): self { }
    public function show_source1(string $filename): self { }

    /** @see \similar_text() */
    public function similar_text(string $string1, string $string2, &$percent = null): self { }
    public function similar_text0(string $string2, &$percent = null): self { }
    public function similar_text1(string $string1, &$percent = null): self { }
    public function similar_text2(string $string1, string $string2): self { }

    /** @see \sin() */
    public self $sin;
    public function sin(float $num): self { }
    public function sin0(): self { }

    /** @see \sinh() */
    public self $sinh;
    public function sinh(float $num): self { }
    public function sinh0(): self { }

    /** @see \sizeof() */
    public self $sizeof;
    public function sizeof(\Countable|array $value, int $mode = COUNT_NORMAL): self { }
    public function sizeof0(int $mode = COUNT_NORMAL): self { }
    public function sizeof1(\Countable|array $value): self { }

    /** @see \sleep() */
    public self $sleep;
    public function sleep(int $seconds): self { }
    public function sleep0(): self { }

    /** @see \sort() */
    public self $sort;
    public function sort(array &$array, int $flags = SORT_REGULAR): self { }
    public function sort0(int $flags = SORT_REGULAR): self { }
    public function sort1(array &$array): self { }

    /** @see \soundex() */
    public self $soundex;
    public function soundex(string $string): self { }
    public function soundex0(): self { }

    /** @see \sprintf() */
    public self $sprintf;
    public function sprintf(string $format, mixed ...$values): self { }
    public function sprintf0(mixed ...$values): self { }
    public function sprintf1(string $format): self { }

    /** @see \sqrt() */
    public self $sqrt;
    public function sqrt(float $num): self { }
    public function sqrt0(): self { }

    /** @see \srand() */
    public function srand(int $seed = 0, int $mode = MT_RAND_MT19937): self { }
    public function srand0(int $mode = MT_RAND_MT19937): self { }
    public function srand1(int $seed = 0): self { }

    /** @see \sscanf() */
    public function sscanf(string $string, string $format, mixed &...$vars): self { }
    public function sscanf0(string $format, mixed &...$vars): self { }
    public function sscanf1(string $string, mixed &...$vars): self { }
    public function sscanf2(string $string, string $format): self { }

    /** @see \stat() */
    public self $stat;
    public function stat(string $filename): self { }
    public function stat0(): self { }

    /** @see \str_contains() */
    public function str_contains(string $haystack, string $needle): self { }
    public function str_contains0(string $needle): self { }
    public function str_contains1(string $haystack): self { }

    /** @see \str_contains() */
    public function contains(string $haystack, string $needle): self { }
    public function contains0(string $needle): self { }
    public function contains1(string $haystack): self { }

    /** @see \str_ends_with() */
    public function str_ends_with(string $haystack, string $needle): self { }
    public function str_ends_with0(string $needle): self { }
    public function str_ends_with1(string $haystack): self { }

    /** @see \str_ends_with() */
    public function ends_with(string $haystack, string $needle): self { }
    public function ends_with0(string $needle): self { }
    public function ends_with1(string $haystack): self { }

    /** @see \str_getcsv() */
    public self $str_getcsv;
    public function str_getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function str_getcsv0(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function str_getcsv1(string $string, string $enclosure = "\"", string $escape = "\\"): self { }
    public function str_getcsv2(string $string, string $separator = ",", string $escape = "\\"): self { }
    public function str_getcsv3(string $string, string $separator = ",", string $enclosure = "\""): self { }

    /** @see \str_getcsv() */
    public self $getcsv;
    public function getcsv(string $string, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function getcsv0(string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function getcsv1(string $string, string $enclosure = "\"", string $escape = "\\"): self { }
    public function getcsv2(string $string, string $separator = ",", string $escape = "\\"): self { }
    public function getcsv3(string $string, string $separator = ",", string $enclosure = "\""): self { }

    /** @see \str_ireplace() */
    public function str_ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_ireplace0(array|string $replace, array|string $subject, &$count = null): self { }
    public function str_ireplace1(array|string $search, array|string $subject, &$count = null): self { }
    public function str_ireplace2(array|string $search, array|string $replace, &$count = null): self { }
    public function str_ireplace3(array|string $search, array|string $replace, array|string $subject): self { }

    /** @see \str_ireplace() */
    public function ireplace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function ireplace0(array|string $replace, array|string $subject, &$count = null): self { }
    public function ireplace1(array|string $search, array|string $subject, &$count = null): self { }
    public function ireplace2(array|string $search, array|string $replace, &$count = null): self { }
    public function ireplace3(array|string $search, array|string $replace, array|string $subject): self { }

    /** @see \str_pad() */
    public function str_pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad0(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad1(string $string, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad2(string $string, int $length, int $pad_type = STR_PAD_RIGHT): self { }
    public function str_pad3(string $string, int $length, string $pad_string = " "): self { }

    /** @see \str_pad() */
    public function pad(string $string, int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function pad0(int $length, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function pad1(string $string, string $pad_string = " ", int $pad_type = STR_PAD_RIGHT): self { }
    public function pad2(string $string, int $length, int $pad_type = STR_PAD_RIGHT): self { }
    public function pad3(string $string, int $length, string $pad_string = " "): self { }

    /** @see \str_repeat() */
    public function str_repeat(string $string, int $times): self { }
    public function str_repeat0(int $times): self { }
    public function str_repeat1(string $string): self { }

    /** @see \str_repeat() */
    public function repeat(string $string, int $times): self { }
    public function repeat0(int $times): self { }
    public function repeat1(string $string): self { }

    /** @see \str_replace() */
    public function str_replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function str_replace0(array|string $replace, array|string $subject, &$count = null): self { }
    public function str_replace1(array|string $search, array|string $subject, &$count = null): self { }
    public function str_replace2(array|string $search, array|string $replace, &$count = null): self { }
    public function str_replace3(array|string $search, array|string $replace, array|string $subject): self { }

    /** @see \str_replace() */
    public function replace(array|string $search, array|string $replace, array|string $subject, &$count = null): self { }
    public function replace0(array|string $replace, array|string $subject, &$count = null): self { }
    public function replace1(array|string $search, array|string $subject, &$count = null): self { }
    public function replace2(array|string $search, array|string $replace, &$count = null): self { }
    public function replace3(array|string $search, array|string $replace, array|string $subject): self { }

    /** @see \str_rot13() */
    public self $str_rot13;
    public function str_rot13(string $string): self { }
    public function str_rot130(): self { }

    /** @see \str_rot13() */
    public self $rot13;
    public function rot13(string $string): self { }
    public function rot130(): self { }

    /** @see \str_shuffle() */
    public self $str_shuffle;
    public function str_shuffle(string $string): self { }
    public function str_shuffle0(): self { }

    /** @see \str_shuffle() */
    public self $shuffle;
    public function shuffle(string $string): self { }
    public function shuffle0(): self { }

    /** @see \str_split() */
    public self $str_split;
    public function str_split(string $string, int $length = 1): self { }
    public function str_split0(int $length = 1): self { }
    public function str_split1(string $string): self { }

    /** @see \str_split() */
    public self $split;
    public function split(string $string, int $length = 1): self { }
    public function split0(int $length = 1): self { }
    public function split1(string $string): self { }

    /** @see \str_starts_with() */
    public function str_starts_with(string $haystack, string $needle): self { }
    public function str_starts_with0(string $needle): self { }
    public function str_starts_with1(string $haystack): self { }

    /** @see \str_starts_with() */
    public function starts_with(string $haystack, string $needle): self { }
    public function starts_with0(string $needle): self { }
    public function starts_with1(string $haystack): self { }

    /** @see \str_word_count() */
    public self $str_word_count;
    public function str_word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function str_word_count0(int $format = 0, ?string $characters = null): self { }
    public function str_word_count1(string $string, ?string $characters = null): self { }
    public function str_word_count2(string $string, int $format = 0): self { }

    /** @see \str_word_count() */
    public self $word_count;
    public function word_count(string $string, int $format = 0, ?string $characters = null): self { }
    public function word_count0(int $format = 0, ?string $characters = null): self { }
    public function word_count1(string $string, ?string $characters = null): self { }
    public function word_count2(string $string, int $format = 0): self { }

    /** @see \strchr() */
    public function strchr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strchr0(string $needle, bool $before_needle = false): self { }
    public function strchr1(string $haystack, bool $before_needle = false): self { }
    public function strchr2(string $haystack, string $needle): self { }

    /** @see \strcoll() */
    public function strcoll(string $string1, string $string2): self { }
    public function strcoll0(string $string2): self { }
    public function strcoll1(string $string1): self { }

    /** @see \strcspn() */
    public function strcspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strcspn0(string $characters, int $offset = 0, ?int $length = null): self { }
    public function strcspn1(string $string, int $offset = 0, ?int $length = null): self { }
    public function strcspn2(string $string, string $characters, ?int $length = null): self { }
    public function strcspn3(string $string, string $characters, int $offset = 0): self { }

    /** @see \strip_tags() */
    public self $strip_tags;
    public function strip_tags(string $string, array|string|null $allowed_tags = null): self { }
    public function strip_tags0(array|string|null $allowed_tags = null): self { }
    public function strip_tags1(string $string): self { }

    /** @see \stripcslashes() */
    public self $stripcslashes;
    public function stripcslashes(string $string): self { }
    public function stripcslashes0(): self { }

    /** @see \stripos() */
    public function stripos(string $haystack, string $needle, int $offset = 0): self { }
    public function stripos0(string $needle, int $offset = 0): self { }
    public function stripos1(string $haystack, int $offset = 0): self { }
    public function stripos2(string $haystack, string $needle): self { }

    /** @see \stripslashes() */
    public self $stripslashes;
    public function stripslashes(string $string): self { }
    public function stripslashes0(): self { }

    /** @see \stristr() */
    public function stristr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function stristr0(string $needle, bool $before_needle = false): self { }
    public function stristr1(string $haystack, bool $before_needle = false): self { }
    public function stristr2(string $haystack, string $needle): self { }

    /** @see \strnatcasecmp() */
    public function strnatcasecmp(string $string1, string $string2): self { }
    public function strnatcasecmp0(string $string2): self { }
    public function strnatcasecmp1(string $string1): self { }

    /** @see \strnatcmp() */
    public function strnatcmp(string $string1, string $string2): self { }
    public function strnatcmp0(string $string2): self { }
    public function strnatcmp1(string $string1): self { }

    /** @see \strpbrk() */
    public function strpbrk(string $string, string $characters): self { }
    public function strpbrk0(string $characters): self { }
    public function strpbrk1(string $string): self { }

    /** @see \strpos() */
    public function strpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strpos0(string $needle, int $offset = 0): self { }
    public function strpos1(string $haystack, int $offset = 0): self { }
    public function strpos2(string $haystack, string $needle): self { }

    /** @see \strrchr() */
    public function strrchr(string $haystack, string $needle): self { }
    public function strrchr0(string $needle): self { }
    public function strrchr1(string $haystack): self { }

    /** @see \strrev() */
    public self $strrev;
    public function strrev(string $string): self { }
    public function strrev0(): self { }

    /** @see \strripos() */
    public function strripos(string $haystack, string $needle, int $offset = 0): self { }
    public function strripos0(string $needle, int $offset = 0): self { }
    public function strripos1(string $haystack, int $offset = 0): self { }
    public function strripos2(string $haystack, string $needle): self { }

    /** @see \strrpos() */
    public function strrpos(string $haystack, string $needle, int $offset = 0): self { }
    public function strrpos0(string $needle, int $offset = 0): self { }
    public function strrpos1(string $haystack, int $offset = 0): self { }
    public function strrpos2(string $haystack, string $needle): self { }

    /** @see \strspn() */
    public function strspn(string $string, string $characters, int $offset = 0, ?int $length = null): self { }
    public function strspn0(string $characters, int $offset = 0, ?int $length = null): self { }
    public function strspn1(string $string, int $offset = 0, ?int $length = null): self { }
    public function strspn2(string $string, string $characters, ?int $length = null): self { }
    public function strspn3(string $string, string $characters, int $offset = 0): self { }

    /** @see \strstr() */
    public function strstr(string $haystack, string $needle, bool $before_needle = false): self { }
    public function strstr0(string $needle, bool $before_needle = false): self { }
    public function strstr1(string $haystack, bool $before_needle = false): self { }
    public function strstr2(string $haystack, string $needle): self { }

    /** @see \strtok() */
    public self $strtok;
    public function strtok(string $string, ?string $token = null): self { }
    public function strtok0(?string $token = null): self { }
    public function strtok1(string $string): self { }

    /** @see \strtolower() */
    public self $strtolower;
    public function strtolower(string $string): self { }
    public function strtolower0(): self { }

    /** @see \strtoupper() */
    public self $strtoupper;
    public function strtoupper(string $string): self { }
    public function strtoupper0(): self { }

    /** @see \strtr() */
    public function strtr(string $string, array|string $from, ?string $to = null): self { }
    public function strtr0(array|string $from, ?string $to = null): self { }
    public function strtr1(string $string, ?string $to = null): self { }
    public function strtr2(string $string, array|string $from): self { }

    /** @see \strval() */
    public self $strval;
    public function strval(mixed $value): self { }
    public function strval0(): self { }

    /** @see \substr() */
    public function substr(string $string, int $offset, ?int $length = null): self { }
    public function substr0(int $offset, ?int $length = null): self { }
    public function substr1(string $string, ?int $length = null): self { }
    public function substr2(string $string, int $offset): self { }

    /** @see \substr_compare() */
    public function substr_compare(string $haystack, string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare0(string $needle, int $offset, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare1(string $haystack, int $offset, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare2(string $haystack, string $needle, ?int $length = null, bool $case_insensitive = false): self { }
    public function substr_compare3(string $haystack, string $needle, int $offset, bool $case_insensitive = false): self { }
    public function substr_compare4(string $haystack, string $needle, int $offset, ?int $length = null): self { }

    /** @see \substr_count() */
    public function substr_count(string $haystack, string $needle, int $offset = 0, ?int $length = null): self { }
    public function substr_count0(string $needle, int $offset = 0, ?int $length = null): self { }
    public function substr_count1(string $haystack, int $offset = 0, ?int $length = null): self { }
    public function substr_count2(string $haystack, string $needle, ?int $length = null): self { }
    public function substr_count3(string $haystack, string $needle, int $offset = 0): self { }

}
