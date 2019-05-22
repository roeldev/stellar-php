<?php declare(strict_types=1);

namespace Stellar\Enum;

use Stellar\Constants\ClassConstList;
use Stellar\Container\Exceptions\BuildFailure;
use Stellar\Container\ServiceRequest;
use Stellar\Container\Registry;
use Stellar\Enum\Exceptions\MissingConstants;
use Stellar\Limitations\ProhibitCloning;
use Stellar\Limitations\ProhibitUnserialization;
use Stellar\Limitations\ProhibitWakeup;

/**
 * @see:unit-test \UnitTests\Enum\EnumerablesListTests
 */
final class EnumerablesList extends ClassConstList
{
    use ProhibitCloning;
    use ProhibitUnserialization;
    use ProhibitWakeup;

    /**
     * @throws BuildFailure
     */
    public static function instance(string $ownerClass, array $customValues = []) : self
    {
        return Registry::container(self::class)
            ->request($ownerClass, function () use ($ownerClass, $customValues) {
                return ServiceRequest::with(static::class, [ $ownerClass, $customValues ])
                    ->asSingleton();
            });
    }

    private $_identifiers = [];

    /**
     * An array with the indexes/identifiers and names of all defined constants.
     *
     * @var array
     */
    // private $_names = [];

    /**
     * An array with the indexes/identifiers and (custom) values of all defined constants.
     *
     * @var array
     */
    // private $_values = [];

    /**
     * @var bool
     */
    private $_hasCustomValues;

    /**
     * @throws MissingConstants
     */
    public function __construct(string $ownerClass, array $customValues = [])
    {
        parent::__construct($ownerClass);

        if (!$this->_list) {
            throw MissingConstants::factory($ownerClass)->create();
        }

        $this->_hasCustomValues = !empty($customValues);
        if ($this->_hasCustomValues) {
            foreach ($this->_list as $name => $identifier) {
                if (\array_key_exists($identifier, $customValues)) {
                    $this->_list[ $name ] = $customValues[ $identifier ];
                    $this->_identifiers[ $name ] = $identifier;
                }
            }
        }
    }

    public function isIdentifier($value) : bool
    {
        return ($this->_hasCustomValues && \in_array($value, $this->_identifiers, true));
    }

    // ScalarType::nameOf(ScalarType::INT) -> 'INT'
    // SomeException::nameOf(SomeException::TYPE) -> 'TYPE'
    public function nameOf($value) : ?string
    {
        if ($this->_hasCustomValues) {
            return \array_search($value, $this->_identifiers, true) ?: null;
        }

        return parent::nameOf($value);
    }

    // ScalarType::valueOf(ScalarType::DOUBLE) -> 'float'
    // SomeException::valueOf(SomeException::TYPE) -> 'exception msg'
    public function valueOf($var)
    {
        $result = null;
        if ($this->_hasCustomValues) {
            $result = ($this->_values[ $var ] ?? null);
        }
        elseif ($this->hasValue($var)) {
            $result = $var;
        }

        return $result;
    }
}
