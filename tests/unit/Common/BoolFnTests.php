<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Bln;

/**
 * @coversDefaultClass \Stellar\Common\Bln
 */
class BoolFnTests extends TestCase
{
    use BoolFnTestsProvider;

    /**
     * @covers ::isTruthy()
     * @dataProvider provideTruthy()
     */
    public function test_isTruthy($var)
    {
        $this->assertTrue(Bln::isTruthy($var));
    }

    /**
     * @covers ::isTruthy()
     * @dataProvider provideFalsey()
     */
    public function test_not_isTruthy($var)
    {
        $this->assertFalse(Bln::isTruthy($var));
    }

    /**
     * @covers ::isFalsy()
     * @dataProvider provideFalsey()
     */
    public function test_isFalsey($var)
    {
        $this->assertTrue(Bln::isFalsy($var));
    }

    /**
     * @covers ::isFalsy()
     * @dataProvider provideTruthy()
     */
    public function test_not_isFalsey($var)
    {
        $this->assertFalse(Bln::isFalsy($var));
    }

    /**
     * @covers ::toString()
     */
    public function test_toString()
    {
        $this->assertSame('true', Bln::toString(true));
        $this->assertSame('false', Bln::toString(false));
    }
}

trait BoolFnTestsProvider
{
    public static function provideTruthy() : array
    {
        return [
            [ true ],
            [ 1 ],
            [ '1' ],
            [ 'true' ],
            [ 'TRUE' ],
            [ 'on' ],
            [ 'On' ],
            [ 'y' ],
            [ 'yes' ],
        ];
    }

    public static function provideFalsey() : array
    {
        return [
            [ false ],
            [ null ],
            [ [] ],
            [ '' ],
            [ 0 ],
            [ '0' ],
            [ 'false' ],
            [ 'FALSE' ],
            [ 'off' ],
            [ 'Off' ],
            [ 'n' ],
            [ 'no' ],
        ];
    }
}
