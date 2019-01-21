<?php declare(strict_types=1);

namespace UnitTests\Enum;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Enum\BitField
 */
class BitFieldTests extends TestCase
{
    use AssertException;

    // todo: afmaken en meer tests
    public function test_construct()
    {
        new BitFieldFixture(BitFieldFixture::EXECUTE | BitFieldFixture::WRITE);
        (new BitFieldFixture(9))->has(BitFieldFixture::READ);
        $this->assertTrue(true);
    }

    public function test_get_the_names_and_values_of_available_types()
    {
        $expected = [
            'EXECUTE' => 1,
            'WRITE'   => 2,
            'READ'    => 4,
        ];

        $this->assertEquals($expected, BitFieldFixture::list());
    }
}
