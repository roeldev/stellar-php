<?php declare(strict_types=1);

namespace UnitTests\Common;

use Stellar\Common\Contracts\InvokableInterface;
use Stellar\Common\Contracts\StringableInterface;
use Stellar\Common\Traits\ToString;

trait AssertTestsDataProvider
{
    public static function provideTruthy() : array
    {
        return [
            [ true ],
            [ 1 ],
            [ '1' ],
            [ 'true' ],
            [ 'TRUE' ],
            [ 'on' ],
            [ 'On' ],
            [ 'y' ],
            [ 'yes' ],
        ];
    }

    public static function provideFalsey() : array
    {
        return [
            [ false ],
            [ null ],
            [ [] ],
            [ '' ],
            [ 0 ],
            [ '0' ],
            [ 'false' ],
            [ 'FALSE' ],
            [ 'off' ],
            [ 'Off' ],
            [ 'n' ],
            [ 'no' ],
        ];
    }
}

class InvokableFixture implements InvokableInterface
{
    public function __invoke()
    {
    }
}

class StringableFixture implements StringableInterface
{
    use ToString;

    public function __toString() : string
    {
        return 'foobar';
    }
}
