<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Limitations\Testing\AssertProhibitWakeup;

/**
 * @property-read string $expectException
 */
class AssertProhibitWakeupFixture
{
    use AssertProhibitWakeup;
    use CaptureMethodCalls;
}
