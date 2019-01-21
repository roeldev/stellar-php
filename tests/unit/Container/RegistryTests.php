<?php declare(strict_types=1);

namespace UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Testing\AssertSingleton;
use Stellar\Common\Testing\AssertStaticClass;
use Stellar\Container\Registry;

/**
 * @coversDefaultClass \Stellar\Container\Registry
 */
class RegistryTests extends TestCase
{
    use AssertSingleton;
    use AssertStaticClass;

    public function test_static_class()
    {
        $this->assertStaticClass(Registry::class);
    }

    public function test_is_singleton()
    {
        $this->assertSingleton(Registry::class);
    }

    /**
     * @covers ::instance()
     */
    public function test_getting_a_singleton_instance()
    {
        $registry = Registry::instance();
        $this->assertSame(Registry::class, $registry->getName());
    }

    /**
     * @covers ::container()
     */
    public function test_getting_the_same_container_instance()
    {
        $actual = Registry::container(__CLASS__);
        $expected = Registry::container(__CLASS__);

        $this->assertSame($expected, $actual);
        $this->assertSame($expected->set('test', new \ArrayObject()), $actual->get('test'));
    }

    /**
     * @covers ::singleton()
     */
    public function test_getting_the_same_singleton_instance()
    {
        $instance = Registry::singleton(\ArrayObject::class, [ [ 'foo', 'bar', 'baz' ] ]);

        $this->assertSame($instance, Registry::singleton(\ArrayObject::class));
        $this->assertSame($instance, Registry::instance()->get(\ArrayObject::class));
    }

    /**
     * @covers ::singleton()
     */
    public function test_both_singleton_instances_are_the_same()
    {
        $instance1 = SingletonFixture::instance();
        $instance2 = SingletonFixture::instance();

        $instance1->foo = 22;

        $this->assertSame($instance1, $instance2);
        $this->assertSame(22, $instance2->foo);
    }
}
