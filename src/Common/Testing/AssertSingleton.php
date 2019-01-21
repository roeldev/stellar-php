<?php declare(strict_types=1);

namespace Stellar\Common\Testing;

/**
 * @see \UnitTests\Common\Testing\AssertSingletonTests
 */
trait AssertSingleton
{
    public static function assertSingleton($actual, string $message = '') : void
    {
        static::assertThat($actual, new Constraints\IsSingleton(), $message);
    }
}
