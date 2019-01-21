<?php declare(strict_types=1);

namespace UnitTests\Support;

use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Traits\ToString;

class StringableFixture implements StringableInterface
{
    use ToString;

    public function __toString() : string
    {
        return 'foobar';
    }
}
