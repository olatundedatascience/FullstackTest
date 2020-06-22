<?php
namespace App\Services;
use App\Books;
use Book;

interface IBookRepository {
    public function AddNewBook();
    public function GetBookById($id);
    public function DeleteBook($id);
    public function GetAllBooks();
    public function updateBooks($id);
}

?>
