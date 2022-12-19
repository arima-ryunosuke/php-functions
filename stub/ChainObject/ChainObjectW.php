<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectW
{
    /** @see \wordwrap() */
    public self $wordwrap;
    public function wordwrap(string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }
    public function wordwrap(int $width = 75, string $break = "\n", bool $cut_long_words = false): self { }

}
