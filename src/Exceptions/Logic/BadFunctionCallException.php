<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if a callback refers to an undefined function or if some arguments are missing.
 *
 * @see http://php.net/manual/en/class.badfunctioncallexception.php
 */
abstract class BadFunctionCallException extends \BadFunctionCallException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
