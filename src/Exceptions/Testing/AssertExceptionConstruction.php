<?php declare(strict_types=1);

namespace Stellar\Exceptions\Testing;

use Stellar\Exceptions\Error;
use Stellar\Exceptions\Exception;
use Stellar\Exceptions\ExceptionFactory;

trait AssertExceptionConstruction
{
    public static function assertExceptionConstruction(string $exceptionClass, array $params = [], ?array $args = null)
    {
        try {
            $factory = Exception::factory($exceptionClass, $params);
            self::assertInstanceOf(ExceptionFactory::class, $factory);

            $exception = $factory->create();
            if ($exception instanceof Error) {
                $exception = $exception->getPrevious();
            }

            self::assertInstanceOf($exceptionClass, $exception);
            self::assertSame($args ?? $params, \array_values($exception->getArguments()));
        }
        catch (\Throwable $e) {
            self::fail(\sprintf('Creation of exception `%s` failed: %s: %s%s',
                $exceptionClass,
                \get_class($e),
                $e->getMessage() . \PHP_EOL . \PHP_EOL,
                $e->getTraceAsString()
            ));
        }
    }
}
