<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\RuntimeException;

class BarExceptionFixture extends RuntimeException implements ExceptionFixture
{
    public static function factory() : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Bar exception with severity [{severity}]');
    }
}
