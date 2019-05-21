<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\StringUtil;

/**
 * @coversDefaultClass \Stellar\Common\StringUtil
 */
class StringUtilTests extends TestCase
{
    public function test_replaceVars()
    {
        $this->assertSame('test', StringUtil::replaceVars('{key}', [ 'key' => 'test' ]));
        $this->assertSame('{key}', StringUtil::replaceVars('{key}', [ 'test' => 'test' ]));
    }

    /**
     * @covers ::startsWith()
     */
    public function test_startsWith()
    {
        $this->assertTrue(StringUtil::startsWith('foobar', 'foo'));

        $this->assertFalse(StringUtil::startsWith('', '')); // an empty string starts with nothing
        $this->assertFalse(StringUtil::startsWith('', 'foobar'));
        $this->assertFalse(StringUtil::startsWith('foobar', ''));
        $this->assertFalse(StringUtil::startsWith('foobar', 'bar'));
    }

    /**
     * @covers ::endsWith()
     */
    public function test_endsWith()
    {
        $this->assertTrue(StringUtil::endsWith('foo', 'foo'));
        $this->assertTrue(StringUtil::endsWith('foobar', 'bar'));
        $this->assertTrue(StringUtil::endsWith('bar foo bar', 'bar'));
        $this->assertTrue(StringUtil::endsWith('path/to/', '/'));

        $this->assertFalse(StringUtil::endsWith('', '')); // and empty string ends with nothing
        $this->assertFalse(StringUtil::endsWith('', 'foobar'));
        $this->assertFalse(StringUtil::endsWith('foobar', ''));
        $this->assertFalse(StringUtil::endsWith('foobar', 'foo'));
    }

    /**
     * @covers ::prefix()
     */
    public function test_prefix()
    {
        $this->assertEquals('-', StringUtil::prefix('', '-'));
        $this->assertEquals('foo', StringUtil::prefix('', 'foo'));
        $this->assertEquals('/path/to/', StringUtil::prefix('path/to/', '/'));
    }

    /**
     * @covers ::prefix()
     */
    public function test_unable_to_prefix()
    {
        $this->assertEquals('', StringUtil::prefix('', ''));
        $this->assertEquals('foo', StringUtil::prefix('foo', ''));
        $this->assertEquals('foo', StringUtil::prefix('foo', 'foo'));
        $this->assertEquals('/path/to/', StringUtil::prefix('/path/to/', '/'));
    }

    /**
     * @covers ::unprefix()
     */
    public function test_unprefix()
    {
        $this->assertEquals('some=query&value', StringUtil::unprefix('?some=query&value', '?'));
        $this->assertEquals('bar0', StringUtil::unprefix('foo-bar0', 'foo-'));
    }

    /**
     * @covers ::unprefix()
     */
    public function test_unable_to_unprefix()
    {
        $this->assertEquals('foo-bar', StringUtil::unprefix('foo-bar', ''));
        $this->assertEquals('foo-bar', StringUtil::unprefix('foo-bar', '-'));
        $this->assertEquals('some=query&value', StringUtil::unprefix('some=query&value', '?'));
    }

    /**
     * @covers ::suffix()
     */
    public function test_suffix()
    {
        $this->assertEquals('-', StringUtil::suffix('', '-'));
        $this->assertEquals('foo', StringUtil::suffix('', 'foo'));
        $this->assertEquals('localhost:81', StringUtil::suffix('localhost', ':81'));
        $this->assertEquals('/path/to/', StringUtil::suffix('/path/to', '/'));
    }

    /**
     * @covers ::suffix()
     */
    public function test_unable_to_suffix()
    {
        $this->assertEquals('', StringUtil::suffix('', ''));
        $this->assertEquals('foo', StringUtil::suffix('foo', ''));
        $this->assertEquals('foo', StringUtil::suffix('foo', 'foo'));
        $this->assertEquals('localhost:81', StringUtil::suffix('localhost:81', ':81'));
        $this->assertEquals('/path/to/', StringUtil::suffix('/path/to/', '/'));
    }

    /**
     * @covers ::unsuffix()
     */
    public function test_unsuffix()
    {
        $this->assertEquals('localhost', StringUtil::unsuffix('localhost:81', ':81'));
        $this->assertEquals('foo-', StringUtil::unsuffix('foo-bar0', 'bar0'));
    }

    /**
     * @covers ::unsuffix()
     */
    public function test_unable_to_unsuffix()
    {
        $this->assertEquals('foo-bar', StringUtil::unsuffix('foo-bar', ''));
        $this->assertEquals('foo-bar', StringUtil::unsuffix('foo-bar', '-'));
    }
}
