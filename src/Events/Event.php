<?php declare(strict_types=1);

namespace Stellar\Events;

class Event
{
    private $_propagationStopped = false;

    /**
     * Stop event propagation. Once called, the even dispatcher stops calling any remaining
     * listeners.
     *
     * @return static
     */
    public function stopPropagation() : self
    {
        $this->_propagationStopped = true;

        return $this;
    }

    /**
     * Indicates if propagation is stopped. This will typically only be used by the dispatcher to
     * determine if the previous listener halted propagation.
     */
    public function isPropagationStopped() : bool
    {
        return $this->_propagationStopped;
    }
}
