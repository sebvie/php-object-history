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

        $filename = $this->getAbsolutePath(self::CSV_FILE_PATH);
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $this->assertCount(2, $lines);
    }

    /**
     * @return void
     */
    public function testAddObjectReadmeExample(): void
    {
        $storage = new CsvFileStorage();
        $storage->setCsvFilePath($this->getAbsolutePath(self::CSV_FILE_PATH));

        $objectComparer = new ObjectComparer();

        $objectHistory = new ObjectHistory(
            $storage,
            $objectComparer
        );

        $object = new \stdClass();
        $object->testProperty = 1;
        $object->testPropertyUnchanged = 1;

        $objectHistory->addObject($object);

        $object = new \stdClass();
        $object->testProperty = 2;
        $object->testPropertyUnchanged = 1;

        $objectHistory->addObject($object);

        $filename = $this->getAbsolutePath(self::CSV_FILE_PATH);
        $content = file_get_contents($filename);
        $this->assertEquals(
            <<<HEREDOC
testProperty;testPropertyUnchanged
1;1
2;

HEREDOC
            , $content);
    }
}