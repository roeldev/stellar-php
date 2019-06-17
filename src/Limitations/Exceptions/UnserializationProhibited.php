<?php declare(strict_types=1);

namespace Stellar\Limitations\Exceptions;

use Stellar\Exceptions\Logic\BadMethodCallException;
use Throwable;

/**
 * Use when a call to `unserialize()` or `__wakeup()` is not allowed.
 */
final class UnserializationProhibited extends BadMethodCallException implements LimitationException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct('Unserializing of `{class}` is not allowed', 0, $previous, \compact('class'));
    }
}
