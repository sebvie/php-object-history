<?php

namespace PhpObjectHistory\Tests\Integration\Comparer;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Storage\CsvFileStorage;

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
        $objectChange = new ObjectChange();

        $this->subject->setCsvFilePath($this->getAbsolutePath(self::CSV_FILE_PATH));
        $this->subject->addObjectChange($objectChange);


    }

}