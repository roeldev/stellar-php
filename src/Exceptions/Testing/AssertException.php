<?php declare(strict_types=1);

namespace Stellar\Exceptions\Testing;

use Stellar\Exceptions\Error;
use Stellar\Exceptions\ExceptionInterface;
use Stellar\Exceptions\ExceptionType;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Testing\Constraints\SameExceptionType;
use Stellar\Exceptions\Testing\Constraints\SameSeverity;

// todo: ombouwen adhv. constraint class

/**
 * PHPUnit assertion for exceptions.
 */
trait AssertException
{
    /** @var Severity */
    protected $_expectExceptionSeverity;

    /** @var array */
    protected $_expectExceptionArguments;

    /** @var string */
    protected $_expectExceptionUpgradedToError;

    protected function _assertException(ExceptionInterface $exception) : void
    {
        if ($this->_expectExceptionSeverity) {
            static::assertThat($exception->getSeverity(), new SameSeverity($this->_expectExceptionSeverity));
        }

        if ($this->_expectExceptionArguments) {
            self::assertEquals(
                $this->_expectExceptionArguments,
                $exception->getArguments(),
                'Arguments do not match'
            );
        }
    }

    public function resetExpectingException() : void
    {
        $this->_expectExceptionSeverity = null;
        $this->_expectExceptionArguments = null;
        $this->_expectExceptionUpgradedToError = null;
    }

    public function expectExceptionSeverity(Severity $severity) : void
    {
        $this->_expectExceptionSeverity = $severity;
    }

    public function expectExceptionArguments(array $arguments) : void
    {
        $this->_expectExceptionArguments = $arguments;
    }

    public function expectExceptionUpgradedToError(string $exceptionClass) : void
    {
        $this->expectException(Error::class);
        $this->_expectExceptionUpgradedToError = $exceptionClass;
    }

    public function assertException(\Closure $testFn) : void
    {
        try {
            $testFn($this);
        }
        catch (ExceptionInterface $exception) {
            $this->_assertException($exception);
            throw $exception;
        }
        catch (Error $exception) {
            if ($this->_expectExceptionUpgradedToError) {
                $previous = $exception->getPrevious();
                self::assertInstanceOf($this->_expectExceptionUpgradedToError, $previous, \sprintf(
                    'Upgraded exception `%s` does not match `%s`',
                    $this->_expectExceptionUpgradedToError,
                    \get_class($previous)
                ));
            }

            $this->_assertException($exception->getPrevious());
            throw $exception;
        }
        catch (\Throwable $exception) {
            var_dump($exception);
        }
    }
}
