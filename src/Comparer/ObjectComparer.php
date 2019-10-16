<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;

class ObjectComparer implements ComparatorInterface
{

    /**
     * @param object $oldValue
     * @param object $newValue
     * @return ObjectChange[]
     */
    public function getDiff($oldValue, $newValue): array
    {
        $result = [];
        if (!is_object($oldValue)) {
            throw new \InvalidArgumentException('old value should be an object');
        }
        if (!is_object($newValue)) {
            throw new \InvalidArgumentException('new value should be an object');
        }



        return $result;
    }
}