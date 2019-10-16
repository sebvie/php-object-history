<?php

namespace PhpObjectHistory\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PhpObjectHistory\ObjectHistory;

class ObjectHistoryTest extends TestCase
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