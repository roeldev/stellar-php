<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Container\AbstractFactory;
use Stellar\Container\Registry;
use Stellar\Container\ServiceRequest;

final class Factory extends AbstractFactory
{
    public function createEnum(string $class, string $name)
    {
        // get a container instance for the enum class and request an instance for the enum const
        // the instance has to be created inside Enum because it's constructor is protected
        return Registry::container($class)->request($name, function () use ($class, $name) {
            $service = new $class($class, $name);

            return (new ServiceRequest($service))->asSingleton();
        });
    }
}
