<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Common\Traits\ToString;

/**
 * "`Error` should be used to represent coding issues that require the attention of a programmer. `Exception` should be
 * used for conditions that can be safely handled at runtime where another action can be taken and execution can
 * continue."
 *
 * @link https://trowski.com/2015/06/24/throwable-exceptions-and-errors-in-php7/
 * @method Exception getPrevious()
 * @see \UnitTests\Exceptions\ErrorTests
 */
final class Error extends \Error implements ThrowableInterface
{
    use ToString;

    /**
     * The Exception that's upgraded to an error
     *
     * @var ExceptionInterface
     */
    protected $_exception;

    /**
     * Construct a new Error from an existing Exception that implements ExceptionInterface.
     */
    public function __construct(ExceptionInterface $exception)
    {
        $this->_exception = $exception;

        parent::__construct($exception->getMessage(), $exception->getCode(), $exception);
    }

    /**
     * Get the Severity of the Exception that triggered the Error.
     */
    public function getSeverity() : Severity
    {
        return $this->_exception->getSeverity();
    }

    /**
     * Get the arguments passed to the Exception that triggered the Error.
     */
    public function getArguments() : array
    {
        return $this->_exception->getArguments();
    }

    /**
     * Transform the Exception that triggered the Error to an array.
     */
    public function toArray() : array
    {
        $result = $this->_exception->toArray();
        $result['error'] = true;

        return $result;
    }

    /**
     * Get a string representation of the Exception that triggered the Error.
     */
    public function __toString() : string
    {
        return 'Error: ' . $this->_exception->__toString();
    }
}
