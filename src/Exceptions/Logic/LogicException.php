<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception that represents error in the program logic. This kind of exception should lead directly to a fix in your
 * code.
 *
 * @see http://php.net/manual/en/class.logicexception.php
 */
abstract class LogicException extends \LogicException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
