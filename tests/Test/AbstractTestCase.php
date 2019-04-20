<?php

namespace ryunosuke\Test;

use PHPUnit\Framework\TestCase;

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

        $args = array_slice(func_get_args(), 2);
        $message = json_encode($args, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        try {
            $callback(...$args);
        }
        catch (\Throwable $ex) {
            // 型は常に判定
            self::assertInstanceOf(get_class($e), $ex, $message);
            // コードは指定されていたときのみ
            if ($e->getCode() > 0) {
                self::assertEquals($e->getCode(), $ex->getCode(), $message);
            }
            // メッセージも指定されていたときのみ
            if (strlen($e->getMessage()) > 0) {
                self::assertContains($e->getMessage(), $ex->getMessage(), $message);
            }
            return;
        }
        self::fail(get_class($e) . ' is not thrown.' . $message);
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

    /**
     * 部分配列アサーション
     *
     * @param array $expected
     * @param iterable $actual
     * @param bool $strict
     * @param string $message
     */
    public static function assertSubarray($expected, $actual, $strict = false, $message = '')
    {
        if ($actual instanceof \Traversable) {
            $actual = iterator_to_array($actual);
        }

        $expected = array_replace_recursive($actual, $expected);

        if ($strict) {
            self::assertSame($expected, $actual);
        }
        else {
            self::assertEquals($expected, $actual);
        }
    }
}
