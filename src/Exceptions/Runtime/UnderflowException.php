<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown when performing an invalid operation on an empty container, such as removing an element.
 *
 * @see http://php.net/manual/en/class.underflowexception.php
 */
class UnderflowException extends \UnderflowException implements ExceptionInterface
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
