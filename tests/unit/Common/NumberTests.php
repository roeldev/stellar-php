<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Num;

/**
 * @coversDefaultClass \Stellar\Common\Num
 */
class NumberTests extends TestCase
{
    /**
     * @covers ::isOdd()
     */
    public function test_isOdd()
    {
        $this->assertTrue(Num::isOdd(1));
        $this->assertTrue(Num::isOdd(131));
        $this->assertFalse(Num::isOdd(2));
        $this->assertFalse(Num::isOdd(0));
    }

    /**
     * @covers ::isEven()
     */
    public function test_isEven()
    {
        $this->assertTrue(Num::isEven(2));
        $this->assertTrue(Num::isEven(23489568));
        $this->assertFalse(Num::isEven(1));
        $this->assertFalse(Num::isEven(0));
    }
}
