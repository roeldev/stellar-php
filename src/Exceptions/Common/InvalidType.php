<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\Logic\InvalidArgumentException;
use Throwable;

/**
 * Use when an unexpected variable type is encountered.
 */
class InvalidType extends InvalidArgumentException
{
    public function __construct(string $expected, string $actual, ?Throwable $previous = null)
    {
        parent::__construct(
            'Invalid type `{actual}`, expecting `{expected}`',
            0,
            $previous,
            \compact('expected', 'actual')
        );
    }
}
