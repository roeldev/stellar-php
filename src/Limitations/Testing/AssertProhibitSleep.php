<?php declare(strict_types=1);

namespace Stellar\Limitations\Testing;

use Stellar\Limitations\Exceptions\SerializationProhibited;

/**
 * PHPUnit assertion for variables that should not be allowed to be serialized.
 *
 * @see:unit-test \UnitTests\Limitations\Testing\AssertProhibitSleepTests
 */
trait AssertProhibitSleep
{
    /**
     * @param object $var
     */
    public function assertProhibitSleep($var) : void
    {
        $this->expectExceptionUpgradedToError(SerializationProhibited::class);

        $this->assertException(function () use ($var) {
            \serialize($var);
        });
    }
}
