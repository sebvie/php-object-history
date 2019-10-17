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
    public function testConvertObjectToArray(): void
    {
        $date = new DateTime();
        $input = new \stdClass();
        $input->date = $date;

        $result = $this->subject->convertObjectToArray($input);

        $this->assertEquals(['date' => $date->format('c')], $result);
    }

    /**
     * @return void
     */
    public function testConvertObjectToArrayThrowException(): void
    {
        $this->expectException(FormatterException::class);
        $input = new \stdClass();
        $input->canNotConvert = new \stdClass();

        $this->subject->convertObjectToArray($input);
    }
}