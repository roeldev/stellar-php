<?php declare(strict_types=1);

namespace UnitTests\Support;

use Stellar\Common\Dummy;

class TypeTestsData
{
    public function simpleTypes() : array
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

    public function detailedTypes() : array
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
