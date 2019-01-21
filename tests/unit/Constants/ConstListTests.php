<?php declare(strict_types=1);

namespace UnitTests\Constants;

use PHPUnit\Framework\TestCase;
use Stellar\Constants\ConstList;

/**
 * @coversDefaultClass \Stellar\Constants\ConstList
 */
class ConstListTests extends TestCase
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
     * @covers ::fromCategory()
     */
    public function test_fromCategory()
    {
        $list = ConstList::fromCategory('user');
        $this->assertArrayHasKey(self::$_constFoo, $list);
        $this->assertArrayHasKey(self::$_constBar, $list);

        $this->assertSame([], ConstList::fromCategory('doesnt exist'));
    }

    /**
     * @covers ::fromCategory()
     */
    public function test_fromCategory_strtolower_fallback()
    {
        $list1 = ConstList::fromCategory('USER');
        $list2 = ConstList::fromCategory('user');

        $this->assertSame($list1, $list2);
    }

    /**
     * @covers ::fromCategory()
     */
    public function test_fromCategory_ucfirst_fallback() {
        $list1 = ConstList::fromCategory('core');
        $list2 = ConstList::fromCategory('Core');

        $this->assertSame($list1, $list2);
    }

    /**
     * @covers ::startingWith()
     */
    public function test_startingWith()
    {
        $this->assertSame(
            [ self::$_constFoo => 'foo', self::$_constBar => 'bar' ],
            ConstList::startingWith(self::$_constPrefix)
        );
    }
}
