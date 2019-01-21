<?php declare(strict_types=1);

namespace Stellar\Common\Testing\Constraints;

use PHPUnit\Framework\Constraint\IsInstanceOf;
use Stellar\Common\Contracts\SingletonInterface;

class IsSingleton extends IsInstanceOf
{
    public function __construct()
    {
        parent::__construct(SingletonInterface::class);
    }

    protected function matches($other) : bool
    {
        return parent::matches($other)
               || (\is_string($other) && \is_a($other, SingletonInterface::class, true));
    }
}
