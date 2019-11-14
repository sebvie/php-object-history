<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Formatter\ObjectFormatterHandler;
use PhpObjectHistory\Formatter\ObjectFormatterHandlerInterface;

class ObjectComparer implements ComparatorInterface
{
    /**
     * @var array
     */
    protected $ignoreAttributes = [];

    /**
     * @var ObjectFormatterHandlerInterface
     */
    protected $objectFormatterHandler;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->objectFormatterHandler = new ObjectFormatterHandler();
    }

    /**
     * @param ObjectFormatterHandlerInterface $objectFormatterHandler
     * @return ObjectComparer
     */
    public function setObjectFormatterHandler(ObjectFormatterHandlerInterface $objectFormatterHandler): ComparatorInterface
    {
        $this->objectFormatterHandler = $objectFormatterHandler;
        return $this;
    }

    /**
     * @return ObjectFormatterHandlerInterface
     */
    public function getObjectFormatterHandler(): ObjectFormatterHandlerInterface
    {
        return $this->objectFormatterHandler;
    }

    /**
     * @return array
     */
    public function getIgnoreAttributes(): array
    {
        return $this->ignoreAttributes;
    }

    /**
     * @param array $ignoreAttributes
     * @return ObjectComparer
     */
    public function setIgnoreAttributes(array $ignoreAttributes): ComparatorInterface
    {
        $this->ignoreAttributes = $ignoreAttributes;
        return $this;
    }

    /**
     * @param object $oldValue
     * @param object $newValue
     *
     * @return ObjectChange[]
     */
    public function getDiff($oldValue, $newValue): array
    {
        if (!is_object($oldValue)) {
            throw new \InvalidArgumentException('old value should be an object');
        }
        if (!is_object($newValue)) {
            throw new \InvalidArgumentException('new value should be an object');
        }

        $oldProperties = $this->objectFormatterHandler->convertObjectToArray($oldValue);
        $newProperties = $this->objectFormatterHandler->convertObjectToArray($newValue);

        return $this->compareProperties($oldProperties, $newProperties);
    }

    /**
     * @param array $oldProperties
     * @param array $newProperties
     * @return ObjectChange[]
     */
    protected function compareProperties(array $oldProperties, array $newProperties): array
    {
        $result = [];

        foreach ($oldProperties as $oldPropertyName => $oldPropertyValue) {
            if (!array_key_exists($oldPropertyName,$newProperties)) {

                $objectChange = new ObjectChange();
                $objectChange->setAttribute($oldPropertyName);
                $objectChange->setOldValue($oldPropertyValue);
                $objectChange->setNewValue(null);

                $result[] = $objectChange;
            } else {
                $newPropertyValue = $newProperties[$oldPropertyName];
                if ($oldPropertyValue !== $newPropertyValue) {
                    $objectChange = new ObjectChange();
                    $objectChange->setAttribute($oldPropertyName);
                    $objectChange->setOldValue($oldPropertyValue);
                    $objectChange->setNewValue($newPropertyValue);
                    $result[] = $objectChange;
                }
            }
        }


        $addedProperties = array_diff_key($newProperties, $oldProperties);
        if (!empty($addedProperties)) {
            foreach ($addedProperties as $addedPropertyName => $addedPropertyValue) {
                $objectChange = new ObjectChange();
                $objectChange->setAttribute($addedPropertyName);
                $objectChange->setOldValue(null);
                $objectChange->setNewValue($addedPropertyValue);

                $result[] = $objectChange;
            }
        }
        $result = $this->removeIgnoredAttributes($result);

        return $result;
    }

    /**
     * @param ObjectChange[] $objectChanges
     * @return ObjectChange[]
     */
    protected function removeIgnoredAttributes(array $objectChanges): array
    {
        if (empty($this->ignoreAttributes)) {
            return $objectChanges;
        }

        foreach ($objectChanges as $key => $objectChange) {
            foreach ($this->ignoreAttributes as $ignoreAttribute) {
                if ($objectChange->getAttribute() === $ignoreAttribute) {
                    unset($objectChanges[$key]);
                }
            }
        }

        return $objectChanges;
    }
}