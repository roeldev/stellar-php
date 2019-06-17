<?php declare(strict_types=1);

namespace Stellar\Curl\Exceptions;

use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Runtime\RuntimeException;
use Throwable;

class RequestExecutionException extends RuntimeException implements CurlException
{
    public function __construct(int $errorCode, string $errorMessage, ?Throwable $previous = null)
    {
        parent::__construct(
            'Unexpected CURL response: [{errorCode}] {errorMessage}',
            0,
            $previous,
            \compact('errorCode', 'errorMessage')
        );
    }
}
