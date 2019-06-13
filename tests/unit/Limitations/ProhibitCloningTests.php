<?php declare(strict_types=1);

namespace UnitTests\Limitations;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Testing\AssertException;
use Stellar\Limitations\Testing\AssertProhibitCloning;

/**
 * @coversDefaultClass \Stellar\Limitations\ProhibitCloningTrait
 */
class ProhibitCloningTests extends TestCase
{
    use AssertException;
    use AssertProhibitCloning;

    /**
     * @covers ::__clone()
     */
    public function test()
    {
        $this->assertProhibitCloning(new ProhibitCloningFixture());
    }
}
