<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectO
{
    /** @see \output_add_rewrite_var() */
    public self $output_add_rewrite_var;
    public function output_add_rewrite_var(string $name, string $value): self { }
    public function output_add_rewrite_var(string $value): self { }

    /** @see \openlog() */
    public self $openlog;
    public function openlog(string $prefix, int $flags, int $facility): self { }
    public function openlog(int $flags, int $facility): self { }

    /** @see \ord() */
    public self $ord;
    public function ord(string $character): self { }
    public function ord(): self { }

    /** @see \opendir() */
    public self $opendir;
    public function opendir(string $directory, $context = null): self { }
    public function opendir($context = null): self { }

    /** @see \octdec() */
    public self $octdec;
    public function octdec(string $octal_string): self { }
    public function octdec(): self { }

    /** @see \object_dive() */
    public self $object_dive;
    public function object_dive($object, $path, $default = null, $delimiter = "."): self { }
    public function object_dive($path, $default = null, $delimiter = "."): self { }

    /** @see \ope_func() */
    public self $ope_func;
    public function ope_func($operator, ...$operands): self { }
    public function ope_func(...$operands): self { }

    /** @see \ob_capture() */
    public self $ob_capture;
    public function ob_capture(callable $callback, ...$variadic): self { }
    public function ob_capture(...$variadic): self { }

    /** @see \ob_include() */
    public self $ob_include;
    public function ob_include($include_file, iterable $array = []): self { }
    public function ob_include(iterable $array = []): self { }

    /** @see \optional() */
    public self $optional;
    public function optional($object, $expected = null): self { }
    public function optional($expected = null): self { }

}
