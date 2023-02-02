<?php

namespace ryunosuke\Test\Package\Classobj;

class ParentClass
{
    protected function voidMethod(): void { noop(); }
}

/**
 * @property int $fuga
 * @method array hoge($arg)
 */
class ClassExtends extends ParentClass
{
    use Fields;

    public static $staticfield;

    private $field;

    private function privateMethod() { return "private:{$this->field}"; }

    public function publicMethod() { return "public:{$this->field}"; }

    public function overrideMethod1(string $arg1): string { return "overrideMethod1:{$arg1}"; }

    public function overrideMethod2(string $arg1): string { return "overrideMethod2:{$arg1}"; }

    public static function staticMethod() { return "static:" . self::$staticfield; }

    public function setFields(?string $field, string $privateField, string $protectedField, string $public_field): ?string
    {
        $this->field = $field;
        $this->privateField = $privateField;
        $this->protectedField = $protectedField;
        $this->publicField = $public_field;
        return 'OK';
    }
}

trait Fields
{
    static    $staticField;
    private   $privateField;
    protected $protectedField;
    public    $publicField;
}

interface Methods
{
    public function publicMethod();
}
