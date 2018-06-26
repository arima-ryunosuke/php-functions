<?php

namespace ryunosuke\Test;

use PHPUnit\Framework\TestCase;
use ryunosuke\Functions\Package\Funchand;

class AbstractTestCase extends TestCase
{
    /**
     * 例外が投げられたかアサーション
     *
     * @param string|\Exception $e
     * @param callable $callback
     */
    public static function assertException($e, $callback)
    {
        if (is_string($e)) {
            if (class_exists($e)) {
                $ref = new \ReflectionClass($e);
                $e = $ref->newInstanceWithoutConstructor();
            }
            else {
                $e = new \Exception($e);
            }
        }

        try {
            $callback(...array_slice(func_get_args(), 2));
        }
        catch (\Exception $ex) {
            // 型は常に判定
            self::assertInstanceOf(get_class($e), $ex);
            // コードは指定されていたときのみ
            if ($e->getCode() > 0) {
                self::assertEquals($e->getCode(), $ex->getCode());
            }
            // メッセージも指定されていたときのみ
            if (strlen($e->getMessage()) > 0) {
                self::assertContains($e->getMessage(), $ex->getMessage());
            }
            return;
        }
        self::fail(get_class($e) . ' is not thrown.');
    }

    /**
     * 範囲チェックアサーション
     *
     * @param mixed $min
     * @param mixed $max
     * @param mixed $actual
     */
    public static function assertRange($min, $max, $actual)
    {
        self::assertGreaterThan($min, $actual);
        self::assertLessThan($max, $actual);
    }

    public function __invoke($f)
    {
        return Funchand::closurize($f);
    }
}
