<?php declare(strict_types=1);

namespace UnitTests\Common;

use Stellar\Common\Contracts\InvokableInterface;

class InvokableFixture implements InvokableInterface
{
    public function __invoke()
    {
    }
}
