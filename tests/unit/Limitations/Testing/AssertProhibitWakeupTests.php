<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Limitations\Exceptions\UnserializationProhibited;
use UnitTests\Limitations\ProhibitWakeupFixture;

/**
 * @coversDefaultClass \Stellar\Limitations\Testing\AssertProhibitWakeup
 */
class AssertProhibitWakeupTests extends TestCase
{
    /**
     * @covers ::assertProhibitWakeup()
     */
    public function test()
    {
        $fixture = new AssertProhibitWakeupFixture();
        $fixture->assertProhibitWakeup(new ProhibitWakeupFixture());

        $this->assertSame(
            [ [ UnserializationProhibited::class ] ],
            $fixture->getCallStack()->get('expectException')
        );
    }
}
