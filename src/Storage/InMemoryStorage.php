<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;

class InMemoryStorage implements StorageInterface
{

    /**
     * @var array
     */
    protected $result = [];

    /**
     * @param object $object
     */
    public function setInitialObject(object $object): void
    {
        $this->result[] = $object;
    }

    /**
     * @param ObjectChange[] $objectChanges
     */
    public function addObjectChanges(array $objectChanges): void
    {
        if (empty($objectChanges)) {
            return;
        }

        $this->result[] = $objectChanges;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

}