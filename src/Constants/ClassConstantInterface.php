<?php declare(strict_types=1);

namespace Stellar\Constants;

interface ClassConstantInterface
{
    /**
     * Get the full name of the class of which the constant belongs to.
     */
    public function getClass() : string;

    /**
     * Get only the name of the constant as it's defined in the class.
     */
    public function getName() : string;

    /**
     * Get the name prefixed with the full class name of the constant.
     */
    public function getConst() : string;

    /**
     * Get the value of the constant.
     *
     * @return mixed
     */
    public function getValue();
}
