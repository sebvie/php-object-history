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
        $initialObject = new ObjectClassFixture();
        $objectChange = new ObjectChange();
        $objectChange->setAttribute('privateProperty');
        $objectChange->setOldValue(null);
        $objectChange->setNewValue(2);

        $csvFilePath = $this->getAbsolutePath(self::CSV_FILE_PATH);
        $this->subject->setCsvFilePath($csvFilePath);
        $this->subject->setInitialObject($initialObject);
        $this->subject->addObjectChanges([$objectChange]);

        $file = file_get_contents($csvFilePath);

        $this->assertNotEmpty($file);
    }

}