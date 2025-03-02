<?php
// @formatter:off

/**
 * stub for php_tokens
 *
 *
 *
 * @used-by \php_tokens()
 * @used-by \ryunosuke\Functions\php_tokens()
 * @used-by \ryunosuke\Functions\Package\php_tokens()
 */
class PhpTokens extends PhpToken implements Stringable
{
    public $tokens;
    public $index;
    public $id;
    public $text;
    public $line;
    public $pos;

    public function __debugInfo(): array { }
    public function clone(...$newparams): self { }
    public function name(): string { }
    public function prev($condition = null): ?self { }
    public function next($condition = null): ?self { }
    public function find($condition): ?self { }
    public function end(): self { }
    public function contents(?int $end = null): string { }
    public function resolve($ref): string { }
    public function tokenize(string $code, int $flags = 0): array { }
    public function is($kind): bool { }
    public function isIgnorable(): bool { }
    public function getTokenName(): ?string { }
    public function __toString(): string { }
}
