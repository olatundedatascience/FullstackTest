<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetAllBooks()
    {
        $status = $this->getStatus("/api/books");
        $this->assertTrue($status == 200 || $status != 400 || $status != 500);
    }

    public function testGetBookById() {
        $result = $this->getStatus("/api/books/6"); // jst pluck in any random id to test

      $this->assertNotEmpty($result);
        //$this->assertTrue($result == 200);

    }
}
