<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown when adding an element to a full container.
 *
 * @see http://php.net/manual/en/class.overflowexception.php
 */
class OverflowException extends \OverflowException implements ExceptionInterface
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
