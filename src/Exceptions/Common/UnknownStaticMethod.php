<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\Logic\BadMethodCallException;
use Throwable;

/**
 * Use when a call to `__callStatic()` is invalid.
 */
class UnknownStaticMethod extends BadMethodCallException
{
    public function __construct(string $class, string $method, ?Throwable $previous = null)
    {
        parent::__construct(
            'Static method `{method}` does not exist in class `{class}`',
            0,
            $previous,
            \compact('class', 'method')
        );
    }
}
