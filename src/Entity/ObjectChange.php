<?php

namespace PhpObjectHistory\Entity;

class ObjectChange
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var mixed
     */
    private $oldValue;

    /**
     * @var mixed
     */
    private $newValue;

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     * @return ObjectChange
     */
    public function setAttribute(string $attribute): ObjectChange
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @param mixed $oldValue
     * @return ObjectChange
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @param mixed $newValue
     * @return ObjectChange
     */
    public function setNewValue($newValue)
    {
        $this->newValue = $newValue;
        return $this;
    }
}