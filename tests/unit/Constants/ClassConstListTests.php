<?php declare(strict_types=1);

namespace UnitTests\Constants;

use PHPUnit\Framework\TestCase;
use Stellar\Constants\ClassConstList;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\UndeclaredClass;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Constants\ClassConstList
 */
class ClassConstListTests extends TestCase
{
    use AssertException;

    /**
     * @covers ::__construct()
     */
    public function test_construct_failure_for_undeclared_class()
    {
        $this->expectException(UndeclaredClass::class);

        $this->assertException(function () {
            new ClassConstList('SomeNoneExistingClass');
        });
    }

    /**
     * @covers ::getOwnerClass()
     */
    public function test_getOwnerClass()
    {
        $list = new ClassConstList(ConstantsFixture::class);
        $this->assertSame(ConstantsFixture::class, $list->getOwnerClass());
    }

    /**
     * @covers ::__construct()
     * @covers ::getList()
     */
    public function test_getList()
    {
        $expected = [
            'FOO'  => 'f00',
            'BAR'  => 'b4r',
            'BAZ'  => 8,
            'NULL' => 0,
        ];

        $this->assertSame($expected, (new ClassConstList(ConstantsFixture::class))->getList());
    }

    /**
     * @covers ::has()
     */
    public function test_has()
    {
        $list = new ClassConstList(ConstantsFixture::class);
        $this->assertTrue($list->has('BAZ'));
        $this->assertTrue($list->has(8));
        $this->assertTrue($list->has('NULL'));
        $this->assertTrue($list->has(0));

        $this->assertFalse($list->has('baz'));
        $this->assertFalse($list->has('8'));
        $this->assertFalse($list->has(null));
    }

    /**
     * @covers ::hasName()
     */
    public function test_hasName()
    {
        $list = new ClassConstList(ConstantsFixture::class);
        $this->assertTrue($list->hasName('FOO'));
        $this->assertTrue($list->hasName(ConstantsFixture::class . '::FOO'));
        $this->assertFalse($list->hasName('f00'));
        $this->assertFalse($list->hasName('ConstantsFixture::FOO'));
    }

    /**
     * @covers ::hasValue()
     */
    public function test_hasValue()
    {
        $list = new ClassConstList(ConstantsFixture::class);
        $this->assertTrue($list->hasValue('b4r'));
        $this->assertTrue($list->hasValue(ConstantsFixture::BAZ));
        $this->assertFalse($list->hasValue('BAR'));
    }

    /**
     * @covers ::nameOf()
     */
    public function test_nameOf()
    {
        $this->assertSame('BAZ', (new ClassConstList(ConstantsFixture::class))->nameOf(ConstantsFixture::BAZ));
    }

    /**
     * @covers ::constOf()
     */
    public function test_constOf()
    {
        $this->assertSame(
            ConstantsFixture::class . '::FOO',
            (new ClassConstList(ConstantsFixture::class))->constOf(ConstantsFixture::FOO)
        );
    }

    /**
     * @covers ::valueOf()
     */
    public function test_valueOf_existing_constant()
    {
        $list = new ClassConstList(ConstantsFixture::class);
        $const = $list->constOf(ConstantsFixture::BAR);

        $this->assertSame(ConstantsFixture::BAR, $list->valueOf($const));
    }

    /**
     * @covers ::valueOf()
     */
    public function test_valueOf_nonexisting_constant()
    {
        $this->expectException(InvalidClass::class);
        $this->assertException(function () {
            (new ClassConstList(ConstantsFixture::class))->valueOf('\Some\Test::TEST');
        });
    }

    /**
     * @covers ::count()
     */
    public function test_count()
    {
        $this->assertCount(0, new ClassConstList(EmptyClassConstantsFixture::class));
        $this->assertCount(4, new ClassConstList(ConstantsFixture::class));
    }

    /**
     * @covers ::toArray()
     */
    public function test_toArray()
    {
        $expected = [
            ConstantsFixture::class . '::FOO'  => 'f00',
            ConstantsFixture::class . '::BAR'  => 'b4r',
            ConstantsFixture::class . '::BAZ'  => 8,
            ConstantsFixture::class . '::NULL' => 0,
        ];

        $this->assertSame($expected, (new ClassConstList(ConstantsFixture::class))->toArray());
    }
}
