<?php declare(strict_types=1);

namespace UnitTests\Enum;

use PHPUnit\Framework\TestCase;
use Stellar\Enum\Enum;
use Stellar\Enum\Exceptions\InvalidType;
use Stellar\Exceptions\Error;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Enum\Enum
 */
class EnumTests extends TestCase
{
    use AssertException;

    protected function _assertEnumInstance(Enum $target, string $class, string $constant, $value)
    {
        // actual class
        $this->assertInstanceOf($class, $target);

        // properties
        $this->assertSame($class . '::' . $constant, $target->getConst());
        $this->assertSame($constant, $target->getName());
        $this->assertSame($value, $target->getValue());
    }

    public function test_not_allowed_to_call_constructor()
    {
        $this->assertFalse((new \ReflectionMethod(EnumFixture::class, '__construct'))->isPublic());
    }

    public function test_get_an_instance_from_the_enum_class()
    {
        $actual = Enum::instance(EnumFixture::class . '::FOO');
        $this->_assertEnumInstance($actual, EnumFixture::class, 'FOO', 'foo');
        $this->assertSame(EnumFixture::FOO(), $actual);
    }

    public function test_fail_to_get_an_instance_from_the_enum_class()
    {
        $this->expectException(Error::class);

        $this->assertException(function () {
            // class does not exist, it's missing the correct namespace
            Enum::instance('EnumFixture::FOO');
        });
    }

    public function test_get_an_instance_from_a_constant_value()
    {
        $target = EnumFixture::instance(EnumFixture::BAZ);
        $this->_assertEnumInstance($target, EnumFixture::class, 'BAZ', 'baz');
    }

    // public function test_fail_to_get_an_instance_from_a_constant_value()
    // {
    //     $this->expectException(InvalidType::class);
    //     EnumFixture::instance('invalid!');
    // }

    public function test_get_an_instance_using_callStatic_magic()
    {
        $target = EnumFixture::BAR();
        $this->_assertEnumInstance($target, EnumFixture::class, 'BAR', 'bar');
    }

    // public function test_fail_to_get_an_instance_using_callStatic_magic()
    // {
    //     $this->expectException(InvalidType::class);
    //     $this->expectExceptionSeverity(Severity::WARNING());
    //     $this->expectExceptionArguments([ 'class' => EnumFixture::class, 'type' => 'BURP' ]);
    //
    //     $this->assertException(function () {
    //         EnumFixture::BURP();
    //     });
    // }

    public function test_get_the_names_and_values_of_available_types()
    {
        $expected = [
            'FOO' => 'foo',
            'BAR' => 'bar',
            'BAZ' => 'baz',
            'FOZ' => 'foz',
        ];

        $this->assertEquals($expected, EnumFixture::list());
        $this->assertEquals($expected, CustomValuesFixture::list());
    }

    public function test_exception_when_no_types_are_set()
    {
        $this->expectException(Error::class);

        $this->assertException(function () {
            EmptyEnumFixture::list();
        });
    }

    // public function test_get_the_type_of_an_existing_value()
    // {
    //     $this->assertSame(EnumFixture::class . '::BAR', EnumFixture::constOf('bar'));
    //     $this->assertSame(CustomValuesFixture::class . '::BAR', CustomValuesFixture::constOf('bar'));
    // }

    public function test_get_the_type_of_an_invalid_value()
    {
        $this->assertNull(EnumFixture::constOf('invalid!'));
        $this->assertNull(CustomValuesFixture::constOf('invalid!'));
    }

    // todo voor invalid type
    // todo voor values
    // public function test_get_the_name_of_an_existing_type()
    // {
    //     $this->assertSame('BAZ', EnumFixture::nameOf(EnumFixture::BAZ));
    //     $this->assertSame('BAZ', CustomValuesFixture::nameOf(CustomValuesFixture::BAZ));
    // }
}
