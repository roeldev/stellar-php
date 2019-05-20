<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if a value does not match with a set of values. Typically this happens when a function calls
 * another function and expects the return value to be of a certain type or value not including arithmetic or
 * buffer related errors.
 *
 * @see http://php.net/manual/en/class.unexpectedvalueexception.php
 */
abstract class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
