<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Stringify;

/**
 * @coversDefaultClass \Stellar\Common\Stringify
 */
class StringifyTests extends TestCase
{
    /**
     * @covers ::bool()
     */
    public function test_bool()
    {
        $this->assertSame('true', Stringify::bool(true));
        $this->assertSame('false', Stringify::bool(false));
    }
}
