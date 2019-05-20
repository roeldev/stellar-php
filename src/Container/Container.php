<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Type;
use Stellar\Container\Exceptions\BuildFailure;
use Stellar\Container\Exceptions\SingletonAlreadyExists;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Limitations\ProhibitCloning;

/**
 * immutable = eigenschap van container, items kunnen niet worden toegevoegd, gewijzigd of worden verwijdert
 * singleton = eigenschap van item in container, item kan niet worden overschreven, eenmaal toegevoegd blijft het
 * hetzelfde
 *
 * @see \UnitTests\Container\ContainerTests
 */
class Container extends BasicContainer
{
    use ProhibitCloning;

    /**
     * Name of the container.
     *
     * @var string|null
     */
    protected $_name;

    /**
     * Id's of the registered services that are singletons.
     *
     * @var array
     */
    protected $_singletons = [];

    public function __construct(?string $name = null)
    {
        $this->_name = $name;
    }

    public function getName() : ?string
    {
        return $this->_name;
    }

    /**
     * Indicates if the container has the singleton service.
     *
     * @param string|object $aliasOrService
     */
    public function hasSingleton($aliasOrService) : bool
    {
        $result = $this->has($aliasOrService);
        if ($result) {
            $alias = \is_object($aliasOrService) ?
                $this->getAlias($aliasOrService) :
                $aliasOrService;

            $result = (false !== $alias && true === ($this->_singletons[ $alias ] ?? false));
        }

        return $result;
    }

    /**
     * Set a service with the given alias in the container. It will throw an exception when the
     * alias is already registered to a singleton service, or replace any other service.
     *
     * @param string $alias
     * @param object $service
     * @return object
     * @throws SingletonAlreadyExists
     */
    public function set(string $alias, $service)
    {
        if ($this->hasSingleton($alias)) {
            throw SingletonAlreadyExists::factory($alias)->create();
        }

        return parent::set($alias, $service);
    }

    /**
     * Request a service by looking for an existing service with the same alias, or by creating a
     * new service with the provided callback. This new service will be registered with the
     * given alias. The callback should return an instance of ServiceRequest or else a
     * BuildFailure is thrown.
     *
     * @see ServiceRequest
     * @throws InvalidClass When callback does not return an instance of ServiceRequest.
     */
    public function request(string $alias, callable $callback, ...$params)
    {
        if (!$this->has($alias)) {
            $createdService = $callback(...$params);

            if (!($createdService instanceof ServiceRequest)) {
                throw InvalidClass::factory(ServiceRequest::class, Type::details($createdService))
                    ->create();
            }

            $this->_services[ $alias ] = $createdService->getService();
            if ($createdService->isSingleton()) {
                $this->_singletons[ $alias ] = true;
            }
        }

        return $this->_services[ $alias ];
    }
}
