<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Formatter\ObjectFormatterHandler;
use ReflectionObject;

class CsvFileStorage implements StorageInterface
{

    /**
     * @var string
     */
    protected $csvFilePath;

    /**
     * @var resource
     */
    protected $csvFileHandle;

    /**
     * @var object
     */
    protected $initialObject;

    /**
     * @var ObjectFormatterHandler
     */
    protected $objectFormatterHandler;
    /**
     * @var array
     */
    protected $propertyNames = [];

    /**
     * @return void
     */
    public function __construct()
    {
        $this->objectFormatterHandler = new ObjectFormatterHandler();
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        if (!empty($this->csvFileHandle)) {
            fclose($this->csvFileHandle);
        }
    }

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
     * @param object $object
     */
    public function setInitialObject(object $object): void
    {
        $this->initialObject = $object;
        $propertyNames = $this->objectFormatterHandler->convertObjectToArray($object);

        $this->writeCsvLine(array_keys($propertyNames));
        $this->writeCsvLine($propertyNames);

        // set all values null
        $this->propertyNames = array_fill_keys(array_keys($propertyNames), null);
    }

    /**
     * @param ObjectChange[] $objectChanges
     */
    public function addObjectChanges(array $objectChanges): void
    {
        $this->writeObjectChanges($objectChanges);
    }

    /**
     * @param ObjectChange[] $objectChanges
     */
    protected function writeObjectChanges(array $objectChanges): void
    {
        $attributes = $this->propertyNames;

        foreach ($objectChanges as $objectChange) {
            $attribute = $objectChange->getAttribute();
            if(!array_key_exists($attribute, $attributes)) {
                throw new StorageException('unknown attribute: '. $attribute);
            }
            $attributes[$attribute] = $objectChange->getNewValue();
        }
        $this->writeCsvLine($attributes);
    }

    protected function writeCsvLine(array $data): void
    {
        if (!$this->csvFileHandle) {
            $this->csvFileHandle = fopen($this->csvFilePath, 'w');
        }
        $data = array_map(function($cell){
            return mb_convert_encoding($cell, 'UTF-16LE', 'UTF-8');
        }, $data);

        fputcsv($this->csvFileHandle, $data, ';');
    }
}