<?php declare(strict_types=1);

namespace Stellar\Container;

use Psr\Container\ContainerInterface;
use Stellar\Common\Type;
use Stellar\Container\Exceptions\NotFound;
use Stellar\Exceptions\Common\InvalidType;

/**
 * @see:unit-test \UnitTests\Container\BasicContainerTests
 */
class BasicContainer implements ContainerInterface, \Countable
{
    /**
     * An array with registered services with the given alias as key.
     *
     * @var array<string, object>
     */
    protected $_services = [];

    /**
     * @param string $id
     *
     * @return object
     * @throws NotFound
     */
    public function get($id)
    {
        if ($this->hasId($id)) {
            return $this->_services[ $id ];
        }

        throw NotFound::factory($id)->create();
    }

    /**
     * Get the alias of a registered service, or `false` when not found.
     *
     * @param object $service
     * @return string|false
     */
    public function getId($service)
    {
        $result = \array_search($service, $this->_services, true);

        return \is_string($result) ? $result : false;
    }

    /**
     * Get an array with all used aliases.
     *
     * @return string[]
     */
    public function getIds() : array
    {
        return \array_keys($this->_services);
    }

    /**
     * Indicates if the container has the service.
     *
     * @param string|object $idOrService
     */
    public function has($idOrService) : bool
    {
        if (\is_string($idOrService)) {
            return $this->hasId($idOrService);
        }
        if (\is_object($idOrService)) {
            return $this->hasService($idOrService);
        }

        return false;
    }

    public function hasId(string $id) : bool
    {
        return isset($this->_services[ $id ]);
    }

    public function hasService($service) : bool
    {
        return \in_array($service, $this->_services, true);
    }

    /**
     * Set a service with the given alias in the container. It will replace any existing service
     * already registered with the same alias.
     *
     * @param string $id
     * @param object $service
     * @return object
     */
    public function set(string $id, $service)
    {
        if (!\is_object($service)) {
            throw InvalidType::factory('object', Type::get($service), 'service')->create();
        }

        $this->_services[ $id ] = $service;

        return $service;
    }

    /**
     * Unset multiple aliases or services from the container.
     *
     * @param mixed $idOrService
     */
    public function unset(...$idOrService) : array
    {
        $result = [];
        foreach ($idOrService as $param) {
            $id = false;
            if (\is_object($param)) {
                $id = $this->getId($param);
            }
            elseif (\is_string($param)) {
                $id = $param;
            }

            if ($id && isset($this->_services[ $id ])) {
                $result[] = $id;
                unset($this->_services[ $id ]);
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
