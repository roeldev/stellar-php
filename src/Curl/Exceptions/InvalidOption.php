<?php declare(strict_types=1);

namespace Stellar\Curl\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Logic\DomainException;

final class InvalidOption extends DomainException implements CurlException
{
    public static function factory($option, $value) : ExceptionFactory
    {
        return ExceptionFactory::init(static::class)
            ->withMessage('Invalid CURL option `{option}` with value `{value}`')
            ->withArguments(\compact('option', 'value'));
    }
}
