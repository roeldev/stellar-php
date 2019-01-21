<?php declare(strict_types=1);

namespace UnitTests\Encoding;

use PHPUnit\Framework\TestCase;
use Stellar\Encoding\Base32;
use Stellar\Encoding\Exceptions\IllegalCharacter;
use Stellar\Exceptions\Testing\AssertException;

class Base32Tests extends TestCase
{
    use AssertException;

    /**
     * @dataProvider \UnitTests\Encoding\Base32TestsData::encodedData()
     */
    public function test_encode(string $expected, ... $params)
    {
        $this->assertSame($expected, Base32::encode(... $params));
    }

    /**
     * @dataProvider \UnitTests\Encoding\Base32TestsData::randomData()
     */
    public function test_encode_and_decode(string $input)
    {
        foreach (Base32TestsData::variants() as $variant) {
            $encoded = Base32::encode($input, $variant);
            $decoded = Base32::decode($encoded, $variant);

            $this->assertSame($input, $decoded,
                \sprintf('Base32 (%s): `%s`', \get_class($variant), $encoded ?? '')
            );
        }
    }

    public function test_decode()
    {
        $this->assertSame('', Base32::decode(''));
    }

    public function test_decode_exception()
    {
        $this->expectException(IllegalCharacter::class);
        $this->assertException(function () {
            Base32::decode('a#é$');
        });
    }
}
