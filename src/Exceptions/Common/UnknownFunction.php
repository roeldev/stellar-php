<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\BadFunctionCallException;

class UnknownFunction extends BadFunctionCallException
{
    public static function factory(string $function) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Function `{function}` does not exist')
            ->withArguments(\compact('function'))
            ->withSeverity(Severity::ERROR());
    }
}
