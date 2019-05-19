<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Str;

/**
 * @coversDefaultClass \Stellar\Common\Str
 */
class StringFnTests extends TestCase
{
    /**
     * @covers ::isEmpty()
     */
    public function test_isEmpty()
    {
        $this->assertTrue(Str::isEmpty());
        $this->assertTrue(Str::isEmpty(''));
        $this->assertFalse(Str::isEmpty('0'));
        $this->assertFalse(Str::isEmpty(' '));

        // both true
        $this->assertSame(empty(null), Str::isEmpty(null));
        $this->assertSame(empty(''), Str::isEmpty(''));

        // difference: empty('0') = true, while StringFn::isEmpty('0') = false
        $this->assertNotSame(empty('0'), Str::isEmpty('0'));
    }

    public function test_replaceVars()
    {
        $this->assertSame('test', Str::replaceVars('{key}', [ 'key' => 'test' ]));
        $this->assertSame('{key}', Str::replaceVars('{key}', [ 'test' => 'test' ]));
    }

    /**
     * @covers ::startsWith()
     */
    public function test_startsWith()
    {
        $this->assertTrue(Str::startsWith('foobar', 'foo'));

        $this->assertFalse(Str::startsWith('', '')); // an empty string starts with nothing
        $this->assertFalse(Str::startsWith('', 'foobar'));
        $this->assertFalse(Str::startsWith('foobar', ''));
        $this->assertFalse(Str::startsWith('foobar', 'bar'));
    }

    /**
     * @covers ::endsWith()
     */
    public function test_endsWith()
    {
        $this->assertTrue(Str::endsWith('foo', 'foo'));
        $this->assertTrue(Str::endsWith('foobar', 'bar'));
        $this->assertTrue(Str::endsWith('bar foo bar', 'bar'));
        $this->assertTrue(Str::endsWith('path/to/', '/'));

        $this->assertFalse(Str::endsWith('', '')); // and empty string ends with nothing
        $this->assertFalse(Str::endsWith('', 'foobar'));
        $this->assertFalse(Str::endsWith('foobar', ''));
        $this->assertFalse(Str::endsWith('foobar', 'foo'));
    }

    /**
     * @covers ::prefix()
     */
    public function test_prefix()
    {
        $this->assertEquals('-', Str::prefix('', '-'));
        $this->assertEquals('foo', Str::prefix('', 'foo'));
        $this->assertEquals('/path/to/', Str::prefix('path/to/', '/'));
    }

    /**
     * @covers ::prefix()
     */
    public function test_unable_to_prefix()
    {
        $this->assertEquals('', Str::prefix('', ''));
        $this->assertEquals('foo', Str::prefix('foo', ''));
        $this->assertEquals('foo', Str::prefix('foo', 'foo'));
        $this->assertEquals('/path/to/', Str::prefix('/path/to/', '/'));
    }

    /**
     * @covers ::unprefix()
     */
    public function test_unprefix()
    {
        $this->assertEquals('some=query&value', Str::unPrefix('?some=query&value', '?'));
        $this->assertEquals('bar0', Str::unPrefix('foo-bar0', 'foo-'));
    }

    /**
     * @covers ::unprefix()
     */
    public function test_unable_to_unprefix()
    {
        $this->assertEquals('foo-bar', Str::unPrefix('foo-bar', ''));
        $this->assertEquals('foo-bar', Str::unPrefix('foo-bar', '-'));
        $this->assertEquals('some=query&value', Str::unPrefix('some=query&value', '?'));
    }

    /**
     * @covers ::suffix()
     */
    public function test_suffix()
    {
        $this->assertEquals('-', Str::suffix('', '-'));
        $this->assertEquals('foo', Str::suffix('', 'foo'));
        $this->assertEquals('localhost:81', Str::suffix('localhost', ':81'));
        $this->assertEquals('/path/to/', Str::suffix('/path/to', '/'));
    }

    /**
     * @covers ::suffix()
     */
    public function test_unable_to_suffix()
    {
        $this->assertEquals('', Str::suffix('', ''));
        $this->assertEquals('foo', Str::suffix('foo', ''));
        $this->assertEquals('foo', Str::suffix('foo', 'foo'));
        $this->assertEquals('localhost:81', Str::suffix('localhost:81', ':81'));
        $this->assertEquals('/path/to/', Str::suffix('/path/to/', '/'));
    }

    /**
     * @covers ::unsuffix()
     */
    public function test_unsuffix()
    {
        $this->assertEquals('localhost', Str::unSuffix('localhost:81', ':81'));
        $this->assertEquals('foo-', Str::unSuffix('foo-bar0', 'bar0'));
    }

    /**
     * @covers ::unsuffix()
     */
    public function test_unable_to_unsuffix()
    {
        $this->assertEquals('foo-bar', Str::unSuffix('foo-bar', ''));
        $this->assertEquals('foo-bar', Str::unSuffix('foo-bar', '-'));
    }
}
