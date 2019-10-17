<?php

namespace PhpObjectComparer\Tests\Unit\Formatter;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\Formatter\FormatterException;
use PhpObjectHistory\Formatter\ObjectFormatterHandler;
use DateTime;

class ObjectFormatterHandlerTest extends BaseTestCase
{

    const FIXTURE_PROPERTY_COUNT = 9;

    /**
     * @var ObjectFormatterHandler
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new ObjectFormatterHandler();
    }

    /**
     * @return void
     */
    public function testFormatDatetime(): void
    {
        $input = new DateTime();

        $result = $this->subject->formatPropertyToString($input);

        $this->assertEquals($input->format('c'), $result);
    }

    /**
     * @return void
     */
    public function testFormatThrowException(): void
    {
        $this->expectException(FormatterException::class);
        $input = new \stdClass();

        $this->subject->formatPropertyToString($input);
    }
}