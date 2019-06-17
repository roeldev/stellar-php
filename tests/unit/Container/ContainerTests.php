<?php declare(strict_types=1);

namespace UnitTests\Container;

use Stellar\Container\Container;
use Stellar\Container\Exceptions\SingletonExistsException;
use Stellar\Container\ServiceRequest;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Limitations\Testing\AssertProhibitCloning;

/**
 * @coversDefaultClass \Stellar\Container\Container
 * @see \UnitTests\Container\BasicContainerTests
 */
class ContainerTests extends BasicContainerTests
{
    use AssertProhibitCloning;

    /**
     * @return Container
     */
    public static function factory(...$params)
    {
        return new Container(...$params);
    }

    /**
     * @covers ::__clone()
     */
    public function test_prohibit_cloning()
    {
        $this->assertProhibitCloning(new Container());
    }

    /**
     * @covers ::__construct()
     * @covers ::getName()
     */
    public function test_name()
    {
        $this->assertSame('foo', (new Container('foo'))->getName());
        $this->assertNull((new Container())->getName());
    }

    /**
     * @covers ::request()
     */
    public function test_request_existing_service()
    {
        /** @var Container $container */
        $container = static::factory();

        $alias = 'foobar';
        $count = 0;

        $expected = $container->set($alias, new \ArrayObject([ 'thats', 'right' ]));
        $actual = $container->request($alias, function () use (&$count) {
            // because the service exists, this callback function should never be called
            $count++;

            return new ServiceRequest(new \ArrayObject([ 'its', 'not', 'me' ]));
        });

        $this->assertSame($expected, $actual);
        $this->assertEquals(0, $count);
    }

    /**
     * @covers ::request()
     */
    public function test_request_with_invalid_class()
    {
        $this->expectException(InvalidClass::class);
        $this->assertException(function () {
            /** @var Container $container */
            $container = static::factory();
            $container->request('alias', function () {
                return new \ArrayObject();
            });
        });
    }

    /**
     * @covers ::request()
     * @covers ::hasSingleton()
     */
    public function test_request_singleton_service()
    {
        /** @var Container $container */
        $container = static::factory();
        $service = $container->request('foo', function () {
            return ServiceRequest::with(new \ArrayObject())->asSingleton();
        });

        $this->assertTrue($container->hasSingleton('foo'));
        $this->assertTrue($container->hasSingleton($service));
    }

    /**
     * @covers ::set()
     */
    public function test_exception_when_overwriting_singleton_service()
    {
        /** @var Container $container */
        $container = static::factory();

        $alias = 'foo';
        $container->request($alias, function () {
            return ServiceRequest::with(new \ArrayObject())->asSingleton();
        });

        $this->assertCount(1, $container);
        $this->expectException(SingletonExistsException::class);
        $this->assertException(function () use ($container, $alias) {
            $container->set($alias, (object) [ 'fizz', 'buzz' ]);
        });
    }
}
