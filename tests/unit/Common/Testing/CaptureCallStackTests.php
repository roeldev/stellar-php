<?php declare(strict_types=1);

namespace UnitTests\Common\Testing;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Testing\CaptureMethodCalls;

class CaptureCallStackTests extends TestCase
{
    public function test_capture_call_to_a_method()
    {
        $input = [ 'foo', 'bar' ];
        $fixture = new CallTraceFixture();
        $fixture->test(...$input);

        $callTrace = $fixture->getCallStack();

        $this->assertSame([ $input ], $callTrace->get('test'));
        $this->assertSame([ [ 'method' => 'test', 'arguments' => $input ] ], $callTrace->toArray());
    }

    public function test_empty_trace()
    {
        $fixture = new CallTraceFixture();
        $callTrace = $fixture->getCallStack();

        $this->assertNull($callTrace->get('someCapturedMethodCall'));
        $this->assertSame([], $callTrace->toArray());
    }
}

/**
 * @internal
 */
final class CallTraceFixture
{
    use CaptureMethodCalls;
}
