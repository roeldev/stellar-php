<?php declare(strict_types=1);

namespace UnitTests\Common\Traits;

use PHPUnit\Framework\TestCase;

class ToStringTests extends TestCase
{
    public function test()
    {
        $expected = 'foo bar baz';
        $this->assertSame($expected, (new ToStringFixture($expected))->toString());
        $this->assertSame($expected, (string) new ToStringFixture($expected));
    }
}
