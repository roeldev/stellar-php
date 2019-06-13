<?php declare(strict_types=1);

namespace Stellar\Factory;

use Stellar\Common\ClassUtil;
use Stellar\Common\StaticClass;
use Stellar\Factory\Exceptions\CreationException;

/**
 * @see:unit-test \UnitTests\Factory\FactoryTests
 */
final class Factory extends StaticClass
{
    public static function build(string $class) : Builder
    {
        return new Builder($class);
    }

    /**
     * Create an instance of the class and pass the given parameters to the constructor method.
     *
     * @return object
     * @throws CreationException
     */
    public static function create(string $class, array $args = [], $autoload = true)
    {
        if (!ClassUtil::exists($class, $autoload)) {
            throw new CreationException($class);
        }

        return new $class(...$args);
    }
}
