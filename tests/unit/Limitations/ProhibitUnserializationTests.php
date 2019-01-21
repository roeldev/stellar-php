<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;
use Stellar\Limitations\Testing\AssertProhibitUnserialization;

/**
 * @coversDefaultClass \Stellar\Limitations\ProhibitUnserialization
 */
class ProhibitUnserializationTests extends TestCase
{
    use AssertException;
    use AssertProhibitUnserialization;

    /**
     * @covers ::unserialize()
     */
    public function test()
    {
        $this->assertProhibitUnserialization(new ProhibitUnserializationFixture());
    }
}
