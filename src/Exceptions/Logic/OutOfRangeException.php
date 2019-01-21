<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Support\ExceptionFeatures;

/**
 * Exception thrown when an illegal index was requested. This represents errors that should be detected at compile time.
 *
 * Example:
 * $arr = ['foo' => 'covfefe'];
 * $arr['bar'];
 *
 * This could throw an OutOfRangeException, because at this point we already know the key 'bar' does not exist
 * within the array.
 *
 * http://php.net/manual/en/class.outofrangeexception.php
 */
abstract class OutOfRangeException extends \OutOfRangeException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
