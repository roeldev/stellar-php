<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\UnknownStaticMethod;
use Stellar\Exceptions\Traits\ExceptionFeatures;

// Voor algemene fouten, een exception throwen vanuit de Common map.
// Voor module/class specifieke fouten, een eigen exception throwen.

/**
 * @see \UnitTests\Exceptions\ExceptionTests
 */
class Exception extends \Exception implements ExceptionInterface
{
    use ExceptionFeatures;

    /**
     * @throws InvalidClass
     * @throws UnknownStaticMethod
     * @return ExceptionFactory
     */
    public static function factory(?string $exceptionClass = null, array $params = []) : ExceptionFactory
    {
        if (null === $exceptionClass || self::class === $exceptionClass) {
            return ExceptionFactory::init(self::class);
        }

        // make sure the class implements the ExceptionInterface interface
        if (!\is_a($exceptionClass, ExceptionInterface::class, true)) {
            throw InvalidClass::factory(ExceptionInterface::class, $exceptionClass)->create();
        }

        // make sure the class has a static factory method
        if (!\method_exists($exceptionClass, 'factory')) {
            throw UnknownStaticMethod::factory($exceptionClass, 'factory')->create();
        }

        return \call_user_func_array([ $exceptionClass, 'factory' ], $params);
    }

    /**
     * @param string          $message   Type of the exception
     * @param int             $code      Code to easy identify the exception's location
     * @param \Throwable|null $previous  An optional previous Exception that triggered this one
     * @param Severity|null   $severity  Defaults to Severity::NOTICE
     * @param array           $arguments Extra arguments to further illustrate the context
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?\Throwable $previous = null,
        ?Severity $severity = null,
        array $arguments = []
    ) {
        parent::__construct($message, $code, $previous);

        $this->_updateFromTrace();
        $this->setSeverity($severity ?: Severity::NOTICE());
        $this->setArguments($arguments);
    }
}
