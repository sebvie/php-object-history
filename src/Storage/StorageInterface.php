<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;

interface StorageInterface
{
    /**
     * @param ObjectChange[] $objectChanges
     */
    public function addObjectChanges(array $objectChanges): void;
}