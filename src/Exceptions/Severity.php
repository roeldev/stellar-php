<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Enum\Enum;

/**
 * @method static Severity NOTICE()
 * @method static Severity WARNING()
 * @method static Severity ERROR()
 * @method static Severity CRITICAL()
 */
final class Severity extends Enum
{
    /**
     * Interesting events that might indicate a problem.
     *
     * @var int
     */
    public const NOTICE = 0;

    /**
     * Exceptional occurrences that are not errors. For best practice it's recommended to fix these
     * problems.
     *
     * @var int
     */
    public const WARNING = 1;

    /**
     * Runtime errors a programmer definitely should fix.
     *
     * @var int
     */
    public const ERROR = 2;

    /**
     * Critical condition, execution cannot continue until fixed.
     *
     * @var int
     */
    public const CRITICAL = 3;
}
