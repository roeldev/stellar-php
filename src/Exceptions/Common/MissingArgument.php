<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\BadMethodCallException;

class MissingArgument extends BadMethodCallException
{
    /**
     * (string $class, string $method)
     * (string $function)
     * (\Closure $closure)
     *
     * @return ExceptionFactory
     */
    public static function factory($caller, ?string $method = null) : ExceptionFactory
    {
        $factory = ExceptionFactory::init(self::class);

        if (null !== $method) {
            $factory->withMessage('Missing argument(s) for method `{method}` of class `{class}`')
                ->withArguments([ 'class' => (string) $caller, 'method' => $method ]);
        }
        elseif ($caller instanceof \Closure) {
            $factory->withMessage('Missing argument(s) for closure')
                ->withArguments([ 'closure' => $caller ]);
        }
        else {
            $factory->withMessage('Missing argument(s) for function `{function}`')
                ->withArguments([ 'function' => (string) $caller ]);
        }

        return $factory;
    }
}
