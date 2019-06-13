<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Limitations\Testing\AssertProhibitUnserialization;

/**
 * @property-read string $expectException
 */
class AssertProhibitUnserializationFixture
{
    use AssertProhibitUnserialization;
    use CaptureMethodCalls;
}
