<?php declare(strict_types=1);

namespace Stellar\Container;

use Psr\Container\ContainerInterface;
use Stellar\Container\Exceptions\NotFound;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Support\Type;

/**
 * @see \UnitTests\Container\BasicContainerTests
 */
class BasicContainer implements ContainerInterface, \Countable
{
    /**
     * An array with registered services with the given alias as key.
     *
     * @var object[]
     */
    protected $_services = [];

    /**
     * @param string $alias
     *
     * @throws NotFound
     * @return object
     */
    public function get($alias)
    {
        if (!$this->has($alias)) {
            throw NotFound::factory($alias)->create();
        }

        return $this->_services[ $alias ];
    }

    /**
     * Get the alias of a registered service, or `false` when not found.
     *
     * @param object $service
     * @return string|false
     */
    public function getAlias($service)
    {
        $result = \array_search($service, $this->_services, true);

        return \is_string($result) ? $result : false;
    }

    /**
     * Get an array with all used aliases.
     *
     * @return string[]
     */
    public function getAliases() : array
    {
        return \array_keys($this->_services);
    }

    /**
     * Indicates if the container has the service.
     *
     * @param string|object $aliasOrService
     */
    public function has($aliasOrService) : bool
    {
        $result = false;
        if (\is_string($aliasOrService)) {
            $result = isset($this->_services[ $aliasOrService ]);
        }
        elseif (\is_object($aliasOrService)) {
            $result = \in_array($aliasOrService, $this->_services, true);
        }

        return $result;
    }

    /**
     * Set a service with the given alias in the container. It will replace any existing service
     * already registered with the same alias.
     *
     * @param string $alias
     * @param object $service
     * @return object
     */
    public function set(string $alias, $service)
    {
        if (!\is_object($service)) {
            throw InvalidType::factory('object', Type::get($service), 'service')->create();
        }

        $this->_services[ $alias ] = $service;

        return $service;
    }

    /**
     * Unset multiple aliases or services from the container.
     *
     * @param mixed $aliasOrService
     */
    public function unset(...$aliasOrService) : array
    {
        $result = [];
        foreach ($aliasOrService as $param) {
            $alias = false;
            if (\is_object($param)) {
                $alias = $this->getAlias($param);
            }
            elseif (\is_string($param)) {
                $alias = $param;
            }

            if ($alias && isset($this->_services[ $alias ])) {
                $result[] = $alias;
                unset($this->_services[ $alias ]);
            }
        }

        return $result;
    }

    /**
     * Get the number of registered services in the container.
     */
    public function count() : int
    {
        return \count($this->_services);
    }
}
