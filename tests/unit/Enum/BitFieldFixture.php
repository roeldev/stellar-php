<?php declare(strict_types=1);

namespace UnitTests\Enum;

use Stellar\Enum\BitField;

class BitFieldFixture extends BitField
{
    public const EXECUTE = 1;
    public const WRITE   = 2;
    public const READ    = 4;
}
