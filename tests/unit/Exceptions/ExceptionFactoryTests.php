<?php declare(strict_types=1);

namespace UnitTests\Exceptions;

use PHPUnit\Framework\TestCase;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Error;
use Stellar\Exceptions\ExceptionFactory;
use Stellar\Exceptions\Severity;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Exceptions\ExceptionFactory
 */
class ExceptionFactoryTests extends TestCase
{
    use AssertException;

    /**
     * @covers ::init()
     */
    public function test_fail_when_init_with_incompatible_exception_class()
    {
        $this->expectException(InvalidClass::class);
        $this->assertException(function () {
            ExceptionFactory::init(\BadMethodCallException::class);
        });
    }

    /**
     * @covers ::init()
     */
    public function test_fail_when_init_with_non_existing_class()
    {
        $this->expectException(InvalidClass::class);
        $this->assertException(function () {
            ExceptionFactory::init('\This\Doesnt\Exist');
        });
    }

    /**
     * @covers ::init()
     * @covers ::create()
     * @covers ::getSeverity()
     */
    public function test_exception_is_created_with_warning_severity()
    {
        $factory = ExceptionFactory::init(FooExceptionFixture::class);
        $exception = $factory->create();

        $this->assertInstanceOf(ExceptionFactory::class, $factory);
        $this->assertInstanceOf(FooExceptionFixture::class, $exception);
        $this->assertSame($factory->getSeverity(), Severity::WARNING());
        $this->assertSame($factory->getSeverity(), $exception->getSeverity());
    }

    /**Ø
     * @covers ::init()
     * @covers ::create()
     * @covers ::getSeverity()
     */
    public function test_exception_is_created_with_notice_severity()
    {
        $factory = ExceptionFactory::init(BarExceptionFixture::class);
        $exception = $factory->create();

        $this->assertInstanceOf(ExceptionFactory::class, $factory);
        $this->assertInstanceOf(BarExceptionFixture::class, $exception);
        $this->assertSame($factory->getSeverity(), Severity::NOTICE());
        $this->assertSame($factory->getSeverity(), $exception->getSeverity());
    }

    /**
     * @covers ::create()
     */
    public function test_exception_is_created_and_upgraded_to_error()
    {
        $error = ExceptionFactory::init(BarExceptionFixture::class)->create(true);

        $this->assertInstanceOf(Error::class, $error);
        $this->assertInstanceOf(BarExceptionFixture::class, $error->getPrevious());
    }

    /**
     * @covers ::withSeverity()
     * @covers ::create()
     * @covers ::getSeverity()
     */
    public function test_error_is_created_from_the_severity_level()
    {
        $severity = Severity::CRITICAL();
        $factory = ExceptionFactory::init(BazExceptionFixture::class);
        $factory->withSeverity($severity);

        $error = $factory->create();

        $this->assertInstanceOf(Error::class, $error);
        $this->assertInstanceOf(BazExceptionFixture::class, $error->getPrevious());
        $this->assertSame($severity, $factory->getSeverity());
        $this->assertSame($severity, $error->getSeverity());
    }

    /**
     * @covers ::withMessage()
     * @covers ::create()
     * @covers ::getMessage()
     */
    public function test_message()
    {
        $input = 'hi there';

        $factory = ExceptionFactory::init(BarExceptionFixture::class);
        $factory->withMessage($input);

        $exception = $factory->create();

        $this->assertSame($input, $factory->getMessage());
        $this->assertSame($input, $exception->getMessage());
    }

    /**
     * @covers ::withArguments()
     * @covers ::create()
     */
    public function test_arguments()
    {
        $arguments = [ '' => \random_int(1, 999) ];

        $exception = ExceptionFactory::init(FooExceptionFixture::class)
            ->withArguments($arguments)
            ->create();

        $this->assertSame($arguments, $exception->getArguments());
    }

    /**
     * @covers ::withCode()
     * @covers ::create()
     */
    public function test_code()
    {
        $code = \random_int(1, 999);

        $exception = ExceptionFactory::init(BarExceptionFixture::class)
            ->withCode($code)
            ->create();

        $this->assertSame($code, $exception->getCode());
    }

    /**
     * @covers ::withSeverity()
     * @covers ::create()
     */
    public function test_severity()
    {
        $severity = Severity::WARNING();

        $exception = ExceptionFactory::init(BazExceptionFixture::class)
            ->withSeverity($severity)
            ->create();

        $this->assertEquals($severity, $exception->getSeverity());
    }

    /**
     * @covers ::withPrevious()
     * @covers ::create()
     */
    public function test_previous()
    {
        $previous = new \Exception('just some previous exception');

        $exception = ExceptionFactory::init(FooExceptionFixture::class)
            ->withPrevious($previous)
            ->create();

        $this->assertEquals($previous, $exception->getPrevious());
    }
}
