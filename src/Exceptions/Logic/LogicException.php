<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception that represents error in the program logic. This kind of exception should lead directly to a fix in your
 * code.
 *
 * @see http://php.net/manual/en/class.logicexception.php
 */
class LogicException extends \LogicException implements ExceptionInterface
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
