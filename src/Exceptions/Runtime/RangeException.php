<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown to indicate range errors during program execution. Normally this means there was an arithmetic
 * error other than under/overflow. This is the runtime version of DomainException.
 *
 * @see http://php.net/manual/en/class.rangeexception.php
 */
abstract class RangeException extends \RangeException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
