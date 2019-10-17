<?php

namespace PhpObjectHistory\Tests\Unit;

use PhpObjectHistory\Tests\BaseTestCase;
use PhpObjectHistory\ObjectHistory;

class ObjectHistoryTest extends BaseTestCase
{
    /**
     * @var ObjectHistory
     */
    protected $subject;


    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setUp();
        $this->subject = new ObjectHistory();
    }

    public function test1()
    {
        $this->assertTrue(true);
    }
}