<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;

interface StorageInterface
{
    /**
     * @param object $object
     */
    public function setInitialObject(object $object): void;
    /**
     * @param ObjectChange[] $objectChanges
     */
    public function addObjectChanges(array $objectChanges): void;
}