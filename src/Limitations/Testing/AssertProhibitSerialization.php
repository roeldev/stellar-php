<?php declare(strict_types=1);

namespace Stellar\Limitations\Testing;

use Stellar\Limitations\Exceptions\SerializationProhibited;

/**
 * PHPUnit assertion for variables that should not be allowed to be serialized.
 *
 * @see:unit-test \UnitTests\Limitations\Testing\AssertProhibitSerializationTests
 */
trait AssertProhibitSerialization
{
    /**
     * @param object $var
     */
    public function assertProhibitSerialization($var) : void
    {
        $this->expectExceptionUpgradedToError(SerializationProhibited::class);

        $this->assertException(function () use ($var) {
            $var->serialize();
        });
    }
}
