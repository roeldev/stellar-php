<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Support\ExceptionFeatures;

/**
 * Exception thrown when adding an element to a full container.
 *
 * @see http://php.net/manual/en/class.overflowexception.php
 */
abstract class OverflowException extends \OverflowException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
