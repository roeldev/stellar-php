<?php declare(strict_types=1);

namespace Stellar\Exceptions\Logic;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if a value does not adhere to a defined valid data domain.
 *
 * @see http://php.net/manual/en/class.domainexception.php
 */
abstract class DomainException extends \DomainException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
