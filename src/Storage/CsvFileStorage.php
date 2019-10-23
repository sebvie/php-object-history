<?php

namespace PhpObjectHistory\Storage;

use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Formatter\ObjectFormatterHandler;

class CsvFileStorage implements StorageInterface
{

    /**
     * @var string
     */
    protected $csvDelimiter = ';';

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
     * @param string $csvFilePath
     * @return CsvFileStorage
     */
    public function setCsvFilePath(string $csvFilePath): CsvFileStorage
    {
        $this->csvFilePath = $csvFilePath;
        return $this;
    }

    /**
     * @return ObjectFormatterHandler
     */
    public function getObjectFormatterHandler(): ObjectFormatterHandler
    {
        return $this->objectFormatterHandler;
    }

    /**
     * @param ObjectFormatterHandler $objectFormatterHandler
     */
    public function setObjectFormatterHandler(ObjectFormatterHandler $objectFormatterHandler): void
    {
        $this->objectFormatterHandler = $objectFormatterHandler;
    }

    /**
     * @return string
     */
    public function getCsvDelimiter(): string
    {
        return $this->csvDelimiter;
    }

    /**
     * @param string $csvDelimiter
     * @return CsvFileStorage
     */
    public function setCsvDelimiter(string $csvDelimiter): CsvFileStorage
    {
        $this->csvDelimiter = $csvDelimiter;
        return $this;
    }

    /**
     * @return resource
     */
    public function getCsvFileHandle()
    {
        return $this->csvFileHandle;
    }

    /**
     * @param resource $csvFileHandle
     * @return CsvFileStorage
     */
    public function setCsvFileHandle($csvFileHandle): CsvFileStorage
    {
        $this->csvFileHandle = $csvFileHandle;
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
        if (empty($objectChanges)) {
            return;
        }

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

    /**
     * @param array $data
     */
    protected function writeCsvLine(array $data): void
    {
        if (!$this->csvFileHandle) {
            $this->csvFileHandle = fopen($this->csvFilePath, 'w');
        }
        $data = array_map(function($cell){
            if (is_bool($cell)) {
                $cell = ($cell === true ? 'true' : 'false');
            }
            return $cell;
        }, $data);

        fputcsv($this->csvFileHandle, $data, $this->csvDelimiter);
    }
}