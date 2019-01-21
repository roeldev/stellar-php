<?php declare(strict_types=1);

namespace Stellar\Common\Testing;

trait CaptureMethodCalls
{
    /** @var CallStack */
    private $_callStack;

    /**
     * Capture all method calls and their given arguments.
     */
    final public function __call(string $method, array $arguments) : void
    {
        $this->getCallStack()->add($method, $arguments);
    }

    /**
     * Get the call trace list.
     */
    final public function getCallStack() : CallStack
    {
        if (!$this->_callStack) {
            $this->_callStack = new CallStack($this);
        }

        return $this->_callStack;
    }
}
