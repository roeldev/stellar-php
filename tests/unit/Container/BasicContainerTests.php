<?php declare(strict_types=1);

namespace UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Stellar\Container\BasicContainer;
use Stellar\Container\Container;
use Stellar\Container\Exceptions\NotFound;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Container\BasicContainer
 */
class BasicContainerTests extends TestCase
{
    use AssertException;

    /**
     * @return BasicContainer
     */
    public static function factory(...$params)
    {
        return new BasicContainer($params);
    }

    /**
     * @covers ::get()
     * @covers ::has()
     * @covers ::set()
     */
    public function test_set_has_get_service()
    {
        /** @var BasicContainer $container */
        $container = static::factory();
        $service = $container->set('foo', new \ArrayObject());

        $this->assertTrue($container->has('foo'));
        $this->assertSame($service, $container->get('foo'));
    }

    /**
     * @covers ::set()
     */
    public function test_exception_when_setting_a_non_object()
    {
        $this->expectException(InvalidType::class);

        /** @var BasicContainer $container */
        $container = static::factory();
        $container->set('bar', []);
    }

    /**
     * @covers ::get()
     * @covers ::has()
     * @covers ::set()
     */
    public function test_overwrite_existing_service()
    {
        /** @var BasicContainer $container */
        $container = static::factory();
        $service1 = $container->set('foo', new \ArrayObject([ 'foo' ]));
        $service2 = $container->set('foo', new \ArrayObject([ 'bar' ]));

        $this->assertCount(1, $container);
        $this->assertTrue($container->has('foo'));
        $this->assertSame($service2, $container->get('foo'));
        $this->assertFalse($container->has($service1));
        $this->assertTrue($container->has($service2));
    }

    /**
     * @covers ::has()
     */
    public function test_check_if_alias_exists()
    {
        /** @var BasicContainer $container */
        $container = static::factory();
        $container->set('foo', new \ArrayObject());

        $this->assertTrue($container->has('foo'));
        $this->assertFalse($container->has('bar'));
    }

    /**
     * @covers ::has()
     */
    public function test_check_if_service_exists()
    {
        /** @var BasicContainer $container */
        $container = static::factory();
        $service = $container->set('foo', new \ArrayObject());

        $this->assertTrue($container->has($service));
        $this->assertFalse($container->has(new \ArrayObject()));
    }

    /**
     * @covers ::get()
     */
    public function test_get_the_right_object()
    {
        /** @var BasicContainer $container */
        $container = static::factory();

        $values = [ 'foo', 'bar', 'baz' ];
        $expected = $container->set('foo', new \ArrayObject($values));

        $this->assertSame($expected, $container->get('foo'));
        $this->assertEquals($values, $container->get('foo')->getArrayCopy());
    }

    /**
     * @covers ::getId()
     */
    public function test_get_alias_of_service()
    {
        /** @var BasicContainer $container */
        $container = static::factory();

        $alias = 'fizzbuzz';
        $service = $container->set($alias, new \ArrayObject([ 'fizz', 'buzz' ]));

        $this->assertSame($alias, $container->getId($service));
        $this->assertSame([ $alias ], $container->getIds());
    }

    /**
     * @covers ::getIds()
     */
    public function test_get_aliases()
    {
        /** @var BasicContainer $container */
        $container = static::factory();

        $container->set('foo', new \ArrayObject());
        $container->set('bar', new \ArrayObject());
        $this->assertSame([ 'foo', 'bar' ], $container->getIds());

        $container->set('foo', new Container());
        $this->assertSame([ 'foo', 'bar' ], $container->getIds());
    }

    /**
     * @covers ::get()
     */
    public function test_get_exception_on_unknown_service()
    {
        $this->expectException(NotFound::class);
        $this->assertException(function () {
            static::factory()->get('foo');
        });
    }

    /**
     * @covers ::unset()
     */
    public function test_unset_alias()
    {
        $alias = 'foobar';

        /** @var BasicContainer $container */
        $container = static::factory();
        $container->set($alias, new \ArrayObject());

        $this->assertSame(1, $container->count());
        $this->assertSame([ $alias ], $container->unset($alias, 'not existing'));
        $this->assertSame(0, $container->count());
    }

    /**
     * @covers ::unset()
     */
    public function test_unset_service()
    {
        $alias = 'foobar';

        /** @var BasicContainer $container */
        $container = static::factory();
        $service = $container->set($alias, new \ArrayObject());

        $this->assertSame(1, $container->count());
        $this->assertSame([ $alias ], $container->unset('not existing', $service));
        $this->assertSame(0, $container->count());
    }

    /**
     * @covers ::count()
     */
    public function test_count_added_objects()
    {
        /** @var BasicContainer $container */
        $container = static::factory();

        $this->assertSame(0, $container->count());

        $container->set('foo', new \ArrayObject());
        $this->assertSame(1, $container->count());

        $container->set('bar', new \ArrayObject());
        $this->assertSame(2, $container->count());
    }
}
