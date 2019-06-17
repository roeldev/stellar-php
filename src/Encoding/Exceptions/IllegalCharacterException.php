<?php declare(strict_types=1);

namespace Stellar\Encoding\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\OutOfBoundsException;
use Throwable;

class IllegalCharacterException extends OutOfBoundsException implements EncodingException
{
    public function __construct(string $char, int $offset, ?string $data = null, ?Throwable $previous = null)
    {
        $message = 'Illegal character `{char}` at offset {offset}';
        if (null !== $data) {
            $message .= ' of `{data}`';
        }

        parent::__construct($message, 0, $previous, \compact('char', 'offset', 'data'));
    }
}
