<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\Logic\BadFunctionCallException;
use Throwable;

class UnknownFunction extends BadFunctionCallException
{
    public function __construct(string $function, ?Throwable $previous = null)
    {
        parent::__construct(
            'Function `{function}` does not exist',
            0,
            $previous,
            \compact('function')
        );
    }
}
