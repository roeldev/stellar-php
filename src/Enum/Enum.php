<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Common\Abilities\StringableTrait;
use Stellar\Container\Registry;
use Stellar\Container\ServiceRequest;
use Stellar\Enum\Abilities\EnumFeatures;
use Stellar\Exceptions\Common\InvalidClass;
use Stellar\Exceptions\Common\UndefinedConstant;
use Stellar\Exceptions\Common\UnknownStaticMethod;

/**
 * @see:unit-test \UnitTests\Enum\EnumTests
 */
abstract class Enum implements EnumInterface
{
    use EnumFeatures;
    use StringableTrait;

    private static function _requestService($class, $name) : ServiceRequest
    {
        return ServiceRequest::with(new $class($class, $name))
            ->asSingleton();
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     * @throws InvalidClass
     * @throws UndefinedConstant
     * @throws UnknownStaticMethod
     */
    public static function __callStatic($name, $arguments)
    {
        $class = static::class;
        if (__CLASS__ === $class || \strtoupper($name) !== $name) {
            throw new UnknownStaticMethod($class, $name);
        }
        if (!static::enum()->hasName($name)) {
            throw new UndefinedConstant($name, $class);
        }

        // the instance has to be created inside Enum because it's constructor is protected
        return Registry::container($class)->request(
            $name,
            \Closure::fromCallable([ static::class, '_requestService' ]),
            [ $class, $name ]
        );
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
