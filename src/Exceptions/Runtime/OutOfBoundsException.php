<?php declare(strict_types=1);

namespace Stellar\Exceptions\Runtime;

use Stellar\Exceptions\Abilities\ExtendExceptionTrait;
use Stellar\Exceptions\Contracts\ExceptionInterface;
use Throwable;

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
class OutOfBoundsException extends \OutOfBoundsException implements ExceptionInterface
{
    use ExtendExceptionTrait;

    /**
     * @see \Stellar\Exceptions\Exception::__construct()
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null,
        array $arguments = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->_withArguments($arguments);
    }
}
