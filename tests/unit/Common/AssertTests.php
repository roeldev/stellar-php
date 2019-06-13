<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Abilities\StringableTrait;
use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Contracts\InvokableInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Assert;
use Stellar\Common\Dummy;

/**
 * @coversDefaultClass \Stellar\Common\Assert
 */
class AssertTests extends TestCase
{
    use AssertTestsDataProvider;

    /**
     * @covers ::isEmptyString()
     */
    public function test_isEmptyString()
    {
        $this->assertTrue(Assert::isEmptyString());
        $this->assertTrue(Assert::isEmptyString(''));
        $this->assertFalse(Assert::isEmptyString('0'));
        $this->assertFalse(Assert::isEmptyString(' '));

        // both true
        $this->assertSame(empty(null), Assert::isEmptyString(null));
        $this->assertSame(empty(''), Assert::isEmptyString(''));

        // difference:
        // - empty('0') = true
        // - Assert::isEmptyString('0') = false
        $this->assertNotSame(empty('0'), Assert::isEmptyString('0'));
    }

    /**
     * @covers ::isTruthy()
     * @dataProvider truthyProvider()
     */
    public function test_isTruthy($var)
    {
        $this->assertTrue(Assert::isTruthy($var));
    }

    /**
     * @covers ::isTruthy()
     * @dataProvider falseyProvider()
     */
    public function test_not_isTruthy($var)
    {
        $this->assertFalse(Assert::isTruthy($var));
    }

    /**
     * @covers ::isFalsy()
     * @dataProvider falseyProvider()
     */
    public function test_isFalsey($var)
    {
        $this->assertTrue(Assert::isFalsy($var));
    }

    /**
     * @covers ::isFalsy()
     * @dataProvider truthyProvider()
     */
    public function test_not_isFalsey($var)
    {
        $this->assertFalse(Assert::isFalsy($var));
    }

    /**
     * @covers ::isOdd()
     */
    public function test_isOdd()
    {
        $this->assertTrue(Assert::isOdd(1));
        $this->assertTrue(Assert::isOdd(131));
        $this->assertFalse(Assert::isOdd(2));
        $this->assertFalse(Assert::isOdd(0));
    }

    /**
     * @covers ::isEven()
     */
    public function test_isEven()
    {
        $this->assertTrue(Assert::isEven(2));
        $this->assertTrue(Assert::isEven(23489568));
        $this->assertFalse(Assert::isEven(1));
        $this->assertFalse(Assert::isEven(0));
    }

    /**
     * @covers ::isAnonymous()
     */
    public function test_is_invalid_anonymous_class()
    {
        $this->assertFalse(Assert::isAnonymous('\Path\To\UnexistingClass'));
    }

    /**
     * @covers ::isAnonymous()
     */
    public function test_is_valid_anonymous_object()
    {
        $this->assertTrue(Assert::isAnonymous(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isAnonymous()
     */
    public function test_is_invalid_anonymous_object()
    {
        $this->assertFalse(Assert::isAnonymous(new \ArrayObject()));
    }

    /**
     * @covers ::isArrayable()
     */
    public function test_valid_Arrayable_when_implementing_Arrayable_interface()
    {
        $this->assertTrue(Assert::isArrayable(new class implements ArrayableInterface
        {
            public function toArray() : array
            {
                return [];
            }
        }));
    }

    /**
     * @covers ::isArrayable()
     */
    public function test_valid_Arrayable_with_toArray_method()
    {
        $this->assertTrue(Assert::isArrayable(new class implements ArrayableInterface
        {
            public function toArray() : array
            {
                return [];
            }
        }));

        $this->assertTrue(Assert::isArrayable(new class
        {
            public function toArray() : array
            {
                return [];
            }
        }));
    }

    /**
     * @covers ::isArrayable()
     */
    public function test_is_invalid_Arrayable()
    {
        $this->assertFalse(Assert::isArrayable([]));
        $this->assertFalse(Assert::isArrayable(false));
        $this->assertFalse(Assert::isArrayable('covfefe'));
        $this->assertFalse(Assert::isArrayable(new \ArrayObject()));
        $this->assertFalse(Assert::isArrayable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isCountable()
     */
    public function test_is_valid_Countable()
    {
        $this->assertTrue(Assert::isCountable([]));
        $this->assertTrue(Assert::isCountable(new \ArrayObject()));
        $this->assertTrue(Assert::isCountable(new class implements \Countable
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
        $this->assertFalse(Assert::isCountable(2));
        $this->assertFalse(Assert::isCountable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isInvokable()
     */
    public function test_is_valid_Invokable()
    {
        $this->assertTrue(Assert::isInvokable(new InvokableFixture()));
        $this->assertTrue(Assert::isInvokable(Dummy::closure()));
        $this->assertTrue(Assert::isInvokable(new class
        {
            public function __invoke()
            {
            }
        }));
    }

    /**
     * @covers ::isInvokable()
     */
    public function test_is_invalid_Invokable()
    {
        $this->assertFalse(Assert::isInvokable(true));
        $this->assertFalse(Assert::isInvokable(null));
        $this->assertFalse(Assert::isInvokable(new \ArrayObject()));
        $this->assertFalse(Assert::isInvokable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isStringable()
     */
    public function test_is_valid_Stringable()
    {
        $this->assertTrue(Assert::isStringable(1.0));
        $this->assertTrue(Assert::isStringable(false));
        $this->assertTrue(Assert::isStringable('covfefe'));
        $this->assertTrue(Assert::isStringable(new StringableFixture()));
        $this->assertTrue(Assert::isStringable(new class
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
        $this->assertFalse(Assert::isStringable(null));
        $this->assertFalse(Assert::isStringable([]));
        $this->assertFalse(Assert::isStringable(new \ArrayObject()));
        $this->assertFalse(Assert::isStringable(Dummy::anonymousObject()));
    }
}

/**
 * @internal
 */
trait AssertTestsDataProvider
{
    public static function truthyProvider() : array
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

    public static function falseyProvider() : array
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

/**
 * @internal
 */
class InvokableFixture implements InvokableInterface
{
    public function __invoke()
    {
    }
}

/**
 * @internal
 */
class StringableFixture implements StringableInterface
{
    use StringableTrait;

    public function __toString() : string
    {
        return 'foobar';
    }
}
