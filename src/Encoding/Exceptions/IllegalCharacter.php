<?php declare(strict_types=1);

namespace Stellar\Encoding\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\OutOfBoundsException;

class IllegalCharacter extends OutOfBoundsException implements EncodingException
{
    public static function factory(string $char, int $offset) : ExceptionFactory
    {
        return ExceptionFactory::init(self::class)
            ->withMessage('Illegal character `{char}` at offset {offset}')
            ->withArguments(\compact('char', 'offset'));
    }
}
