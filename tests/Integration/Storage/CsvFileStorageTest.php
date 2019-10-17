<?php

namespace PhpObjectHistory\Tests\Integration\Comparer;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Storage\CsvFileStorage;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class CsvFileStorageTest extends BaseTestCase
{

    const CSV_FILE_PATH = 'var/csvFileStorageTest.csv';

    /**
     * @var CsvFileStorage
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new CsvFileStorage();
    }

    /**
     * @return void
     */
    public function testAddFileStorageChange(): void
    {
        $objectChangeValue = 2;
        $objectChangeAttribute = 'privateProperty';
        $initialObject = new ObjectClassFixture();
        $objectChange = new ObjectChange();
        $objectChange->setAttribute($objectChangeAttribute);
        $objectChange->setOldValue(null);
        $objectChange->setNewValue($objectChangeValue);

        $csvFilePath = $this->getAbsolutePath(self::CSV_FILE_PATH);
        $this->subject->setCsvFilePath($csvFilePath);
        $this->subject->setInitialObject($initialObject);
        $this->subject->addObjectChanges([$objectChange]);

        $lines = file($csvFilePath, FILE_IGNORE_NEW_LINES);
        $this->assertCount(3, $lines);

        $this->assertStringContainsString(
            $objectChangeAttribute,
            mb_convert_encoding($lines[0], 'UTF-8', 'UTF-16LE')
        );
        $this->assertStringContainsString($objectChangeValue, $lines[2]);

    }

}