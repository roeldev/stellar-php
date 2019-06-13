<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown when an illegal index was requested. This represents errors that should be detected at compile time.
 *
 * Example:
 * $arr = ['foo' => 'covfefe'];
 * $arr['bar'];
 *
 * This could throw an OutOfRangeException, because at this point we already know the key 'bar' does not exist
 * within the array.
 *
 * http://php.net/manual/en/class.outofrangeexception.php
 */
class OutOfRangeException extends \OutOfRangeException implements ExceptionInterface
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
