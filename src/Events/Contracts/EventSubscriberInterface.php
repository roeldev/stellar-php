<?php declare(strict_types=1);

namespace Stellar\Events\Contracts;

interface EventSubscriberInterface
{
    /**
     * Returns an array of events of which this subscriber wants to listen to.
     *
     * Example:
     *  * [ 'some.event' => 'listenerMethod' ]
     *  * [ 'some.event' => ['listenerMethod', $options] ]
     *  * [ 'some.event' => ['listenerMethod', $options], ['anotherListenerMethod'] ]
     *
     * @return array<string,mixed>
     */
    public static function getSubscribedEvents() : array;
}
