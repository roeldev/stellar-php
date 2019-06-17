<?php declare(strict_types=1);

namespace Stellar\Limitations\Testing;

use Stellar\Limitations\Exceptions\CloningProhibited;

/**
 * PHPUnit assertion for variables that should not be allowed to be cloned.
 *
 * @see:unit-test \UnitTests\Limitations\Testing\AssertProhibitCloningTests
 */
trait AssertProhibitCloning
{
    /**
     * @param object $var
     */
    public function assertProhibitCloning($var) : void
    {
        $this->expectException(CloningProhibited::class);
        $this->assertException(function () use ($var) {
            clone $var;
        });
    }
}
