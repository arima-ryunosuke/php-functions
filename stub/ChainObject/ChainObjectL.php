<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectL
{
    /** @see \localtime() */
    public self $localtime;
    public function localtime(?int $timestamp = null, bool $associative = false): self { }
    public function localtime(bool $associative = false): self { }

    /** @see \long2ip() */
    public self $long2ip;
    public function long2ip(int $ip): self { }
    public function long2ip(): self { }

    /** @see \ltrim() */
    public self $ltrim;
    public function ltrim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function ltrim(string $characters = " \n\r\t\v\000"): self { }

    /** @see \lcfirst() */
    public self $lcfirst;
    public function lcfirst(string $string): self { }
    public function lcfirst(): self { }

    /** @see \lstat() */
    public self $lstat;
    public function lstat(string $filename): self { }
    public function lstat(): self { }

    /** @see \levenshtein() */
    public self $levenshtein;
    public function levenshtein(string $string1, string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }
    public function levenshtein(string $string2, int $insertion_cost = 1, int $replacement_cost = 1, int $deletion_cost = 1): self { }

    /** @see \linkinfo() */
    public self $linkinfo;
    public function linkinfo(string $path): self { }
    public function linkinfo(): self { }

    /** @see \link() */
    public self $link;
    public function link(string $target, string $link): self { }
    public function link(string $link): self { }

    /** @see \log1p() */
    public self $log1p;
    public function log1p(float $num): self { }
    public function log1p(): self { }

    /** @see \log() */
    public self $log;
    public function log(float $num, float $base = M_E): self { }
    public function log(float $base = M_E): self { }

    /** @see \log10() */
    public self $log10;
    public function log10(float $num): self { }
    public function log10(): self { }

    /** @see \last_key() */
    public self $last_key;
    public function last_key(iterable $array, $default = null): self { }
    public function last_key($default = null): self { }

    /** @see \last_value() */
    public self $last_value;
    public function last_value(iterable $array, $default = null): self { }
    public function last_value($default = null): self { }

    /** @see \last_keyvalue() */
    public self $last_keyvalue;
    public function last_keyvalue(iterable $array, $default = null): self { }
    public function last_keyvalue($default = null): self { }

    /** @see \lbind() */
    public self $lbind;
    public function lbind(callable $callable, ...$variadic): self { }
    public function lbind(...$variadic): self { }

    /** @see \ltsv_export() */
    public self $ltsv_export;
    public function ltsv_export(iterable $ltsvarray, $options = []): self { }
    public function ltsv_export($options = []): self { }

    /** @see \ltsv_import() */
    public self $ltsv_import;
    public function ltsv_import($ltsvstring, $options = []): self { }
    public function ltsv_import($options = []): self { }

}
