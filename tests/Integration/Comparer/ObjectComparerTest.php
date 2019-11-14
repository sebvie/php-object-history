<?php

namespace PhpObjectComparer\Tests\Integration\Comparer;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Formatter\ObjectFormatterHandler;
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class ObjectComparerTest extends BaseTestCase
{
    /**
     * @var ObjectComparer
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new ObjectComparer();
        $this->subject->setObjectFormatterHandler(new ObjectFormatterHandler());
    }

    /**
     * @return void
     */
    public function testCompareObjectProperty(): void
    {
        $objectPropertyOld = new \DateTime('now');
        $objectPropertyNew = new \DateTime('yesterday');

        $oldValue = new ObjectClassFixture();
        $oldValue->setObjectProperty($objectPropertyOld);
        $newValue = new ObjectClassFixture();
        $newValue->setObjectProperty($objectPropertyNew);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('objectProperty', $objectChange->getAttribute());
        $this->assertEquals($objectPropertyOld->format('c'), $objectChange->getOldValue());
        $this->assertEquals($objectPropertyNew->format('c'), $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareObjectPropertySameValueNoChange(): void
    {
        $date = new \DateTime('now');
        $objectPropertyOld = clone($date);
        $objectPropertyNew = clone($date);

        $oldValue = new ObjectClassFixture();
        $oldValue->setObjectProperty($objectPropertyOld);
        $newValue = new ObjectClassFixture();
        $newValue->setObjectProperty($objectPropertyNew);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareObjectToString(): void
    {
        $date = new \DateTime('now');
        $objectPropertyOld = clone($date);
        $objectPropertyNew = clone($date);

        $oldValue = new ObjectClassFixture();
        $oldValue->setObjectProperty($objectPropertyOld);
        $newValue = new ObjectClassFixture();
        $newValue->setObjectProperty($objectPropertyNew);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }
}