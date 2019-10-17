<?php

namespace PhpObjectHistory;

use PhpObjectHistory\Comparer\ComparatorInterface;
use PhpObjectHistory\Storage\StorageInterface;

class ObjectHistory
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var ComparatorInterface
     */
    protected $objectComparer;

    /**
     * the object to make a history from
     *
     * @var object
     */
    private $lastObject;

    /**
     * @param StorageInterface $storage
     * @param ComparatorInterface $objectComparer
     */
    public function __construct(
        StorageInterface $storage,
        ComparatorInterface $objectComparer
    )
    {
        $this->storage = $storage;
        $this->objectComparer = $objectComparer;
    }

    /**
     * @param object $object
     */
    public function addObject(object $object)
    {
        if (empty($this->lastObject)) {
            $this->storage->setInitialObject($object);
        } else {
            $objectChanges = $this->objectComparer->getDiff($this->lastObject, $object);

            $this->storage->addObjectChanges($objectChanges);
        }
        $this->lastObject = $object;
    }

}