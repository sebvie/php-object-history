<?php

namespace PhpObjectComparer\Tests\Unit\Comparer;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Tests\Fixture\ObjectClassFixture;

class ObjectComparerTest extends BaseTestCase
{

    const FIXTURE_PROPERTY_COUNT = 10;

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

    /**
     * @return void
     */
    public function testCompareBoolAttribute(): void
    {
        $oldValueChange = true;
        $newValueChange = false;
        $oldValue = new ObjectClassFixture();
        $oldValue->setBoolProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setBoolProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('boolProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareBoolAttributeNotChanged(): void
    {
        $oldValueChange = true;
        $newValueChange = true;
        $oldValue = new ObjectClassFixture();
        $oldValue->setBoolProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setBoolProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareIntAttribute(): void
    {
        $oldValueChange = 1;
        $newValueChange = 2;
        $oldValue = new ObjectClassFixture();
        $oldValue->setIntProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setIntProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('intProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareIntAttributeNotChanged(): void
    {
        $oldValueChange = -1;
        $newValueChange = -1;
        $oldValue = new ObjectClassFixture();
        $oldValue->setIntProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setIntProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareFloatAttribute(): void
    {
        $oldValueChange = 1.1;
        $newValueChange = 1.0;
        $oldValue = new ObjectClassFixture();
        $oldValue->setFloatProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setFloatProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('floatProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareFloatAttributeNotChanged(): void
    {
        $oldValueChange = -1.111111;
        $newValueChange = -1.111111;
        $oldValue = new ObjectClassFixture();
        $oldValue->setFloatProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setFloatProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareNullAttributeNotChanged(): void
    {
        $oldValueChange = null;
        $newValueChange = null;
        $oldValue = new ObjectClassFixture();
        $oldValue->setNullProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setNullProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareArrayAttribute(): void
    {
        $oldValueChange = [1, 2, 3];
        $newValueChange = [1, 2];
        $oldValue = new ObjectClassFixture();
        $oldValue->setArrayProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setArrayProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('arrayProperty', $objectChange->getAttribute());
        $this->assertEquals(implode(',', $oldValueChange), $objectChange->getOldValue());
        $this->assertEquals(implode(',', $newValueChange), $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareArrayAttributeNotChanged(): void
    {
        $oldValueChange = [1, "2", 3];
        $newValueChange = [1, "2", 3];
        $oldValue = new ObjectClassFixture();
        $oldValue->setArrayProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setArrayProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testCompareStringAttribute(): void
    {
        $oldValueChange = "foo";
        $newValueChange = "bar";
        $oldValue = new ObjectClassFixture();
        $oldValue->setStringProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setStringProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertCount(1, $result);

        $objectChange = $result[0];

        $this->assertEquals('stringProperty', $objectChange->getAttribute());
        $this->assertEquals($oldValueChange, $objectChange->getOldValue());
        $this->assertEquals($newValueChange, $objectChange->getNewValue());
    }

    /**
     * @return void
     */
    public function testCompareStringAttributeNotChanged(): void
    {
        $oldValueChange = "foo";
        $newValueChange = "foo";
        $oldValue = new ObjectClassFixture();
        $oldValue->setStringProperty($oldValueChange);
        $newValue = new ObjectClassFixture();
        $newValue->setStringProperty($newValueChange);

        $result = $this->subject->getDiff($oldValue, $newValue);

        $this->assertEmpty($result);
    }
}