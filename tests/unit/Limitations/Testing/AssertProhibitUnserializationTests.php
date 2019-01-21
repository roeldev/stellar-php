<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Limitations\Exceptions\UnserializationProhibited;
use UnitTests\Limitations\ProhibitUnserializationFixture;

/**
 * @coversDefaultClass \Stellar\Limitations\Testing\AssertProhibitUnserialization
 */
class AssertProhibitUnserializationTests extends TestCase
{
    /**
     * @covers ::assertProhibitUnserialization()
     */
    public function test()
    {
        $fixture = new AssertProhibitUnserializationFixture();
        $fixture->assertProhibitUnserialization(new ProhibitUnserializationFixture());

        $this->assertSame(
            [ [ UnserializationProhibited::class ] ],
            $fixture->getCallStack()->get('expectExceptionUpgradedToError')
        );
    }
}
