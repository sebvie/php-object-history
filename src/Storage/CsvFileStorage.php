<?php

namespace PhpObjectHistory\Storage;


use PhpObjectHistory\Entity\ObjectChange;

class CsvFileStorage implements StorageInterface
{

    /**
     * @var string
     */
    protected $csvFilePath;

    /**
     * @return string
     */
    public function getCsvFilePath(): string
    {
        return $this->csvFilePath;
    }

    /**
     * @param string $csvFilePath
     * @return CsvFileStorage
     */
    public function setCsvFilePath(string $csvFilePath): CsvFileStorage
    {
        $this->csvFilePath = $csvFilePath;
        return $this;
    }

    /**
     * @param ObjectChange $objectChange
     */
    public function addObjectChange(ObjectChange $objectChange): void
    {

    }
}