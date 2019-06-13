<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\Logic\InvalidArgumentException;
use Throwable;

class InvalidArgument extends InvalidArgumentException
{
    public function __construct(string $argument, $expected, $actual, ?Throwable $previous = null)
    {
        $type = 'type';

        if (\is_string($expected) && \class_exists($expected)) {
            $type = 'class';
            $expected = Stringify::objectClass($expected);
            $actual = Stringify::objectClass($actual);
        }

        parent::__construct(
            \sprintf('Invalid argument for `{argument}`, %s `{actual}` should be of `{expected}`', $type),
            0,
            $previous,
            \compact('argument', 'expected', 'actual')
        );
    }
}
