<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Contracts\ArrayableInterface;
use Stellar\Common\Dummy;
use Stellar\Common\Obj;

/**
 * @coversDefaultClass \Stellar\Common\Obj
 */
class ObjectFnTests extends TestCase
{
    /**
     * @covers ::isAnonymous()
     */
    public function test_is_valid_anonymous_class()
    {
        $this->assertTrue(Obj::isAnonymous(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isAnonymous()
     */
    public function test_is_invalid_anonymous_class()
    {
        $this->assertFalse(Obj::isAnonymous(new \ArrayObject()));
    }

    /**
     * @covers ::isArrayable()
     */
    public function test_valid_Arrayable_when_implementing_Arrayable_interface()
    {
        $this->assertTrue(Obj::isArrayable(new class implements ArrayableInterface
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
        $this->assertTrue(Obj::isArrayable(new class implements ArrayableInterface
        {
            public function toArray() : array
            {
                return [];
            }
        }));

        $this->assertTrue(Obj::isArrayable(new class
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
        $this->assertFalse(Obj::isArrayable([]));
        $this->assertFalse(Obj::isArrayable(false));
        $this->assertFalse(Obj::isArrayable('covfefe'));
        $this->assertFalse(Obj::isArrayable(new \ArrayObject()));
        $this->assertFalse(Obj::isArrayable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isInvokable()
     */
    public function test_is_valid_Invokable()
    {
        $this->assertTrue(Obj::isInvokable(new InvokableFixture()));
        $this->assertTrue(Obj::isInvokable(Dummy::closure()));
        $this->assertTrue(Obj::isInvokable(new class
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
        $this->assertFalse(Obj::isInvokable(true));
        $this->assertFalse(Obj::isInvokable(null));
        $this->assertFalse(Obj::isInvokable(new \ArrayObject()));
        $this->assertFalse(Obj::isInvokable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::isStringable()
     */
    public function test_is_valid_Stringable()
    {
        $this->assertTrue(Obj::isStringable(new StringableFixture()));
        $this->assertTrue(Obj::isStringable(new class
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
        $this->assertFalse(Obj::isStringable(null));
        $this->assertFalse(Obj::isStringable([]));
        $this->assertFalse(Obj::isStringable(false));
        $this->assertFalse(Obj::isStringable('covfefe'));
        $this->assertFalse(Obj::isStringable(new \ArrayObject()));
        $this->assertFalse(Obj::isStringable(Dummy::anonymousObject()));
    }

    /**
     * @covers ::namespaceOf()
     */
    public function test_getNamespace()
    {
        $this->assertSame('', Obj::namespaceOf(new \ArrayObject()));
        $this->assertSame(__NAMESPACE__, Obj::namespaceOf($this));
    }
}
