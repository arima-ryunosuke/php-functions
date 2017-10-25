<?php

abstract class AbstractConcrete
{
    public static function staticMethod($a = null)
    {
        return __METHOD__;
    }

    public function instanceMethod($a = null)
    {
        return __METHOD__;
    }
}

/**
 * 汎用テスト用クラス
 */
class Concrete extends AbstractConcrete
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __invoke($a = null)
    {
        return __METHOD__;
    }

    public static function staticMethod($a = null)
    {
        return __METHOD__;
    }

    public function instanceMethod($a = null)
    {
        return __METHOD__;
    }

    public function getName($prefix = '', $upper = false)
    {
        $name = $this->name;
        if (strlen($prefix)) {
            $name = $prefix . $name;
        }
        if ($upper) {
            $name = strtoupper($name);
        }
        return $name;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}

// php 7 の ParseError を模倣したクラス
if (!class_exists('ParseError', false)) {
    class ParseError extends \Exception
    {

    }
}
