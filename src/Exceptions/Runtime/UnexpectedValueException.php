<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown if a value does not match with a set of values. Typically this happens when a function calls
 * another function and expects the return value to be of a certain type or value not including arithmetic or
 * buffer related errors.
 *
 * @see http://php.net/manual/en/class.unexpectedvalueexception.php
 */
class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
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
