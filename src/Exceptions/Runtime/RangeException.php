<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown to indicate range errors during program execution. Normally this means there was an arithmetic
 * error other than under/overflow. This is the runtime version of DomainException.
 *
 * @see http://php.net/manual/en/class.rangeexception.php
 */
class RangeException extends \RangeException implements ExceptionInterface
{
    use ExtendExceptionTrait;

    /**
     * @see \Stellar\Exceptions\Exception::__construct()
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null,
        array $arguments = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->_withArguments($arguments);
    }
}
