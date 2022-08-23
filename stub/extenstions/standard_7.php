<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait standard_7
{
    /** @see \substr_replace() */
    public function substr_replace(array|string $string, array|string $replace, array|int $offset, array|int|null $length = null): self { }
    public function substr_replace0(array|string $replace, array|int $offset, array|int|null $length = null): self { }
    public function substr_replace1(array|string $string, array|int $offset, array|int|null $length = null): self { }
    public function substr_replace2(array|string $string, array|string $replace, array|int|null $length = null): self { }
    public function substr_replace3(array|string $string, array|string $replace, array|int $offset): self { }

    /** @see \symlink() */
    public function symlink(string $target, string $link): self { }
    public function symlink0(string $link): self { }
    public function symlink1(string $target): self { }

    /** @see \syslog() */
    public function syslog(int $priority, string $message): self { }
    public function syslog0(string $message): self { }
    public function syslog1(int $priority): self { }

    /** @see \system() */
    public self $system;
    public function system(string $command, &$result_code = null): self { }
    public function system0(&$result_code = null): self { }
    public function system1(string $command): self { }

    /** @see \tan() */
    public self $tan;
    public function tan(float $num): self { }
    public function tan0(): self { }

    /** @see \tanh() */
    public self $tanh;
    public function tanh(float $num): self { }
    public function tanh0(): self { }

    /** @see \tempnam() */
    public function tempnam(string $directory, string $prefix): self { }
    public function tempnam0(string $prefix): self { }
    public function tempnam1(string $directory): self { }

    /** @see \time_nanosleep() */
    public function time_nanosleep(int $seconds, int $nanoseconds): self { }
    public function time_nanosleep0(int $nanoseconds): self { }
    public function time_nanosleep1(int $seconds): self { }

    /** @see \time_sleep_until() */
    public self $time_sleep_until;
    public function time_sleep_until(float $timestamp): self { }
    public function time_sleep_until0(): self { }

    /** @see \touch() */
    public self $touch;
    public function touch(string $filename, ?int $mtime = null, ?int $atime = null): self { }
    public function touch0(?int $mtime = null, ?int $atime = null): self { }
    public function touch1(string $filename, ?int $atime = null): self { }
    public function touch2(string $filename, ?int $mtime = null): self { }

    /** @see \trim() */
    public self $trim;
    public function trim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function trim0(string $characters = " \n\r\t\v\000"): self { }
    public function trim1(string $string): self { }

    /** @see \uasort() */
    public function uasort(array &$array, callable $callback): self { }
    public function uasort0(callable $callback): self { }
    public function uasort1(array &$array): self { }
    public function uasortP(array &$array, callable $callback): self { }
    public function uasort0P(callable $callback): self { }
    public function uasort1P(array &$array): self { }
    public function uasortE(array &$array, callable $callback): self { }
    public function uasort0E(callable $callback): self { }
    public function uasort1E(array &$array): self { }

    /** @see \ucfirst() */
    public self $ucfirst;
    public function ucfirst(string $string): self { }
    public function ucfirst0(): self { }

    /** @see \ucwords() */
    public self $ucwords;
    public function ucwords(string $string, string $separators = " \t\r\n\f\v"): self { }
    public function ucwords0(string $separators = " \t\r\n\f\v"): self { }
    public function ucwords1(string $string): self { }

    /** @see \uksort() */
    public function uksort(array &$array, callable $callback): self { }
    public function uksort0(callable $callback): self { }
    public function uksort1(array &$array): self { }
    public function uksortP(array &$array, callable $callback): self { }
    public function uksort0P(callable $callback): self { }
    public function uksort1P(array &$array): self { }
    public function uksortE(array &$array, callable $callback): self { }
    public function uksort0E(callable $callback): self { }
    public function uksort1E(array &$array): self { }

    /** @see \umask() */
    public function umask(?int $mask = null): self { }
    public function umask0(): self { }

    /** @see \uniqid() */
    public function uniqid(string $prefix = "", bool $more_entropy = false): self { }
    public function uniqid0(bool $more_entropy = false): self { }
    public function uniqid1(string $prefix = ""): self { }

    /** @see \unlink() */
    public self $unlink;
    public function unlink(string $filename, $context = null): self { }
    public function unlink0($context = null): self { }
    public function unlink1(string $filename): self { }

    /** @see \unpack() */
    public function unpack(string $format, string $string, int $offset = 0): self { }
    public function unpack0(string $string, int $offset = 0): self { }
    public function unpack1(string $format, int $offset = 0): self { }
    public function unpack2(string $format, string $string): self { }

    /** @see \unregister_tick_function() */
    public self $unregister_tick_function;
    public function unregister_tick_function(callable $callback): self { }
    public function unregister_tick_function0(): self { }
    public function unregister_tick_functionP(callable $callback): self { }
    public function unregister_tick_function0P(): self { }
    public function unregister_tick_functionE(callable $callback): self { }
    public function unregister_tick_function0E(): self { }

    /** @see \unserialize() */
    public self $unserialize;
    public function unserialize(string $data, array $options = []): self { }
    public function unserialize0(array $options = []): self { }
    public function unserialize1(string $data): self { }

    /** @see \urldecode() */
    public self $urldecode;
    public function urldecode(string $string): self { }
    public function urldecode0(): self { }

    /** @see \urlencode() */
    public self $urlencode;
    public function urlencode(string $string): self { }
    public function urlencode0(): self { }

    /** @see \usleep() */
    public self $usleep;
    public function usleep(int $microseconds): self { }
    public function usleep0(): self { }

    /** @see \usort() */
    public function usort(array &$array, callable $callback): self { }
    public function usort0(callable $callback): self { }
    public function usort1(array &$array): self { }
    public function usortP(array &$array, callable $callback): self { }
    public function usort0P(callable $callback): self { }
    public function usort1P(array &$array): self { }
    public function usortE(array &$array, callable $callback): self { }
    public function usort0E(callable $callback): self { }
    public function usort1E(array &$array): self { }

    /** @see \utf8_decode() */
    public self $utf8_decode;
    public function utf8_decode(string $string): self { }
    public function utf8_decode0(): self { }

    /** @see \utf8_encode() */
    public self $utf8_encode;
    public function utf8_encode(string $string): self { }
    public function utf8_encode0(): self { }

    /** @see \var_dump() */
    public self $var_dump;
    public function var_dump(mixed $value, mixed ...$values): self { }
    public function var_dump0(mixed ...$values): self { }
    public function var_dump1(mixed $value): self { }

    /** @see \var_export() */
    public self $var_export;
    public function var_export(mixed $value, bool $return = false): self { }
    public function var_export0(bool $return = false): self { }
    public function var_export1(mixed $value): self { }

    /** @see \version_compare() */
    public function version_compare(string $version1, string $version2, ?string $operator = null): self { }
    public function version_compare0(string $version2, ?string $operator = null): self { }
    public function version_compare1(string $version1, ?string $operator = null): self { }
    public function version_compare2(string $version1, string $version2): self { }

    /** @see \vfprintf() */
    public function vfprintf($stream, string $format, array $values): self { }
    public function vfprintf0(string $format, array $values): self { }
    public function vfprintf1($stream, array $values): self { }
    public function vfprintf2($stream, string $format): self { }

    /** @see \vprintf() */
    public function vprintf(string $format, array $values): self { }
    public function vprintf0(array $values): self { }
    public function vprintf1(string $format): self { }

    /** @see \vsprintf() */
    public function vsprintf(string $format, array $values): self { }
    public function vsprintf0(array $values): self { }
    public function vsprintf1(string $format): self { }

    /** @see \wordwrap() */
    public self $wordwrap;
    public function wordwrap(string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }
    public function wordwrap0(int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }
    public function wordwrap1(string $string, string $break = "\n", bool $cut_long_words = false): self { }
    public function wordwrap2(string $string, int $width = 75, bool $cut_long_words = false): self { }
    public function wordwrap3(string $string, int $width = 75, string $break = "\n"): self { }

}
