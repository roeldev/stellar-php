<?php declare(strict_types=1);

namespace Stellar\Events;

use Stellar\Exceptions\Common\InvalidType;
use Stellar\Common\Identify;
use Stellar\Common\StringUtil;
use Stellar\Common\Type;

/**
 * @see \UnitTests\Events\EventDispatcherTests
 */
final class EventDispatcher
{
    /**
     * Call the listener once, then remove it.
     */
    public const OPTION_ONCE = 1;

    /** @var object */
    private $_owner;

    /** @var string */
    private $_namespace;

    /** @var array<string,array> */
    private $_listeners = [];

    /** @var array<string,array> */
    private $_listenersPriority = [];

    /** @var array<string,string[]> */
    private $_subscribers = [];

    /**
     * @param object $owner
     * @param string $namespace
     * @throws InvalidType
     */
    public function __construct($owner, string $namespace)
    {
        if (!\is_object($owner)) {
            throw InvalidType::factory('object', Type::get($owner), 'owner')->create();
        }

        $this->_owner = $owner;
        $this->_namespace = StringUtil::unsuffix($namespace, '.');
    }

    /**
     * @return object
     */
    public function getOwner()
    {
        return $this->_owner;
    }

    public function getNamespace() : string
    {
        return $this->_namespace;
    }

    /**
     * Get all listeners that are added.
     */
    public function getAllListeners() : array
    {
        return $this->_listeners;
    }

    /**
     * Get all listeners for the specified type.
     */
    public function getListeners(string $type) : ?array
    {
        return $this->_listeners[ $type ] ?? null;
    }

    /**
     * Determine if there are listeners for the specified type.
     */
    public function hasListeners(string $type) : bool
    {
        return !empty($this->_listeners[ $type ] ?? null);
    }

    /**
     * Add a listener for the specified event. An id of the given callable is returned, which can be
     * used to remove the listener so it won't be triggered anymore.
     */
    public function addListener(
        string $type,
        callable $listener,
        int $priority = 0,
        int $options = 0
    ) : string {
        if (!isset($this->_listeners[ $type ])) {
            $this->_listeners[ $type ] = [];
            $this->_listenersPriority[ $type ] = [ $priority => [] ];
        }
        if (!isset($this->_listenersPriority[ $type ][ $priority ])) {
            $this->_listenersPriority[ $type ][ $priority ] = [];
            \krsort($this->_listenersPriority[ $type ], \SORT_NUMERIC);
        }

        $id = Identify::callable($listener);
        if (isset($this->_listeners[ $type ][ $id ])) {
            $this->removeEventListener($type, $id);
        }

        $this->_listeners[ $type ][ $id ] = [ $listener, $priority, $options ];
        $this->_listenersPriority[ $type ][ $priority ][] = $id;

        return $id;
    }

    /**
     * Adds the listeners from the subscriber to the events.
     *
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber) : void
    {
        $events = \call_user_func([ \get_class($subscriber), 'getSubscribedEvents' ]);
        $subscribed = [];

        foreach ($events as $type => $params) {
            // skip event types that are not within the dispatcher's namespace
            if (!StringUtil::startsWith($type, $this->_namespace)) {
                continue;
            }

            $listenerIds = [];

            if (\is_string($params)) {
                $listenerIds[] = $this->addListener($type, [ $subscriber, $params ]);
                continue;
            }

            foreach ($params as $param) {
                if (\is_string($param)) {
                    $listenerIds[] = $this->addListener($type, [ $subscriber, $param ]);
                }
                elseif (\is_array($param)) {
                    // add the subscriber object to the listener callback
                    $param[0] = [ $subscriber, $param[0] ];
                    // add the event type as first param
                    $param = \array_unshift($param, $type);

                    $listenerIds[] = $this->addListener(... $param);
                }
            }

            if ($listenerIds) {
                $subscribed[ $type ] = $listenerIds;
            }
        }

        if ($subscribed) {
            $this->_subscribers[ Identify::object($subscriber) ] = $subscribed;
        }
    }

    /**
     * Remove the listener for the event by either giving the exact same callable or the id which is
     * returned when the listener was added.
     *
     * @param string          $type
     * @param callable|string $listenerOrId
     */
    public function removeEventListener(string $type, $listenerOrId) : void
    {
        $id = null;
        if (\is_callable($listenerOrId)) {
            $id = Identify::callable($listenerOrId);
        }
        elseif (\is_string($listenerOrId)) {
            $id = $listenerOrId;
        }

        if (null === $id) {
            throw InvalidType::factory(
                '`callable` or `string`',
                Type::get($listenerOrId),
                'callableOrId'
            )->create();
        }

        $priority = $this->_listeners[ $type ][ $id ][1];
        $index = \array_search($id, $this->_listenersPriority[ $type ][ $priority ], true);

        unset(
            $this->_listenersPriority[ $type ][ $priority ][ $index ],
            $this->_listeners[ $type ][ $id ]
        );
    }

    public function removeEventSubscriber(EventSubscriberInterface $subscriber) : void
    {
        $subscriberId = Identify::object($subscriber);
        if (\array_key_exists($subscriberId, $this->_subscribers)) {
            $subscribed = $this->_subscribers[ $subscriberId ];
            unset($this->_subscribers[ $subscriberId ]);

            foreach ($subscribed as $type => $listenerIds) {
                foreach ($listenerIds as $id) {
                    unset($this->_listeners[ $type ][ $id ]);
                }
            }
        }
    }

    public function dispatch(string $type, ?Event $event = null) : void
    {
        $listeners = $this->_listenersPriority[ $type ] ?? null;
        if (empty($listeners)) {
            return;
        }

        if (null === $event) {
            $event = new Event();
        }

        foreach ($listeners as $listenerIds) {
            foreach ($listenerIds as $id) {
                [ $listener, $priority, $options ] = $this->_listeners[ $type ][ $id ];
                if ($event->isPropagationStopped()) {
                    break;
                }

                \call_user_func($listener, $event, $this);

                if ($options & self::OPTION_ONCE) {
                    unset($this->_listeners[ $type ][ $id ]);
                }
            }
        }
    }
}
