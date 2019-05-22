<?php declare(strict_types=1);

namespace Stellar\Exceptions;

use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Common\StringUtil;
use Stellar\Common\Type;

/**
 * @see:unit-test \UnitTests\Exceptions\ExceptionFactoryTests
 */
final class ExceptionFactory
{
    public static function init(string $exceptionClass) : self
    {
        if (!\is_a($exceptionClass, ThrowableInterface::class, true)) {
            throw InvalidClass::factory(ThrowableInterface::class, $exceptionClass)->create();
        }

        return new self($exceptionClass);
    }

    /**
     * Class name of the exception to construct.
     *
     * @var string
     */
    private $_class;

    /**
     * @var string[]
     */
    private $_message = [];

    /**
     * Arguments to replace in the message format template.
     *
     * @var array
     */
    private $_arguments = [];

    /**
     * Optional code to identify the exception.
     *
     * @var int
     */
    private $_code = 0;

    /**
     * Severity level object.
     *
     * @var Severity
     */
    private $_severity;

    /**
     * Previous Exception that triggered this exception.
     *
     * @var \Throwable|null
     */
    private $_previous;

    private function __construct(string $class)
    {
        $this->_class = $class;
    }

    public function withMessage(string $message, $replace = false) : self
    {
        if ($replace) {
            $this->_message = [];
        }

        $this->_message[] = StringUtil::unsuffix($message, '.');

        return $this;
    }

    /**
     * @param array<string,mixed> $arguments
     */
    public function withArguments(array $arguments) : self
    {
        $this->_arguments = $arguments;

        return $this;
    }

    public function withArgument(string $name, $value) : self
    {
        $this->_arguments[ $name ] = $value;

        return $this;
    }

    public function withCode(int $code) : self
    {
        $this->_code = $code;

        return $this;
    }

    public function withSeverity(Severity $severity) : self
    {
        $this->_severity = $severity;

        return $this;
    }

    public function withPrevious(?\Throwable $previous) : self
    {
        $this->_previous = $previous;

        return $this;
    }

    public function getMessage() : string
    {
        $result = '';
        if (!empty($this->_message)) {
            $arguments = $this->_arguments;
            foreach ($arguments as $i => $value) {
                if (!\is_string($value)) {
                    $arguments[ $i ] = Type::details($value);
                }
            }

            $arguments = \array_merge($arguments, [
                'exception.class' => $this->_class,
                'exception.code'  => $this->_code,
                'severity'        => $this->getSeverity()->getName(),
            ]);

            $message = implode('. ', $this->_message);
            $result = StringUtil::replaceVars($message, $arguments);
        }

        return $result;
    }

    public function getSeverity() : Severity
    {
        if (!$this->_severity) {
            $this->_severity = \is_a($this->_class, \LogicException::class, true)
                ? Severity::WARNING()
                : Severity::NOTICE();
        }

        return $this->_severity;
    }

    public function create(?bool $upgradeToError = null) : ThrowableInterface
    {
        $severity = $this->getSeverity();

        $exception = new $this->_class($this->getMessage(), $this->_code, $this->_previous);
        if ($exception instanceof ExceptionInterface) {
            $exception->setSeverity($severity);
            $exception->setArguments($this->_arguments);
        }

        if (null === $upgradeToError) {
            $upgradeToError = ($severity->getValue() > Severity::WARNING);
        }

        return $upgradeToError ? new Error($exception) : $exception;
    }
}
