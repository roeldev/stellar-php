<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Common\Stringify;
use Stellar\Exceptions\Logic\BadMethodCallException;
use Throwable;

class MissingArgument extends BadMethodCallException
{
    public function __construct(string $function, $classOrObject = null, ?Throwable $previous = null)
    {
        $message = (null === $classOrObject)
            ? 'Missing argument(s) for function `{function}`'
            : 'Missing argument(s) for method `{method}` of class `{class}`';

        parent::__construct($message, 0, $previous, [
            'function' => $function,
            'class' => Stringify::objectClass($classOrObject),
        ]);
    }
}
