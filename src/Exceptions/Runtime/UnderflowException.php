<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Support\ExceptionFeatures;

/**
 * Exception thrown when performing an invalid operation on an empty container, such as removing an element.
 *
 * @see http://php.net/manual/en/class.underflowexception.php
 */
abstract class UnderflowException extends \UnderflowException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
