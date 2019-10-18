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
     * @return StorageInterface
     */
    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     * @return ObjectHistory
     */
    public function setStorage(StorageInterface $storage): ObjectHistory
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return ComparatorInterface
     */
    public function getObjectComparer(): ComparatorInterface
    {
        return $this->objectComparer;
    }

    /**
     * @param ComparatorInterface $objectComparer
     * @return ObjectHistory
     */
    public function setObjectComparer(ComparatorInterface $objectComparer): ObjectHistory
    {
        $this->objectComparer = $objectComparer;
        return $this;
    }

    /**
     * @return object
     */
    public function getLastObject(): object
    {
        return $this->lastObject;
    }

    /**
     * @param object $lastObject
     * @return ObjectHistory
     */
    public function setLastObject(object $lastObject): ObjectHistory
    {
        $this->lastObject = $lastObject;
        return $this;
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