<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Limitations\Exceptions\CloningProhibited;
use UnitTests\Limitations\ProhibitCloningFixture;

/**
 * @coversDefaultClass \Stellar\Limitations\Testing\AssertProhibitCloning
 */
class AssertProhibitCloningTests extends TestCase
{
    /**
     * @covers ::assertProhibitCloning()
     */
    public function test()
    {
        $fixture = new AssertProhibitCloningFixture();
        $fixture->assertProhibitCloning(new ProhibitCloningFixture());

        $this->assertSame(
            [ [ CloningProhibited::class ] ],
            $fixture->getCallStack()->get('expectExceptionUpgradedToError')
        );
    }
}
