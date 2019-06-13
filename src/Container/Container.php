<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Type;
use Stellar\Container\Exceptions\SingletonExistsException;
use Stellar\Exceptions\Common\InvalidArgument;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Limitations\ProhibitCloningTrait;

/**
 * immutable = eigenschap van container, items kunnen niet worden toegevoegd, gewijzigd of worden verwijderd
 * singleton = eigenschap van item in container, item kan niet worden overschreven, eenmaal toegevoegd blijft het
 * hetzelfde
 *
 * @see:unit-test \UnitTests\Container\ContainerTests
 */
class Container extends BasicContainer
{
    use ProhibitCloningTrait;

    /**
     * Name of the container.
     *
     * @var string|null
     */
    protected $_name;

    protected $_aliases = [];

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
     * @param string|object $idOrService
     */
    public function hasSingleton($idOrService) : bool
    {
        $result = $this->has($idOrService);
        if ($result) {
            $id = \is_object($idOrService)
                ? $this->getId($idOrService)
                : $idOrService;

            $result = (false !== $id && true === ($this->_singletons[ $id ] ?? false));
        }

        return $result;
    }

    /**
     * Set a service with the given alias in the container. It will throw an exception when the
     * alias is already registered to a singleton service, or replace any other service.
     *
     * @param string $id
     * @param object $service
     * @return object
     * @throws SingletonExistsException
     * @throws InvalidArgument
     */
    public function set(string $id, $service)
    {
        if ($this->hasSingleton($id)) {
            throw new SingletonExistsException($id);
        }

        return parent::set($id, $service);
    }

    /**
     * Request a service by looking for an existing service with the same alias, or by creating a
     * new service with the provided callback. This new service will be registered with the
     * given alias.
     *
     * @throws InvalidClass When callback does not return an instance of ServiceRequest.
     * @see ServiceRequest
     */
    public function request(string $id, callable $callback, ...$params)
    {
        if (!$this->has($id)) {
            $createdService = $callback(...$params);

            if (!($createdService instanceof ServiceRequest)) {
                throw new InvalidClass(ServiceRequest::class, Type::details($createdService));
            }

            $service = $createdService->getService();
            $aliases = $createdService->getAliases();

            $this->_services[ $id ] = $service;
            $this->_aliases[ $id ] = $aliases;

            foreach ($aliases as $alias) {
                if ($this->hasId($alias)) {
                    continue;
                }

                $this->_services[ $alias ] = $service;
            }

            if ($createdService->isSingleton()) {
                $this->_singletons[ $id ] = true;
            }
        }

        return $this->_services[ $id ];
    }
}
