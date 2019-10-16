<?php

namespace PhpObjectHistory\Comparer;

use PhpObjectHistory\Entity\ObjectChange;

interface ComparatorInterface
{
    /**
     * @param mixed $oldValue
     * @param mixed $newValue
     * @return ObjectChange[]
     */
    public function getDiff($oldValue, $newValue): array;
}