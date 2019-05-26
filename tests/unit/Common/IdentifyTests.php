<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Dummy;
use Stellar\Common\Identify;

/**
 * @coversDefaultClass \Stellar\Common\Identiy
 */
class IdentifyTests extends TestCase
{
    public function test_object()
    {
        $str = (string) Identify::object(new \ArrayObject());
        $this->assertStringMatchesFormat('ArrayObject_%x', $str);
        $this->assertSame(44, \strlen($str));
    }

    public function test_object_array()
    {
        $str = (string) Identify::object((object) []);
        $this->assertStringMatchesFormat('stdClass_%x', $str);
        $this->assertSame(41, \strlen($str));
    }

    public function test_object_anonymous()
    {
        $str = (string) Identify::object(Dummy::anonymousObject());
        $this->assertStringMatchesFormat('class@anonymous%s.php0x%x', $str);
    }

    public function test_callable_string()
    {
        $this->assertSame('Closure::bind', Identify::callable('Closure::bind'));
    }

    public function test_callable_closure()
    {
        $str = (string) Identify::callable(Dummy::closure());
        $this->assertStringMatchesFormat('Closure_%x', $str);
        $this->assertSame(40, \strlen($str));
    }

    public function test_callable_object_and_method()
    {
        $str = (string) Identify::callable([ new \ArrayObject(), 'count' ]);
        $this->assertStringMatchesFormat('ArrayObject_%x->count', $str);
    }

    public function test_callable_static_class_method()
    {
        $str = (string) Identify::callable([ \Closure::class, 'bind' ]);
        $this->assertStringMatchesFormat('Closure::bind', $str);
    }

    public function test_callable_string_is_same_as_static_class_method()
    {
        $this->assertSame(
            Identify::callable('Closure::bind'),
            Identify::callable([ \Closure::class, 'bind' ])
        );
    }

    public function test_callable_anonymous_class_and_method()
    {
        $obj = new class
        {
            public function callback()
            {
            }
        };

        $str = (string) Identify::callable([ $obj, 'callback' ]);
        $this->assertStringStartsWith('class@anonymous', $str);
        $this->assertStringMatchesFormat('class@anonymous%s.php0x%x->callback', $str);
    }

    public function test_callable_invokable_object()
    {
        $str = (string) Identify::callable(new InvokableFixture());
        $this->assertStringMatchesFormat('%s\InvokableFixture_%x', $str);
    }

    public function test_callable_anonymous_invokable_object()
    {
        $str = (string) Identify::callable(new class
        {
            public function __invoke()
            {
            }
        });

        $this->assertStringStartsWith('class@anonymous', $str);
        $this->assertStringMatchesFormat('class@anonymous%s.php0x%x', $str);
    }
}
