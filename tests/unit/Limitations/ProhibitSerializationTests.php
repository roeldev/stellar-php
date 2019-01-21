<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;
use Stellar\Limitations\Testing\AssertProhibitSerialization;

/**
 * @coversDefaultClass \Stellar\Limitations\ProhibitSerialization
 */
class ProhibitSerializationTests extends TestCase
{
    use AssertException;
    use AssertProhibitSerialization;

    /**
     * @covers ::serialize()
     */
    public function test()
    {
        $this->assertProhibitSerialization(new ProhibitSerializationFixture());
    }
}
