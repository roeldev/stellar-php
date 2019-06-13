<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Limitations\Testing\AssertProhibitSerialization;

/**
 * @property-read string $expectException
 */
class AssertProhibitSerializationFixture
{
    use AssertProhibitSerialization;
    use CaptureMethodCalls;
}
