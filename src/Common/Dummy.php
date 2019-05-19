<?php declare(strict_types=1);

namespace Stellar\Common;

use Stellar\Common\Types\StaticClass;

/**
 * Simple helper class which returns some empty dummy types. Useful for unit tests or when needing
 * (empty) default values.
 *
 * @see \UnitTests\Common\DummyTests
 * @codeCoverageIgnore
 */
final class Dummy extends StaticClass
{
    /**
     * Return an anonymously created empty object.
     *
     * @return object
     */
    public static function anonymousObject()
    {
        return new class
        {
        };
    }

    /**
     * Return an empty Closure.
     */
    public static function closure() : \Closure
    {
        return function () {
        };
    }
}
