<?php

namespace vendor\NS;

use ArrayObject;
use ArrayObject as AO;
use Main\{C1, C2 as xC2, Sub\sC};
use Main\Sub\C;
use Main\Sub\C as xC;
use Sub\Space;
use function array_chunk;
use function array_chunk as AC;
use function Main\{f1, f2 as xf2};
use function Main\Sub\F;
use function Main\Sub\F as xF;
use const DIRECTORY_SEPARATOR;
use const DIRECTORY_SEPARATOR as DS;
use const Main\{C1, C2 as xC2};
use const Main\Sub\C;
use const Main\Sub\C as xC;

// phpstorm の最適化で消えてしまうので無駄に使用しておく
new ArrayObject();
new AO();
new C();
new xC();
new C1();
new xC2();
new sC();
new Space\C();

array_chunk();
AC();
F();
xF();
f1();
xf2();
Space\F();

echo DIRECTORY_SEPARATOR;
echo DS;
echo C;
echo xC;
echo C1;
echo xC2;
echo Space\C;

$closure = function () {

};

$object = new class() extends AO {
};

define("other\\space\\CONST", 'dummy');
const nsC = 123;
function nsF()
{
    $use = 123;
    return function () use ($use) { };
}

class nsC extends \ArrayObject implements \IteratorAggregate
{
    use T;

    public function m()
    {
        $use = 123;
        return function () use ($use) { };
    }
}

interface nsI extends \IteratorAggregate
{
}

trait nsT
{
}
