<?php declare(strict_types=1);

namespace UnitTests\Enum;

use Stellar\Enum\Enum;

/**
 * @method static self FOO()
 * @method static self BAR()
 * @method static self BAZ()
 * @method static self FOZ()
 */
class EnumFixture extends Enum
{
    public const FOO = 'foo';
    public const BAR = 'bar';
    public const BAZ = 'baz';
    public const FOZ = 'foz';
}
