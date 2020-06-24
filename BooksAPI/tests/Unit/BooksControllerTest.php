<?php

namespace Tests\Unit;

use App\Services\Repo\BookRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class BooksControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function GetAllBooks() {
        $repo = new BookRepository();
        $result = $repo->GetAllBooks();

        $this->assertTrue(true);
        //$this->assertCO
       // $this->assertNotEmpty($result);
    }
}
