<?php

namespace PhpObjectHistory\Tests\Fixture;

class ToStringClassFixture
{
    /**
     * @var mixed
     */
    private $privateProperty = 1;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->privateProperty;
    }

    /**
     * @return mixed
     */
    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }

    /**
     * @param mixed $privateProperty
     * @return ToStringClassFixture
     */
    public function setPrivateProperty($privateProperty)
    {
        $this->privateProperty = $privateProperty;
        return $this;
    }
}