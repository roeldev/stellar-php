<?php declare(strict_types=1);

namespace Stellar\Factory;

use Stellar\Common\ClassUtil;
use Stellar\Common\StaticClass;
use Stellar\Factory\Exceptions\ConstructionFailure;

/**
 * @see \UnitTests\Factory\FactoryTests
 */
final class Factory extends StaticClass
{
    /**
     * Construct a class and pass the given parameters to the constructor method, or return `null`
     * on failure.
     *
     * @return object
     * @throws ConstructionFailure
     */
    public static function construct(string $class, array $params = [], $autoload = true)
    {
        if (!ClassUtil::exists($class, $autoload)) {
            throw ConstructionFailure::factory($class)->create();
        }

        return new $class(...$params);
    }

    public static function constructOf(string $ofType, string $class, array $params = [], $autoload = true)
    {

    }
}
