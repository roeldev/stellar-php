<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Type;
use Stellar\Exceptions\Common\InvalidArgument;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Factory\Factory;

/**
 * @see \UnitTests\Container\ServiceRequestTests
 */
class ServiceRequest
{
    public static function with(string $class, array $params = []) : self
    {
        return new static(Factory::construct($class, $params));
    }

    /** @var object */
    protected $_service;

    /** @var bool */
    protected $_singleton = false;

    /**
     * @param object $service
     * @throws InvalidType
     */
    public function __construct($service)
    {
        if (!\is_object($service)) {
            throw InvalidType::factory('object', Type::get($service), 'service')->create();
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

    /**
     * @return object
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * Indicates if the service should be used as a singleton.
     */
    public function isSingleton() : bool
    {
        return $this->_singleton;
    }
}
