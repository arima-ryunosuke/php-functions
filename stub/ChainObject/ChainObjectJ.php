<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectJ
{
    /** @see \join() */
    public self $join;
    public function join(array|string $separator, ?array $array = null): self { }
    public function join(?array $array = null): self { }

    /** @see \json_export() */
    public self $json_export;
    public function json_export($value, $options = []): self { }
    public function json_export($options = []): self { }

    /** @see \json_import() */
    public self $json_import;
    public function json_import($value, $options = []): self { }
    public function json_import($options = []): self { }

}
