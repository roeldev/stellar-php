<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if an error which can only be found on runtime occurs.
 *
 * @see http://php.net/manual/en/class.runtimeexception.php
 */
abstract class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
