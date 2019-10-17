<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;

interface StorageInterface
{
    /**
     * @param ObjectChange $objectChange
     */
    public function addObjectChange(ObjectChange $objectChange): void;
}