<?php declare(strict_types=1);

namespace Stellar\Exceptions\Testing;

use Stellar\Exceptions\Contracts\ExceptionInterface;
use Stellar\Exceptions\Error;

// todo: ombouwen adhv. constraint class

/**
 * PHPUnit assertion for exceptions.
 */
trait AssertException
{
    /** @var array */
    protected $_expectExceptionArguments;

    /** @var string */
    protected $_expectExceptionUpgradedToError;

    protected function _assertException(ExceptionInterface $exception) : void
    {
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
        $this->_expectExceptionArguments = null;
        $this->_expectExceptionUpgradedToError = null;
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
            var_dump([ get_class($exception), $exception->getMessage() ]);
        }
    }
}
