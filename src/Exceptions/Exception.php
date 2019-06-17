<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

/**
 * @see:unit-test \UnitTests\Exceptions\ExceptionTests
 */
class Exception extends \Exception implements ExceptionInterface
{
    use ExtendExceptionTrait;

    /**
     * @param string     $message   The exception message to throw
     * @param int        $code      Code to further identify the exception
     * @param ?Throwable $previous  An optional previous Exception that triggered this one
     * @param array      $arguments Extra arguments to illustrate context
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
