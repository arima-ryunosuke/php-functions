<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectE
{
    /** @see \extract() */
    public self $extract;
    public function extract(array &$array, int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }
    public function extract(int $flags = EXTR_OVERWRITE, string $prefix = ""): self { }

    /** @see \error_log() */
    public self $error_log;
    public function error_log(string $message, int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }
    public function error_log(int $message_type = 0, ?string $destination = null, ?string $additional_headers = null): self { }

    /** @see \explode() */
    public self $explode;
    public function explode(string $separator, string $string, int $limit = PHP_INT_MAX): self { }
    public function explode(string $string, int $limit = PHP_INT_MAX): self { }

    /** @see \exec() */
    public self $exec;
    public function exec(string $command, &$output = null, &$result_code = null): self { }
    public function exec(&$output = null, &$result_code = null): self { }

    /** @see \escapeshellcmd() */
    public self $escapeshellcmd;
    public function escapeshellcmd(string $command): self { }
    public function escapeshellcmd(): self { }

    /** @see \escapeshellarg() */
    public self $escapeshellarg;
    public function escapeshellarg(string $arg): self { }
    public function escapeshellarg(): self { }

    /** @see \expm1() */
    public self $expm1;
    public function expm1(float $num): self { }
    public function expm1(): self { }

    /** @see \exp() */
    public self $exp;
    public function exp(float $num): self { }
    public function exp(): self { }

    /** @see \eval_func() */
    public self $eval_func;
    public function eval_func($expression, ...$variadic): self { }
    public function eval_func(...$variadic): self { }

    /** @see \ends_with() */
    public self $ends_with;
    public function ends_with($string, $with, $case_insensitivity = false): self { }
    public function ends_with($with, $case_insensitivity = false): self { }

    /** @see \evaluate() */
    public self $evaluate;
    public function evaluate($phpcode, $contextvars = [], $cachesize = 256): self { }
    public function evaluate($contextvars = [], $cachesize = 256): self { }

    /** @see \error() */
    public self $error;
    public function error($message, $destination = null): self { }
    public function error($destination = null): self { }

    /** @see \encrypt() */
    public self $encrypt;
    public function encrypt($plaindata, $password, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt($password, $cipher = "aes-256-gcm", &$tag = ""): self { }

}
