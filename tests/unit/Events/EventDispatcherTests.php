<?php declare(strict_types=1);

namespace UnitTests\Events;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Dummy;
use Stellar\Events\EventDispatcher;
use Stellar\Exceptions\Common\InvalidType;

/**
 * @coversDefaultClass \Stellar\Events\EventDispatcher
 */
class EventDispatcherTests extends TestCase
{
    /**
     * @covers ::__construct()
     */
    public function test_exception_on_invalid_owner()
    {
        $this->expectException(InvalidType::class);
        new EventDispatcher('whoops', 'test');
    }

    /**
     * @covers ::__construct()
     * @covers ::getOwner()
     */
    public function test_get_owner()
    {
        $owner = new \ArrayObject();
        $dispatcher = new EventDispatcher($owner, 'test');

        $this->assertSame($owner, $dispatcher->getOwner());
    }

    /**
     * @covers ::__construct()
     * @covers ::getNamespace()
     */
    public function test_get_namespace()
    {
        $dispatcher = new EventDispatcher(new \ArrayObject(), 'foo.bar');
        $this->assertSame('foo.bar', $dispatcher->getNamespace());
    }

    /**
     * @covers ::__construct()
     * @covers ::getNamespace()
     */
    public function test_get_namespace_ending_with_dot()
    {
        $dispatcher = new EventDispatcher(new \ArrayObject(), 'foo.bar.');
        $this->assertSame('foo.bar', $dispatcher->getNamespace());
    }

    /**
     * @covers ::getListeners()
     * @covers ::hasListeners()
     */
    public function test_empty_dispatcher()
    {
        $dispatcher = new EventDispatcher(new \ArrayObject(), 'test');
        $this->assertFalse($dispatcher->hasListeners('test.some.event'));
        $this->assertNull($dispatcher->getListeners('test.some.event'));
        $this->assertEquals([], $dispatcher->getAllListeners());
    }

    /**
     * @covers ::addListener()
     * @covers ::getListeners()
     * @covers ::getAllListeners()
     * @covers ::hasListeners()
     */
    public function test_dispatcher_with_listeners()
    {
        $dispatcher = new EventDispatcher(new \ArrayObject(), 'test');

        $listener = Dummy::closure();
        $id = $dispatcher->addListener('test.event', $listener, 99, EventDispatcher::OPTION_ONCE);

        $expected = [
            $id => [ $listener, 99, EventDispatcher::OPTION_ONCE ],
        ];

        $this->assertTrue($dispatcher->hasListeners('test.event'));
        $this->assertSame($expected, $dispatcher->getListeners('test.event'));
        $this->assertSame([ 'test.event' => $expected ], $dispatcher->getAllListeners());
    }

    /**
     * @covers ::addListener()
     */
    public function test_add_multiple_listeners_to_same_event()
    {
        $dispatcher = new EventDispatcher(new \ArrayObject(), 'test');
        $dispatcher->addListener('test.event', Dummy::closure());

        $dispatcher->addListener('test.event', Dummy::closure(), 1);


    }
}
