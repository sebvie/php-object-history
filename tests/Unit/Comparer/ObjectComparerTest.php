<?php

namespace PhpObjectComparer\Tests\Unit\Comparer;

use PhpObjectHistory\Entity\ObjectChange;
use PHPUnit\Framework\TestCase;
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class ObjectComparerTest extends TestCase
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
    }

    /**
     * @return void
     */
    public function testComparePrivateAttribute(): void
    {
        $oldValueChange = 1;
        $newValueChange = 2;
        $oldValue = new ObjectClassFixture();
        $oldValue->setPrivateProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setPrivateProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('privateProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testComparePropertyAdded(): void
    {
        $addedPropertyName = 'addedProperty';
        $addedPropertyValue = 'addedPropertyValue';

        $oldValue = new ObjectClassFixture();
        $newValue = new ObjectClassFixture();
        $newValue->$addedPropertyName = $addedPropertyValue;

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals($addedPropertyName, $objectChange->getAttribute());
        $this->assertEquals(null, $objectChange->getOldValue());
        $this->assertEquals($addedPropertyValue, $objectChange->getNewValue());
    }
}