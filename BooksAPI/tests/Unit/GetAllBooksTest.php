<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class GetAllBooksTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function GetAllbooksTextEndpoint()
    {
        $result = $this->getStatus("/api/books") == 200;
        $this->assertTrue($result);
    }

    public function GetBookyBid() {
        // make a request with fake id...
        $response = $this->get()
    }
}
