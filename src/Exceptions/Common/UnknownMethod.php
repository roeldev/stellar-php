<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\Logic\BadMethodCallException;
use Throwable;

/**
 * Use when a call to `__call()` is invalid.
 */
class UnknownMethod extends BadMethodCallException
{
    public function __construct($classOrObject, string $method, ?Throwable $previous = null)
    {
        parent::__construct(
            'Method `{method}` does not exist in class `{class}`',
            0,
            $previous,
            [
                'class' => Stringify::objectClass($classOrObject),
                'method' => $method,
            ]
        );
    }
}
