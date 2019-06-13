<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Limitations\Testing\AssertProhibitSleep;

/**
 * @property-read string $expectException
 */
class AssertProhibitSleepFixture
{
    use AssertProhibitSleep;
    use CaptureMethodCalls;
}
