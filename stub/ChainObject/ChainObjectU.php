<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectU
{
    /** @see \usort() */
    public self $usort;
    public function usort(array &$array, callable $callback): self { }
    public function usort(callable $callback): self { }

    /** @see \uasort() */
    public self $uasort;
    public function uasort(array &$array, callable $callback): self { }
    public function uasort(callable $callback): self { }

    /** @see \uksort() */
    public self $uksort;
    public function uksort(array &$array, callable $callback): self { }
    public function uksort(callable $callback): self { }

    /** @see \usleep() */
    public self $usleep;
    public function usleep(int $microseconds): self { }
    public function usleep(): self { }

    /** @see \unregister_tick_function() */
    public self $unregister_tick_function;
    public function unregister_tick_function(callable $callback): self { }
    public function unregister_tick_function(): self { }

    /** @see \ucfirst() */
    public self $ucfirst;
    public function ucfirst(string $string): self { }
    public function ucfirst(): self { }

    /** @see \ucwords() */
    public self $ucwords;
    public function ucwords(string $string, string $separators = " \t\r\n\f\v"): self { }
    public function ucwords(string $separators = " \t\r\n\f\v"): self { }

    /** @see \utf8_encode() */
    public self $utf8_encode;
    public function utf8_encode(string $string): self { }
    public function utf8_encode(): self { }

    /** @see \utf8_decode() */
    public self $utf8_decode;
    public function utf8_decode(string $string): self { }
    public function utf8_decode(): self { }

    /** @see \umask() */
    public self $umask;
    public function umask(?int $mask = null): self { }
    public function umask(): self { }

    /** @see \unlink() */
    public self $unlink;
    public function unlink(string $filename, $context = null): self { }
    public function unlink($context = null): self { }

    /** @see \unpack() */
    public self $unpack;
    public function unpack(string $format, string $string, int $offset = 0): self { }
    public function unpack(string $string, int $offset = 0): self { }

    /** @see \uniqid() */
    public self $uniqid;
    public function uniqid(string $prefix = "", bool $more_entropy = false): self { }
    public function uniqid(bool $more_entropy = false): self { }

    /** @see \urlencode() */
    public self $urlencode;
    public function urlencode(string $string): self { }
    public function urlencode(): self { }

    /** @see \urldecode() */
    public self $urldecode;
    public function urldecode(string $string): self { }
    public function urldecode(): self { }

    /** @see \unserialize() */
    public self $unserialize;
    public function unserialize(string $data, array $options = []): self { }
    public function unserialize(array $options = []): self { }

    /** @see \unique_string() */
    public self $unique_string;
    public function unique_string($source, $initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }
    public function unique_string($initial = null, $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"): self { }

}
