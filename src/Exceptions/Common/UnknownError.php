<?php declare(strict_types=1);

namespace Stellar\Exceptions\Common;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\RuntimeException;

class UnknownError extends RuntimeException
{
    public static function factory(... $args) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('An unknown error occurred')
            ->withArguments($args);
    }
}
