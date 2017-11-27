<?php

namespace ryunosuke\Test;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
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
                // 5.6 未満では内部クラスを newInstanceWithoutConstructor できない
                if ($ref->isInternal()) {
                    $e = $ref->newInstance();
                }
                else {
                    $e = $ref->newInstanceWithoutConstructor();
                }
            }
            else {
                $e = new \Exception($e);
            }
        }

        try {
            call_user_func_array($callback, array_slice(func_get_args(), 2));
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

    function tearDown()
    {
        $name = preg_replace('#^test_#', '', $this->getName());
        if (is_callable($name)) {
            $ref = new \ReflectionFunction($name);
            $doccomment = $ref->getDocComment();
            $dir = basename($ref->getFileName(), '.php');

            preg_match_all('#```php(.*?)```#us', $doccomment, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $exfile = __DIR__ . '/../example-code/' . $dir . '/' . $name . '.php';
                @mkdir(dirname($exfile));
                file_put_contents($exfile, '<?php ' . preg_replace('#^ \* ?#um', '', $match[1]));
                include $exfile;
            }
        }
    }
}
