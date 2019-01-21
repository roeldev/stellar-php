<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Support\ExceptionFeatures;

/**
 * Exception thrown if a callback refers to an undefined method or if some arguments are missing.
 *
 * @see http://php.net/manual/en/class.badmethodcallexception.php
 */
abstract class BadMethodCallException extends \BadMethodCallException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
