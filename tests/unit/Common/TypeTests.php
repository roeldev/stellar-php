<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Type;

require_once 'TypeTests.inc.php';

/**
 * @coversDefaultClass \Stellar\Common\Type
 */
class TypeTests extends TestCase
{
    use TypeTestsDataProvider;

    /**
     * @covers ::get()
     * @dataProvider provideSimpleTypes()
     */
    public function test_get(string $type, ... $params)
    {
        $this->assertSame($type, Type::get(... $params));
    }

    /**
     * @covers ::getDetailed()
     * @dataProvider provideDetailedTypes()
     */
    public function test_details(string $type, ... $params)
    {
        $this->assertSame($type, Type::details(... $params));
    }
}
