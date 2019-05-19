<?php declare(strict_types=1);

namespace Stellar\Factory;

use Stellar\Common\Types\StaticClass;
use Stellar\Factory\Exceptions\ConstructionFailure;
use Stellar\Support\Cls;

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
        if (!Cls::exists($class, $autoload)) {
            throw ConstructionFailure::factory($class)->create();
        }

        return new $class(...$params);
    }
}
