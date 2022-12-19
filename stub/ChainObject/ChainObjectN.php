<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectN
{
    /** @see \nl2br() */
    public self $nl2br;
    public function nl2br(string $string, bool $use_xhtml = true): self { }
    public function nl2br(bool $use_xhtml = true): self { }

    /** @see \number_format() */
    public self $number_format;
    public function number_format(float $num, int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }
    public function number_format(int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ","): self { }

    /** @see \next_key() */
    public self $next_key;
    public function next_key(iterable $array, $key = null): self { }
    public function next_key($key = null): self { }

    /** @see \nbind() */
    public self $nbind;
    public function nbind(callable $callable, $n, ...$variadic): self { }
    public function nbind($n, ...$variadic): self { }

    /** @see \not_func() */
    public self $not_func;
    public function not_func(callable $callable): self { }
    public function not_func(): self { }

    /** @see \namedcallize() */
    public self $namedcallize;
    public function namedcallize(callable $callable, $defaults = []): self { }
    public function namedcallize($defaults = []): self { }

    /** @see \normal_rand() */
    public self $normal_rand;
    public function normal_rand($average = 0.0, $std_deviation = 1.0): self { }
    public function normal_rand($std_deviation = 1.0): self { }

    /** @see \namespace_split() */
    public self $namespace_split;
    public function namespace_split($string): self { }
    public function namespace_split(): self { }

    /** @see \ngram() */
    public self $ngram;
    public function ngram($string, $N, $encoding = "UTF-8"): self { }
    public function ngram($N, $encoding = "UTF-8"): self { }

    /** @see \number_serial() */
    public self $number_serial;
    public function number_serial($numbers, $step = 1, $separator = null, $doSort = true): self { }
    public function number_serial($step = 1, $separator = null, $doSort = true): self { }

    /** @see \numberify() */
    public self $numberify;
    public function numberify($var, $decimal = false): self { }
    public function numberify($decimal = false): self { }

    /** @see \numval() */
    public self $numval;
    public function numval($var, $base = 10): self { }
    public function numval($base = 10): self { }

}
