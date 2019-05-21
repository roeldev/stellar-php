<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\StaticClass;
use Stellar\Common\Testing\AssertStaticClass;

/**
 * @coversDefaultClass \Stellar\Common\StaticClass
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
        $this->assertIsCallable([ StaticClassFixture::class, 'staticMethod' ]);
    }
}

/**
 * @internal
 */
final class StaticClassFixture extends StaticClass
{
    public static function staticMethod() : void
    {
    }
}
