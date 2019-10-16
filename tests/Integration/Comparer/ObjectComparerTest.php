<?php

namespace PhpObjectComparer\Tests\Integration\Comparer;

use PhpObjectHistory\Formatter\ObjectFormatterHandler;
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
        $this->subject->setObjectFormatter(new ObjectFormatterHandler());
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
}