<?php declare(strict_types=1);

namespace Stellar\Curl\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\RuntimeException;

final class RequestFailure extends RuntimeException implements CurlException
{
    public static function factory(int $errorCode, string $errorMessage) : ExceptionFactory
    {
        return ExceptionFactory::init(static::class)
            ->withMessage('Bad CURL response: [{errorCode}] {errorMessage}')
            ->withArguments(\compact('errorCode', 'errorMessage'));
    }
}
