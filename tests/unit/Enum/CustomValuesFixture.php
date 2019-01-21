<?php declare(strict_types=1);

namespace UnitTests\Enum;

use Stellar\Enum\Enum;
use Stellar\Enum\EnumerablesList;

/**
 * A fixture class with custom values. Is used to check the reference from the constant to the value.
 *
 * @method static self FOO()
 * @method static self BAR()
 * @method static self BAZ()
 * @method static self FOZ()
 */
class CustomValuesFixture extends Enum
{
    public const FOO = 'f';

    public const BAR = 'b';

    public const BAZ = 'baz';

    public const FOZ = 567;

    public static function enum() : EnumerablesList
    {
        return EnumerablesList::instance(static::class, [
            self::FOZ => 'foz',
            self::BAR => 'bar',
            self::FOO => 'foo',
        ]);
    }
}
