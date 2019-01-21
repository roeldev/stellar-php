<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Logic\LogicException;

class BazExceptionFixture extends LogicException implements ExceptionFixture
{
    public static function factory(string $msg) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('[{exception.code}] Baz: {msg}')
            ->withArguments(\compact('msg'))
            ->withSeverity(Severity::CRITICAL());
    }
}
