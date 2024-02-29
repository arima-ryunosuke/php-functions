<?php

namespace ryunosuke\Test\Package\files\enums;

use ryunosuke\polyfill\enum\traits\Compatible;
use ryunosuke\polyfill\enum\traits\Initializable;

/**
 * @method static self Case1()
 */
final class IntEnum extends \ryunosuke\polyfill\enum\IntBackedEnum
{
    use Compatible;
    use Initializable;

    const Case1 = 1;
}
