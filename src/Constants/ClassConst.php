<?php declare(strict_types=1);

namespace Stellar\Constants;

use Stellar\Common\StringUtil;

final class ClassConst extends AbstractClassConst
{
    public static function split(string $classConst) : ?array
    {
        $result = null;
        if ($classConst) {
            $classConst = StringUtil::unprefix($classConst, '\\');
            if (\strlen($classConst) >= 4 && false !== \strpos($classConst, '::', 1)) {
                $result = \explode('::', $classConst, 2);
            }
        }

        return $result;
    }

    /**
     * ClassConst::instance('Namespace\To', 'SomeClass', 'CONST_NAME')
     * ClassConst::instance('Namespace\To\SomeClass', 'CONST_NAME')
     * ClassConst::instance('Namespace\To\SomeClass::CONST_NAME')
     * ClassConst::instance([ 'Namespace\To', 'SomeClass', 'CONST_NAME' ])
     * ClassConst::instance([ 'Namespace\To\SomeClass', 'CONST_NAME' ])
     * ClassConst::instance([ 'Namespace\To\SomeClass::CONST_NAME' ])
     *
     * from(string $namespace, string $class, string $name)
     * from(string $class, string $name)
     * from(string $const)
     * from(array $const)
     *
     * @return static|null
     */
    public static function instance(... $input) : ?self
    {
        if (1 === \count($input) && 1 === \count($input[0])) {
            return self::instance($input[0]);
        }

        $result = null;
        $count = \count($input);

        if ($count >= 2) {
            $name = \array_pop($input);
            $class = \implode('\\', $input);

            $result = new self($class, $name);
        }
        elseif (1 === $count) {
            $split = self::split(\array_pop($input));
            if ($split) {
                $result = new self($split[0], $split[1]);
            }
        }

        return $result;
    }

    protected function __construct(string $class, string $name)
    {
        $this->_class = $class;
        $this->_name = $name;
    }
}
