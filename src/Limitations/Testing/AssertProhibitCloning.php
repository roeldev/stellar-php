<?php declare(strict_types=1);

namespace Stellar\Limitations\Testing;

use Stellar\Limitations\Exceptions\CloningProhibited;

/**
 * PHPUnit assertion for variables that should not be allowed to be cloned.
 *
 * @see \UnitTests\Limitations\Testing\AssertProhibitCloningTests
 */
trait AssertProhibitCloning
{
    /**
     * @param object $var
     */
    public function assertProhibitCloning($var) : void
    {
        $this->expectExceptionUpgradedToError(CloningProhibited::class);

        $this->assertException(function () use ($var) {
            clone $var;
        });
    }
}
