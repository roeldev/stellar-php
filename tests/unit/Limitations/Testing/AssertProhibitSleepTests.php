<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Limitations\Exceptions\SerializationProhibited;
use UnitTests\Limitations\ProhibitSleepFixture;

/**
 * @coversDefaultClass \Stellar\Limitations\Testing\AssertProhibitSleep
 */
class AssertProhibitSleepTests extends TestCase
{
    /**
     * @covers ::assertProhibitSleep()
     */
    public function test()
    {
        $fixture = new AssertProhibitSleepFixture();
        $fixture->assertProhibitSleep(new ProhibitSleepFixture());

        $this->assertSame(
            [ [ SerializationProhibited::class ] ],
            $fixture->getCallStack()->get('expectException')
        );
    }
}
