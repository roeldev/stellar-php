<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Arrayify;
use Stellar\Common\Dummy;

/**
 * @coversDefaultClass \Stellar\Common\Arrayify
 */
class ArrayifyTests extends TestCase
{
    public static function castToArray() : array
    {
        $data = [
            'foo'        => 'foo value',
            'bar'        => 'bar value',
            'anotherFoo' => 'foo value',
        ];

        $anonClass = new class()
        {
            private $_ignore = 'this property should not be converted';

            public $foo = 'foo value';

            public $bar = 'bar value';

            public $anotherFoo = 'foo value';
        };

        return [
            [ [], [] ],
            [ $data, $data ],
            [ $data, new ArrayableFixture() ],
            [ [], new \ArrayObject() ],
            [ $data, new \ArrayObject($data) ],
            [ [], new \ArrayIterator() ],
            [ $data, new \ArrayIterator($data) ],
            [ [], Dummy::anonymousObject() ],
            [ $data, $anonClass ],
            [ null, false ],
            [ null, 'array' ],
        ];
    }

    /**
     * @covers ::toArray()
     * @dataProvider castToArray()
     */
    public function test_toArray($expected, $var)
    {
        $this->assertSame($expected, Arrayify::any($var));
    }
}

/**
 * @internal
 */
class ArrayableFixture implements ArrayableInterface
{
    public $foo = 'foo value';

    public $bar = 'bar value';

    public $anotherFoo = 'foo value';

    public function toArray() : array
    {
        return (array) $this;
    }
}
