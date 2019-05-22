<?php declare(strict_types=1);

namespace Stellar\Limitations\Testing;

use Stellar\Limitations\Exceptions\UnserializationProhibited;

/**
 * PHPUnit assertion for variables that should not be allowed to be wakeup.
 *
 * @see:unit-test \UnitTests\Limitations\Testing\AssertProhibitWakeupTests
 */
trait AssertProhibitWakeup
{
    /**
     * @param object $var
     */
    public function assertProhibitWakeup($var) : void
    {
        $this->expectExceptionUpgradedToError(UnserializationProhibited::class);

        $this->assertException(function () use ($var) {
            \unserialize(\serialize($var), [ 'allowed_classes' => true ]);
        });
    }
}
