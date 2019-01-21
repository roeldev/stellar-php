<?php declare(strict_types=1);

namespace Stellar\Common\Testing;

/**
 * @see \UnitTests\Common\Testing\AssertStaticClassTests
 */
trait AssertStaticClass
{
    public static function assertStaticClass(string $actual, string $message = '') : void
    {
        static::assertThat($actual, new Constraints\IsStaticClass(), $message);
    }
}
