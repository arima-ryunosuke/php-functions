<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectT
{
    /** @see \time_nanosleep() */
    public self $time_nanosleep;
    public function time_nanosleep(int $seconds, int $nanoseconds): self { }
    public function time_nanosleep(int $nanoseconds): self { }

    /** @see \time_sleep_until() */
    public self $time_sleep_until;
    public function time_sleep_until(float $timestamp): self { }
    public function time_sleep_until(): self { }

    /** @see \trim() */
    public self $trim;
    public function trim(string $string, string $characters = " \n\r\t\v\000"): self { }
    public function trim(string $characters = " \n\r\t\v\000"): self { }

    /** @see \tempnam() */
    public self $tempnam;
    public function tempnam(string $directory, string $prefix): self { }
    public function tempnam(string $prefix): self { }

    /** @see \touch() */
    public self $touch;
    public function touch(string $filename, ?int $mtime = null, ?int $atime = null): self { }
    public function touch(?int $mtime = null, ?int $atime = null): self { }

    /** @see \tan() */
    public self $tan;
    public function tan(float $num): self { }
    public function tan(): self { }

    /** @see \tanh() */
    public self $tanh;
    public function tanh(float $num): self { }
    public function tanh(): self { }

    /** @see \type_exists() */
    public self $type_exists;
    public function type_exists($typename, $autoload = true): self { }
    public function type_exists($autoload = true): self { }

    /** @see \tmpname() */
    public self $tmpname;
    public function tmpname($prefix = "rft", $dir = null): self { }
    public function tmpname($dir = null): self { }

    /** @see \throws() */
    public self $throws;
    public function throws($ex): self { }
    public function throws(): self { }

    /** @see \throw_if() */
    public self $throw_if;
    public function throw_if($flag, $ex, ...$ex_args): self { }
    public function throw_if($ex, ...$ex_args): self { }

    /** @see \try_null() */
    public self $try_null;
    public function try_null($try, ...$variadic): self { }
    public function try_null(...$variadic): self { }

    /** @see \try_return() */
    public self $try_return;
    public function try_return($try, ...$variadic): self { }
    public function try_return(...$variadic): self { }

    /** @see \try_catch() */
    public self $try_catch;
    public function try_catch($try, $catch = null, ...$variadic): self { }
    public function try_catch($catch = null, ...$variadic): self { }

    /** @see \try_finally() */
    public self $try_finally;
    public function try_finally($try, $finally = null, ...$variadic): self { }
    public function try_finally($finally = null, ...$variadic): self { }

    /** @see \try_catch_finally() */
    public self $try_catch_finally;
    public function try_catch_finally($try, $catch = null, $finally = null, ...$variadic): self { }
    public function try_catch_finally($catch = null, $finally = null, ...$variadic): self { }

    /** @see \timer() */
    public self $timer;
    public function timer(callable $callable, $count = 1): self { }
    public function timer($count = 1): self { }

}
