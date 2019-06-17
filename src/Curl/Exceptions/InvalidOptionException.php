<?php declare(strict_types=1);

namespace Stellar\Curl\Exceptions;

use Stellar\Exceptions\Logic\DomainException;
use Throwable;

class InvalidOptionException extends DomainException implements CurlException
{
    public function __construct(string $option, $value, ?Throwable $previous = null)
    {
        parent::__construct(
            'Invalid CURL option `{option}` with value `{value}`',
            0,
            $previous,
            \compact('option', 'value')
        );
    }
}
