<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Type;
use Stellar\Exceptions\Common\InvalidArgument;

/**
 * @see:unit-test \UnitTests\Container\ServiceRequestTests
 */
class ServiceRequest
{
    /**
     * @param object $service
     * @return ServiceRequest
     * @throws InvalidArgument
     * @see __construct
     */
    public static function with($service) : self
    {
        return new static($service);
    }

    /** @var object */
    protected $_service;

    /** @var string[] */
    protected $_aliases = [];

    /** @var bool */
    protected $_singleton = false;

    /**
     * @param object $service
     * @throws InvalidArgument
     */
    public function __construct($service)
    {
        if (!\is_object($service)) {
            throw new InvalidArgument('service', 'object', Type::get($service));
        }

        $this->_service = $service;
    }

    /**
     * Mark the service to be used as a singleton.
     */
    public function asSingleton(bool $set = true) : self
    {
        $this->_singleton = $set;

        return $this;
    }

    public function withAlias(string $alias) : self
    {
        $this->_aliases[] = $alias;

        return $this;
    }

    /**
     * @return object
     */
    public function getService()
    {
        return $this->_service;
    }

    public function getAliases() : array
    {
        return $this->_aliases;
    }

    /**
     * Indicates if the service should be used as a singleton.
     */
    public function isSingleton() : bool
    {
        return $this->_singleton;
    }
}
