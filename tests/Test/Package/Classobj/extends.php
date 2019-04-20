<?php

namespace ryunosuke\Test\Package\Classobj;

/**
 * @property int $fuga
 * @method array hoge($arg)
 */
class ClassExtends
{
    use Fields;

    public static $staticfield;

    private $field;

    private function privateMethod() { return "private:{$this->field}"; }

    public function publicMethod() { return "public:{$this->field}"; }

    public static function staticMethod() { return "static:" . self::$staticfield; }

    public function setFields($field, $privateField, $protectedField, $public_field)
    {
        $this->field = $field;
        $this->privateField = $privateField;
        $this->protectedField = $protectedField;
        $this->publicField = $public_field;
    }
}

trait Fields
{
    static    $staticField;
    private   $privateField;
    protected $protectedField;
    public    $publicField;
}
