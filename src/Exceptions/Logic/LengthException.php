<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if a length is invalid.
 *
 * @see http://php.net/manual/en/class.lengthexception.php
 */
abstract class LengthException extends \LengthException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
