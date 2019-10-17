<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Formatter\ObjectFormatterHandlerInterface;

class ObjectComparer implements ComparatorInterface
{

    /**
     * @var ObjectFormatterHandlerInterface
     */
    protected $objectFormatterHandler;


    /**
     * @param ObjectFormatterHandlerInterface $objectFormatterHandler
     * @return ObjectComparer
     */
    public function setObjectFormatterHandler(ObjectFormatterHandlerInterface $objectFormatterHandler): ObjectComparer
    {
        $this->objectFormatterHandler = $objectFormatterHandler;
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
        return $result;
    }
}