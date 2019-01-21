<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Support\ExceptionFeatures;

/**
 * Exception thrown if an argument is not of the expected type.
 *
 * @see http://php.net/manual/en/class.invalidargumentexception.php
 */
abstract class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
