<?php

namespace PhpObjectHistory\Tests\Integration\Comparer;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Entity\ObjectChange;
use PhpObjectHistory\Storage\InMemoryStorage;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class InMemoryStorageTest extends BaseTestCase
{
   /**
     * @var InMemoryStorage
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new InMemoryStorage();
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

        $objectChanges = [$objectChange];
        $this->subject->setInitialObject($initialObject);
        $this->subject->addObjectChanges($objectChanges);

        $result = $this->subject->getResult();

        $this->assertSame($initialObject, $result[0]);
        $this->assertSame($objectChanges, $result[1]);

    }

}