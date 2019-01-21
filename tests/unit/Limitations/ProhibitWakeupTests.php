<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;
use Stellar\Limitations\Testing\AssertProhibitWakeup;

/**
 * @coversDefaultClass \Stellar\Limitations\ProhibitWakeup
 */
class ProhibitWakeupTests extends TestCase
{
    use AssertException;
    use AssertProhibitWakeup;

    /**
     * @covers ::__wakeup()
     */
    public function test()
    {
        $this->assertProhibitWakeup(new ProhibitWakeupFixture());
    }
}
