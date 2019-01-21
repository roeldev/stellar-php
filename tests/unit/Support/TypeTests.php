<?php declare(strict_types=1);

namespace UnitTests\Support;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Dummy;
use Stellar\Support\Type;

/**
 * @coversDefaultClass \Stellar\Support\Type
 */
class TypeTests extends TestCase
{
    /**
     * @covers ::get()
     * @dataProvider \UnitTests\Support\TypeTestsData::simpleTypes()
     */
    public function test_get(string $type, ... $params)
    {
        $this->assertSame($type, Type::get(... $params));
    }

    /**
     * @covers ::getDetailed()
     * @dataProvider \UnitTests\Support\TypeTestsData::detailedTypes()
     */
    public function test_get_detailed(string $type, ... $params)
    {
        $this->assertSame($type, Type::getDetailed(... $params));
    }

    /**
     * @covers ::isCountable()
     */
    public function test_is_valid_Countable()
    {
        $this->assertTrue(Type::isCountable([]));
        $this->assertTrue(Type::isCountable(new \ArrayObject()));
        $this->assertTrue(Type::isCountable(new class implements \Countable
        {
            public function count() : int
            {
                return 0;
            }
        }));
    }

    /**
     * @covers ::isCountable()
     */
    public function test_is_invalid_Countable()
    {
        $this->assertFalse(Type::isCountable(2));
        $this->assertFalse(Type::isCountable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isStringable()
     */
    public function test_is_valid_Stringable()
    {
        $this->assertTrue(Type::isStringable(false));
        $this->assertTrue(Type::isStringable('covfefe'));
        $this->assertTrue(Type::isStringable(new StringableFixture()));
        $this->assertTrue(Type::isStringable(new class
        {
            public function __toString() : string
            {
                return '';
            }
        }));
    }

    /**
     * @covers ::isStringable()
     */
    public function test_is_invalid_Stringable()
    {
        $this->assertFalse(Type::isStringable(null));
        $this->assertFalse(Type::isStringable([]));
        $this->assertFalse(Type::isStringable(new \ArrayObject()));
        $this->assertFalse(Type::isStringable(Dummy::anonymousObject()));
    }

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
        $this->assertSame($expected, Type::toArray($var));
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
