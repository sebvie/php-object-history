<?php

namespace PhpObjectComparer\Tests\Unit\Formatter;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Formatter\DatetimeFormatter;
use DateTime;

class DatetimeFormatterTest extends BaseTestCase
{

    const FIXTURE_PROPERTY_COUNT = 9;

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
        $datetime = new DateTime();

        $result = $this->subject->format($datetime);

        $this->assertEquals($datetime->format('c'), $result);
    }

    /**
     * @return void
     */
    public function testSupports(): void
    {
        $datetime = new DateTime();

        $result = $this->subject->supports($datetime);

        $this->assertTrue($result);
    }
}