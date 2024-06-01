<?php
// @formatter:off

/**
 * stub for reflect_callable
 *
 *
 *
 * @used-by \reflect_callable()
 * @used-by \ryunosuke\Functions\reflect_callable()
 * @used-by \ryunosuke\Functions\Package\reflect_callable()
 */
class ReflectCallable extends ReflectionFunction implements Reflector, Stringable
{
    public $name;

    public function __invoke(...$args): mixed { }
    public function call($newThis = null, ...$args): mixed { }
    public function getDeclaration(): string { }
    public function getCode(): string { }
    public function isStatic(): bool { }
    public function getUsedVariables(): array { }
    public function __toString(): string { }
    public function isDisabled() { }
    public function invoke(mixed ...$args) { }
    public function invokeArgs(array $args) { }
    public function getClosure() { }
    public function inNamespace() { }
    public function isClosure() { }
    public function isDeprecated() { }
    public function isInternal() { }
    public function isUserDefined() { }
    public function isGenerator() { }
    public function isVariadic() { }
    public function getClosureThis() { }
    public function getClosureScopeClass() { }
    public function getClosureCalledClass() { }
    public function getDocComment() { }
    public function getEndLine() { }
    public function getExtension() { }
    public function getExtensionName() { }
    public function getFileName() { }
    public function getName() { }
    public function getNamespaceName() { }
    public function getNumberOfParameters() { }
    public function getNumberOfRequiredParameters() { }
    public function getParameters() { }
    public function getShortName() { }
    public function getStartLine() { }
    public function getStaticVariables() { }
    public function returnsReference() { }
    public function hasReturnType() { }
    public function getReturnType() { }
    public function getAttributes(?string $name = null, int $flags = 0): array { }
}
