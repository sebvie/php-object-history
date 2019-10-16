<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;
use ReflectionObject;

class ObjectComparer implements ComparatorInterface
{

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

        $oldProperties = $this->getProperties($oldValue);
        $newProperties = $this->getProperties($newValue);

        return $this->compareProperties($oldProperties, $newProperties);
    }

    /**
     * @param object $object
     * @return array
     * @throws \ReflectionException
     */
    protected function getProperties(object $object): array
    {
        $result = [];
        $reflectionClass = new ReflectionObject($object);
        $properties = $reflectionClass->getProperties();

        if (empty($properties)) {
            return $result;
        }

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $result[$property->getName()] = $property->getValue($object);
        }

        return $result;
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