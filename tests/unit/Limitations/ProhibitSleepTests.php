<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;
use Stellar\Limitations\Testing\AssertProhibitSleep;

/**
 * @coversDefaultClass \Stellar\Limitations\ProhibitSleepTrait
 */
class ProhibitSleepTests extends TestCase
{
    use AssertException;
    use AssertProhibitSleep;

    /**
     * @covers ::__sleep()
     */
    public function test()
    {
        $this->assertProhibitSleep(new ProhibitSleepFixture());
    }
}
