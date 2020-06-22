<?php

use App\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    //Books::all()
    return $request->user();
});


Route::get("/books", "BooksController@GetAll");
Route::post("/books", "BooksController@AddNewBook");
Route::get("/books/{id}", "BooksController@GetBookById");
Route::put("/books/{id}", "BooksController@UpdateBook");
Route::delete("/books/{id}", "BooksController@Delete");
