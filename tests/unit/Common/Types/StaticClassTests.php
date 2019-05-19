<?php declare(strict_types=1);

namespace UnitTests\Common\Types;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Testing\AssertStaticClass;

/**
 * @coversDefaultClass \Stellar\Common\Types\StaticClass
 */
class StaticClassTests extends TestCase
{
    use AssertStaticClass;

    public function test_static_class()
    {
        $this->assertStaticClass(StaticClassFixture::class);
    }

    public function test_the_static_method_is_callable()
    {
        $this->assertTrue(\is_callable([ StaticClassFixture::class, 'staticMethod' ]));
    }
}
