<?php declare(strict_types=1);

namespace Stellar\Container;

use Stellar\Common\Contracts\SingletonInterface;
use Stellar\Common\Types\StaticClass;

/**
 * @see \UnitTests\Container\RegistryTests
 */
final class Registry extends StaticClass implements SingletonInterface
{
    /** @var Container */
    static private $_instance;

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
     * @param string $class
     */
    public static function container(string $class) : Container
    {
        return self::instance()
            ->request($class . '__container', [ ServiceRequest::class, 'with' ], Container::class);
    }

    /**
     * Request a singleton instance of the specified class, or create one and register it as the
     * singleton instance.
     */
    public static function singleton(string $class, array $params = [])
    {
        return self::instance()->request($class, function () use ($class, $params) {
            return ServiceRequest::with($class, $params)->asSingleton();
        });
    }
}
