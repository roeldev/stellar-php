<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\Traits\ExceptionFeatures;

/**
 * Exception thrown if a value is not a valid key. This represents errors that cannot be detected at compile time.
 *
 * Example:
 * $container->get('some-service');
 *
 * This could throw an OutOfBoundsException when 'some-service' is not set in a container.
 *
 * @see http://php.net/manual/en/class.outofboundsexception.php
 */
abstract class OutOfBoundsException extends \OutOfBoundsException implements ExceptionInterface
{
    use ExceptionFeatures;

    /** {@inheritdoc} */
    public function __construct(... $args)
    {
        parent::__construct(... $args);
        $this->_updateFromTrace();
    }
}
