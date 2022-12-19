<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectQ
{
    /** @see \quotemeta() */
    public self $quotemeta;
    public function quotemeta(string $string): self { }
    public function quotemeta(): self { }

    /** @see \quoted_printable_decode() */
    public self $quoted_printable_decode;
    public function quoted_printable_decode(string $string): self { }
    public function quoted_printable_decode(): self { }

    /** @see \quoted_printable_encode() */
    public self $quoted_printable_encode;
    public function quoted_printable_encode(string $string): self { }
    public function quoted_printable_encode(): self { }

    /** @see \quoteexplode() */
    public self $quoteexplode;
    public function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = "\\"): self { }
    public function quoteexplode($string, $limit = null, $enclosures = "'\"", $escape = "\\"): self { }

}
