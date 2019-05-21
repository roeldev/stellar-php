<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Dummy;
use Stellar\Common\Type;

/**
 * @coversDefaultClass \Stellar\Common\Type
 */
class TypeTests extends TestCase
{
    use TypeTestsDataProvider;

    /**
     * @covers ::get()
     * @dataProvider simpleTypesProvider()
     */
    public function test_get(string $type, ... $params)
    {
        $this->assertSame($type, Type::get(... $params));
    }

    /**
     * @covers ::getDetailed()
     * @dataProvider detailedTypesProvider()
     */
    public function test_details(string $type, ... $params)
    {
        $this->assertSame($type, Type::details(... $params));
    }
}

/**
 * @internal
 */
trait TypeTestsDataProvider
{
    public function simpleTypesProvider() : array
    {
        $resource = xml_parser_create();
        xml_parser_free($resource);

        return [
            [ 'null', null ],
            [ 'bool', true ],
            [ 'int', 34653 ],
            [ 'float', 1234.546 ],
            [ 'array', [] ],
            [ 'array', [ new \ArrayObject(), 'append' ] ],
            [ 'object', new \ArrayObject() ],
            [ 'object', Dummy::anonymousObject() ],
            [ 'object', Dummy::closure() ],
            [ 'resource', $resource ],
        ];
    }

    public function detailedTypesProvider() : array
    {
        $resource = xml_parser_create();
        xml_parser_free($resource);

        return [
            [ 'null', null ],
            [ 'bool (true)', true ],
            [ 'int (34653)', 34653 ],
            [ 'float (1234.546)', 1234.546 ],
            [ 'array', [] ],
            [ 'array/callable', [ new \ArrayObject(), 'append' ] ],
            [ 'object/iterable (ArrayObject)', new \ArrayObject() ],
            [ 'object/anonymous', Dummy::anonymousObject() ],
            [ 'object/callable (Closure)', Dummy::closure() ],
            [ 'resource (xml)', $resource ],
        ];
    }
}
