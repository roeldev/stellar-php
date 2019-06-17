<?php declare(strict_types=1);

namespace UnitTests\Limitations\Testing;

use Stellar\Common\Testing\CaptureMethodCalls;
use Stellar\Limitations\Testing\AssertProhibitCloning;

/**
 * @property-read string $expectException
 */
class AssertProhibitCloningFixture
{
    use AssertProhibitCloning;
    use CaptureMethodCalls;
}
