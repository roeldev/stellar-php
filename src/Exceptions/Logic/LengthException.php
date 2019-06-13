<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * Exception thrown if a length is invalid.
 *
 * @see http://php.net/manual/en/class.lengthexception.php
 */
class LengthException extends \LengthException implements ExceptionInterface
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
