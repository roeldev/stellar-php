<?php declare(strict_types=1);

namespace UnitTests\Constants;

use PHPUnit\Framework\TestCase;
use Stellar\Constants\ConstUtil;

/**
 * @coversDefaultClass \Stellar\Constants\ClassConst
 */
class ConstUtilTests extends TestCase
{
    static private $_constPrefix;

    static private $_constFoo;

    static private $_constBar;

    public static function setUpBeforeClass()
    {
        self::$_constPrefix = \strtoupper(\uniqid('TEST_', false));

        \define(self::$_constFoo = self::$_constPrefix . '_FOO', 'foo');
        \define(self::$_constBar = self::$_constPrefix . '_BAR', 'bar');
    }

    /**
     * @covers ::getCategoryList()
     */
    public function test_get_category_list()
    {
        $list = ConstUtil::getList('user');
        $this->assertArrayHasKey(self::$_constFoo, $list);
        $this->assertArrayHasKey(self::$_constBar, $list);

        $this->assertSame([], ConstUtil::getList('doesnt exist'));
    }

    /**
     * @covers ::getCategoryList()
     */
    public function test_get_category_list_strtolower_fallback()
    {
        $list1 = ConstUtil::getList('USER');
        $list2 = ConstUtil::getList('user');

        $this->assertSame($list1, $list2);
    }

    /**
     * @covers ::getCategoryList()
     */
    public function test_get_category_list_ucfirst_fallback()
    {
        $list1 = ConstUtil::getList('core');
        $list2 = ConstUtil::getList('Core');

        $this->assertSame($list1, $list2);
    }

    /**
     * @covers ::split()
     */
    public function test_split()
    {
        $this->assertSame([ ConstantsFixture::class, 'FOO' ], ConstUtil::split(ConstantsFixture::class . '::FOO'));
        $this->assertSame([ 'Some\Class', 'BAR' ], ConstUtil::split('\Some\Class::BAR'));

        $this->assertNull(ConstUtil::split('GLOBAL_CONST'));
    }
}
