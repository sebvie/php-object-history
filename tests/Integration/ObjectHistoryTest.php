<?php

namespace PhpObjectHistory\Tests\Integration;

use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Storage\CsvFileStorage;
use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\ObjectHistory;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class ObjectHistoryTest extends BaseTestCase
{

    const CSV_FILE_PATH = 'var/objectHistoryTest.csv';

    /**
     * @var ObjectHistory
     */
    protected $subject;

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();

        $storage = new CsvFileStorage();
        $storage->setCsvFilePath($this->getAbsolutePath(self::CSV_FILE_PATH));

        $objectComparer = new ObjectComparer();

        $this->subject = new ObjectHistory(
            $storage,
            $objectComparer
        );
    }

    /**
     * @return void
     */
    public function testAddObject(): void
    {
        $object = new ObjectClassFixture();

        $this->subject->addObject($object);

        $file = file_get_contents($this->getAbsolutePath(self::CSV_FILE_PATH));

        $this->assertNotEmpty($file);
    }
}