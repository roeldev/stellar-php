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
    use ArrayifyTestsDataProvider;

    /**
     * @covers ::any()
     * @dataProvider anyProvider()
     */
    public function test_any($expected, $var)
    {
        $this->assertSame($expected, Arrayify::any($var));
    }

    /**
     * @covers ::traversable()
     * @dataProvider traversablesProvider()
     */
    public function test_traversable($expected, $var)
    {
        $this->assertInstanceOf(\Traversable::class, $var);
        $this->assertSame($expected, Arrayify::traversable($var));
    }

    /**
     * @covers ::iterable()
     * @dataProvider iterablesProvider()
     */
    public function test_iterable($expected, $var)
    {
        $this->assertIsIterable($var);
        $this->assertSame($expected, Arrayify::iterable($var));
    }
}

/**
 * @internal
 */
trait ArrayifyTestsDataProvider
{
    private static $_testData = [
        'foo' => 'foo value',
        'bar' => 'bar value',
        'anotherFoo' => 'foo value',
    ];

    public static function traversablesProvider() : array
    {
        return [
            [ [], new \ArrayObject() ],
            [ self::$_testData, new \ArrayObject(self::$_testData) ],
            [ [], new \ArrayIterator() ],
            [ self::$_testData, new \ArrayIterator(self::$_testData) ],
        ];
    }

    public static function iterablesProvider() : array
    {
        return array_merge(self::traversablesProvider(), [
            [ [], [] ],
            [ self::$_testData, self::$_testData ],
        ]);
    }

    public static function anyProvider() : array
    {
        $anonClass = new class()
        {
            private $_ignore = 'this property should not be converted';

            public $foo = 'foo value';

            public $bar = 'bar value';

            public $anotherFoo = 'foo value';
        };

        return \array_merge(self::iterablesProvider(), [
            [ self::$_testData, new ArrayableFixture() ],
            [ [], Dummy::anonymousObject() ],
            [ self::$_testData, $anonClass ],
            [ null, false ],
            [ null, 'array' ],
        ]);
    }
}

/**
 * @internal
 */
class ArrayableFixture implements ArrayableInterface
{
    use ArrayifyTestsDataProvider;

    public function toArray() : array
    {
        return self::$_testData;
    }
}
