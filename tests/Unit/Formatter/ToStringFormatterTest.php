<?php

namespace PhpObjectComparer\Tests\Unit\Formatter;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Formatter\ToStringFormatter;
use DateTime;
use PhpObjectHistory\Tests\Fixture\ToStringClassFixture;

class ToStringFormatterTest extends BaseTestCase
{

    /**
     * @var ToStringFormatter
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new ToStringFormatter();
    }

    /**
     * @return void
     */
    public function testFormat(): void
    {
        $propertyValue = 1111;
        $object = new ToStringClassFixture();
        $object->setPrivateProperty($propertyValue);

        $result = $this->subject->format($object);

        $this->assertSame((string) $propertyValue, $result);
    }

    /**
     * @return void
     */
    public function testSupports(): void
    {
        $object = new ToStringClassFixture();

        $result = $this->subject->supports($object);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testNotSupports(): void
    {
        $object = new \stdClass();

        $result = $this->subject->supports($object);

        $this->assertFalse($result);
    }
}