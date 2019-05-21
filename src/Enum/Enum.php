<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Common\Traits\ToString;
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
abstract class Enum implements EnumInterface
{
    use EnumFeatures;
    use ToString;

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
                return Factory::instance()->createEnum(static::class, $name);
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
        $factory = Factory::instance();

        if (__CLASS__ === static::class) {
            // only allow Enum to construct enum instances from enum subclasses
            if (\is_string($type) && false !== \strpos($type, '::')) {
                [ $class, $name ] = \explode('::', $type, 2);
                if (\class_exists($class) && \is_a($class, __CLASS__, true)) {
                    return $factory->createEnum((string) $class, $name);
                }
            }

            throw ConstructionFailure::factory(static::class, $type)->create();
        }

        $enumerablesList = static::enum();

        // $type is the name of a constant within this enum subclass
        if ($enumerablesList->hasName($type)) {
            return $factory->createEnum(static::class, $type);
        }
        // $type is the value of a constant within this enum subclass
        $name = $enumerablesList->nameOf($type);
        if (null !== $name) {
            return $factory->createEnum(static::class, $name);
        }

        throw UndefinedClassConstant::factory(static::class, $type)->create();
    }

    final protected function __construct(string $class, string $name)
    {
        $this->_class = $class;
        $this->_name = $name;
        $this->_value = \call_user_func($class . '::valueOf', \constant($this->getConst()));
    }

    /**
     * Full name of the class of which the const belongs to.
     *
     * @var string
     */
    protected $_class;

    /**
     * Name of the const.
     *
     * @var string
     */
    protected $_name;

    /**
     * Value of the const.
     *
     * @var mixed
     */
    protected $_value;

    /** {@inheritdoc} */
    public function getClass() : string
    {
        return $this->_class;
    }

    /** {@inheritdoc} */
    public function getName() : string
    {
        return $this->_name;
    }

    /** {@inheritdoc} */
    public function getConst() : string
    {
        return $this->_class . '::' . $this->_name;
    }

    /** {@inheritdoc} */
    public function getValue()
    {
        if (null === $this->_value) {
            $this->_value = \constant($this->getConst());
        }

        return $this->_value;
    }

    /** @inheritdoc */
    public function sameType(string $type) : bool
    {
        return $type === $this->getConst();
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getConst();
    }
}
