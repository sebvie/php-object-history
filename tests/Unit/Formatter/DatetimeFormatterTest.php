<?php

namespace PhpObjectComparer\Tests\Unit\Formatter;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Formatter\DatetimeFormatter;
use DateTime;

class DatetimeFormatterTest extends BaseTestCase
{

    /**
     * @var DatetimeFormatter
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new DatetimeFormatter();
    }

    /**
     * @return void
     */
    public function testFormat(): void
    {
        $object = new DateTime();

        $result = $this->subject->format($object);

        $this->assertEquals($object->format('c'), $result);
    }

    /**
     * @return void
     */
    public function testSupports(): void
    {
        $object = new DateTime();

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