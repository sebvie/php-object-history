<?php

namespace PhpObjectComparer\Tests\Unit\Comparer;

use PHPUnit\Framework\TestCase;
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class ObjectComparerTest extends TestCase
{

    const FIXTURE_PROPERTY_COUNT = 9;

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
    public function testCompareEmptyOldValue(): void
    {
        $oldValue = new \stdClass();
        $newValue = new ObjectClassFixture();

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(self::FIXTURE_PROPERTY_COUNT, $result);
        foreach ($result as $objectChange) {
            $this->assertNull($objectChange->getOldValue());
        }
    }

    /**
     * @return void
     */
    public function testCompareEmptyNewValue(): void
    {
        $oldValue = new ObjectClassFixture();
        $newValue = new \stdClass();

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(self::FIXTURE_PROPERTY_COUNT, $result);
        foreach ($result as $objectChange) {
            $this->assertNull($objectChange->getNewValue());
        }
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
    public function testCompareProtectedAttribute(): void
    {
        $oldValueChange = 1;
        $newValueChange = 2;
        $oldValue = new ObjectClassFixture();
        $oldValue->setProtectedProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setProtectedProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('protectedProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testComparePublicAttribute(): void
    {
        $oldValueChange = 1;
        $newValueChange = 2;
        $oldValue = new ObjectClassFixture();
        $oldValue->setPublicProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setPublicProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('publicProperty', $objectChange->getAttribute());
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