<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\Logic\InvalidArgumentException;
use Throwable;

class InvalidClass extends InvalidArgumentException
{
    /**
     * @param object|string $expected
     * @param object|string $actual
     */
    public function __construct($expected, $actual, ?Throwable $previous = null)
    {
        $expected = Stringify::objectClass($expected);
        $actual = Stringify::objectClass($actual);

        parent::__construct(
            'Class `{actual}` should be of `{expected}`',
            0,
            $previous,
            \compact('expected', 'actual')
        );
    }
}
