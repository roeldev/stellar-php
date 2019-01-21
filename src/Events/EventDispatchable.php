<?php declare(strict_types=1);

namespace Stellar\Events;

/**
 * Add convenient event listener shortcuts to your class.
 */
trait EventDispatchable
{
    abstract public function eventDispatcher() : EventDispatcher;

    /**
     * @see EventDispatcher::addListener()
     */
    final public function on(string $type, callable $listener) : self
    {
        $this->eventDispatcher()->addListener($type, $listener);

        return $this;
    }

    /**
     * @see EventDispatcher::addListener()
     */
    final public function once(string $type, callable $listener) : self
    {
        $this->eventDispatcher()->addListener($type, $listener, EventDispatcher::OPTION_ONCE);

        return $this;
    }
}
