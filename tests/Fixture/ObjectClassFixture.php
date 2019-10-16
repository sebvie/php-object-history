<?php

namespace PhpObjectHistory\Tests\Fixture;

use DateTime;

class ObjectClassFixture
{
    /**
     * @var mixed
     */
    private $privateProperty = 1;

    /**
     * @var mixed
     */
    protected $protectedProperty = 1;

    /**
     * @var mixed
     */
    public $publicProperty = 1;

    /**
     * @var array
     */
    private $arrayProperty = [
        1,
        "2",
        3
    ];

    /**
     * @var object
     */
    private $objectProperty;

    /**
     * @var string
     */
    private $stringProperty = 'string';

    /**
     * @var null
     */
    private $nullProperty = null;

    /**
     * @var bool
     */
    private $boolProperty = true;

    /**
     * @var int
     */
    private $intProperty = -1;

    /**
     * @var float
     */
    private $floatProperty = -1.1;

    /**
     * @return mixed
     */
    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }

    /**
     * @param mixed $privateProperty
     * @return ObjectClassFixture
     */
    public function setPrivateProperty($privateProperty)
    {
        $this->privateProperty = $privateProperty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProtectedProperty()
    {
        return $this->protectedProperty;
    }

    /**
     * @param mixed $protectedProperty
     * @return ObjectClassFixture
     */
    public function setProtectedProperty($protectedProperty)
    {
        $this->protectedProperty = $protectedProperty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicProperty()
    {
        return $this->publicProperty;
    }

    /**
     * @param mixed $publicProperty
     * @return ObjectClassFixture
     */
    public function setPublicProperty($publicProperty)
    {
        $this->publicProperty = $publicProperty;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrayProperty(): array
    {
        return $this->arrayProperty;
    }

    /**
     * @param array $arrayProperty
     * @return ObjectClassFixture
     */
    public function setArrayProperty(array $arrayProperty): ObjectClassFixture
    {
        $this->arrayProperty = $arrayProperty;
        return $this;
    }

    /**
     * @return object
     */
    public function getObjectProperty(): object
    {
        return $this->objectProperty;
    }

    /**
     * @param object $objectProperty
     * @return ObjectClassFixture
     */
    public function setObjectProperty(object $objectProperty): ObjectClassFixture
    {
        $this->objectProperty = $objectProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringProperty(): string
    {
        return $this->stringProperty;
    }

    /**
     * @param string $stringProperty
     * @return ObjectClassFixture
     */
    public function setStringProperty(string $stringProperty): ObjectClassFixture
    {
        $this->stringProperty = $stringProperty;
        return $this;
    }

    /**
     * @return null
     */
    public function getNullProperty()
    {
        return $this->nullProperty;
    }

    /**
     * @param null $nullProperty
     * @return ObjectClassFixture
     */
    public function setNullProperty($nullProperty)
    {
        $this->nullProperty = $nullProperty;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntProperty(): int
    {
        return $this->intProperty;
    }

    /**
     * @param int $intProperty
     * @return ObjectClassFixture
     */
    public function setIntProperty(int $intProperty): ObjectClassFixture
    {
        $this->intProperty = $intProperty;
        return $this;
    }

    /**
     * @return float
     */
    public function getFloatProperty(): float
    {
        return $this->floatProperty;
    }

    /**
     * @param float $floatProperty
     * @return ObjectClassFixture
     */
    public function setFloatProperty(float $floatProperty): ObjectClassFixture
    {
        $this->floatProperty = $floatProperty;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBoolProperty(): bool
    {
        return $this->boolProperty;
    }

    /**
     * @param bool $boolProperty
     * @return ObjectClassFixture
     */
    public function setBoolProperty(bool $boolProperty): ObjectClassFixture
    {
        $this->boolProperty = $boolProperty;
        return $this;
    }
}