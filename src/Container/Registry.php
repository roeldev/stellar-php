<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Contracts\SingletonInterface;
use Stellar\Common\StaticClass;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Factory\Factory;

/**
 * @see:unit-test \UnitTests\Container\RegistryTests
 */
final class Registry extends StaticClass implements SingletonInterface
{
    /** @var Container */
    private static $_instance;

    /**
     * Get the main Container instance that's used by Registry.
     */
    public static function instance() : Container
    {
        if (null === self::$_instance) {
            self::$_instance = new Container(self::class);
        }

        return self::$_instance;
    }

    /**
     * Create and/or get a Container singleton instance for the specified owner class or object.
     *
     * @throws InvalidClass
     */
    public static function container(string $class) : Container
    {
        return self::instance()->request($class . '__container', function () {
            return ServiceRequest::with(new Container());
        });
    }

    /**
     * Request a singleton instance of the specified class, or create one and register it as the
     * singleton instance.
     *
     * @throws \Stellar\Exceptions\Common\InvalidClass
     */
    public static function singleton(string $class, array $params = [])
    {
        return self::instance()
            ->request($class, function () use ($class, $params) {
                return ServiceRequest::with(Factory::create($class, $params))
                    ->asSingleton();
            });
    }
}
