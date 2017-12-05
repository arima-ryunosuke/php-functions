<?php
namespace ryunosuke\Test;

use ryunosuke\Functions\NullObject;

class NullObjectTest extends \ryunosuke\Test\AbstractTestCase
{
    function test_all()
    {
        $null = new NullObject();
        $ex = new \DomainException('called NullObject#');

        // __isset
        $this->assertFalse(isset($null->hoge));
        // __unset
        $this->assertException($ex, function () use ($null) { unset($null->hoge); });
        // __get
        $this->assertNull($null->hoge);
        // __set
        $this->assertException($ex, function () use ($null) { $null->hoge = 'hoge'; });
        // __call
        $this->assertNull($null->hoge());
        // __invoke
        $this->assertNull($null());
        // __toString
        $this->assertSame('', "$null");
        // offsetExists
        $this->assertTrue(empty($null['hoge']));
        // offsetGet
        $this->assertNull($null['hoge']);
        // offsetSet
        $this->assertException($ex, function () use ($null) { $null['hoge'] = 'hoge'; });
        // offsetUnset
        $this->assertException($ex, function () use ($null) { unset($null['hoge']); });
        // getIterator
        $this->assertEmpty(iterator_to_array($null));
    }
}
