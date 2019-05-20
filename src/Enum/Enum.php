<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Constants\AbstractClassConst;
use Stellar\Container\ServiceRequest;
use Stellar\Container\Registry;
use Stellar\Enum\Exceptions\ConstructionFailure;
use Stellar\Enum\Traits\EnumFeatures;
use Stellar\Exceptions\Common\UndefinedClassConstant;
use Stellar\Exceptions\Common\UnknownStaticMethod;

// ScalarType::typeOf('bool') -> 'ScalarType::BOOL'
// ScalarType::nameOf(ScalarType::INT) -> 'INT'
// ScalarType::valueOf(ScalarType::DOUBLE) -> 'float'
// ScalarType::get(ScalarType::DOUBLE) -> new ScalarType(ScalarTypes::DOUBLE)
//
// SomeException::typeOf('exception msg') -> 'SomeException::TYPE'
// SomeException::nameOf(SomeException::TYPE) -> 'TYPE'
// SomeException::valueOf(SomeException::TYPE) -> 'exception msg'
// SomeException::get(SomeException::TYPE) -> new ExceptionType(SomeException::TYPE)

/**
 * @see \UnitTests\Enum\EnumTests
 */
abstract class Enum extends AbstractClassConst implements EnumInterface
{
    use EnumFeatures;

    private static function _instance(string $class, string $name)
    {
        // get a container instance for the enum class and request an instance for the enum const
        // the instance has to be created inside Enum because it's constructor is protected
        return Registry::container($class)->request($name, function () use ($class, $name) {
            $service = new $class($class, $name);

            return (new ServiceRequest($service))->asSingleton();
        });
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     * @throws UndefinedClassConstant
     * @throws UnknownStaticMethod
     */
    public static function __callStatic($name, $arguments)
    {
        // trigger the creation of an EnumerableType only when not called
        // on the Enum class, and when $name is all uppercase characters
        if (__CLASS__ !== static::class && \strtoupper($name) === $name) {
            if (static::enum()->hasName($name)) {
                return self::_instance(static::class, $name);
            }

            throw UndefinedClassConstant::factory(static::class, $name)->create();
        }

        throw UnknownStaticMethod::factory(static::class, $name)->create();
    }

    // Enum::instance('SomeEnum::TYPE'); -> new SomeEnum('SomeEnum', 'TYPE);
    // SomeEnum::instance('TYPE'); -> new SomeEnum('SomeEnum', 'TYPE);
    // SomeEnum::TYPE(); -> new SomeEnum('SomeEnum', 'TYPE);
    // SomeEnum::instance(SomeEnum::TYPE); -> new SomeEnum('SomeEnum', 'TYPE);
    final public static function instance($type)
    {
        if (__CLASS__ === static::class) {
            // only allow Enum to construct enum instances from enum subclasses
            if (\is_string($type) && false !== \strpos($type, '::')) {
                [ $class, $name ] = \explode('::', $type, 2);
                if (\class_exists($class) && \is_a($class, __CLASS__, true)) {
                    return self::_instance((string) $class, $name);
                }
            }

            throw ConstructionFailure::factory(static::class, $type)->create();
        }

        $enumerablesList = static::enum();

        // $type is the name of a constant within this enum subclass
        if ($enumerablesList->hasName($type)) {
            return self::_instance(static::class, $type);
        }
        // $type is the value of a constant within this enum subclass
        $name = $enumerablesList->nameOf($type);
        if (null !== $name) {
            return self::_instance(static::class, $name);
        }

        throw UndefinedClassConstant::factory(static::class, $type)->create();
    }

    final protected function __construct(string $class, string $name)
    {
        $this->_class = $class;
        $this->_name = $name;
        $this->_value = \call_user_func($class . '::valueOf', \constant($this->getConst()));
    }

    /** @inheritdoc */
    public function sameType(string $type) : bool
    {
        return $type === $this->getConst();
    }
}
