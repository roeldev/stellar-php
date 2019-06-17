<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Limitations\Exceptions\SerializationProhibited;
use UnitTests\Limitations\ProhibitSerializationFixture;

/**
 * @coversDefaultClass \Stellar\Limitations\Testing\AssertProhibitSerialization
 */
class AssertProhibitSerializationTests extends TestCase
{
    /**
     * @covers ::assertProhibitSerialization()
     */
    public function test()
    {
        $fixture = new AssertProhibitSerializationFixture();
        $fixture->assertProhibitSerialization(new ProhibitSerializationFixture());

        $this->assertSame(
            [ [ SerializationProhibited::class ] ],
            $fixture->getCallStack()->get('expectException')
        );
    }
}
