<?php declare(strict_types=1);

namespace Stellar\Events\Contracts;

interface EventDispatchableInterface
{
    public function eventDispatcher() : EventDispatcher;
}
