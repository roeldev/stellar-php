<?php declare(strict_types=1);

namespace Stellar\Common\Testing\Constraints;

use PHPUnit\Framework\Constraint\IsInstanceOf;
use Stellar\Common\Types\StaticClass;

class IsStaticClass extends IsInstanceOf
{
    public function __construct()
    {
        parent::__construct(StaticClass::class);
    }

    protected function matches($other) : bool
    {
        return (\is_string($other) && \is_a($other, StaticClass::class, true));
    }
}
