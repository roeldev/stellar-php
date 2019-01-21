<?php declare(strict_types=1);

namespace Stellar\Events;

interface EventDispatchableInterface
{
    public function eventDispatcher() : EventDispatcher;
}
