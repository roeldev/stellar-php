<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown if an argument is not of the expected type.
 *
 * @see http://php.net/manual/en/class.invalidargumentexception.php
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
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
