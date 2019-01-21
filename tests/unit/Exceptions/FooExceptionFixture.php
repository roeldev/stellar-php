<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\LogicException;

class FooExceptionFixture extends LogicException implements ExceptionFixture
{
    public static function factory() : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Foo message');
    }
}
