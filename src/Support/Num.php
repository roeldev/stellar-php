<?php declare(strict_types=1);

namespace Stellar\Support;

use Stellar\Common\StaticClass;

/**
 * @see \UnitTests\Common\NumberTests
 */
final class Num extends StaticClass
{
    public static function isOdd(int $int) : bool
    {
        return $int !== 0 && ($int % 2) === 1;
    }

    public static function isEven(int $int) : bool
    {
        return $int !== 0 && ($int % 2) === 0;
    }
}
