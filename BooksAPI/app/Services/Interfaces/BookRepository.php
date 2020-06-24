<?php
namespace App\Services\Repo;

use App\Books;
use App\Services\IBookRepository;
use App\Authors;
use App\ErrorLogs;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookRepository implements IBookRepository {
    //private Books $book;
   // private Authors $authors;
   private $request = null;
    public function __construct(Request $request=null)
    {

        $this->request = $request;
    }

    public function LogError($methodName, $errorMessage, $errorDetail) {
        $errorlogs = new ErrorLogs();
        $now = (new DateTime('now'))->format('yyyy-mm-dd h:m:s');
        $errorlogs->dateLogged = (string)$now;
        $errorlogs->MethodName = $methodName;
        $errorlogs->ErrorMessage =  $errorMessage;
        $errorlogs->ErrorDetails = $errorDetail;

        $errorlogs->save();

    }
    public function GetAllBooks()
    {
        $allBooks = DB::table("books")->get();
        $response = [];

        foreach($allBooks as $book){
            $current_id = $book->id;
            $currentBook = $book;
            $getCurrentBookAuthors = DB::table("authors")->where("books_id","=",$current_id)->get();
            if(count($getCurrentBookAuthors) < 1) {
                $currentBook->authors =[];
            }
            else {
                $currentBook->authors =$getCurrentBookAuthors;
            }

            //$response["authors"]=$getCurrentBookAuthors;
            array_push($response,$currentBook);
        }


        return $response;
    }

    public function GetBookById($id)
    {
        $findBooks = (array)DB::table("books")->where("id", $id)->first();
        if(count($findBooks) > 0) {
            $books_id =$findBooks["id"];
            $authors = DB::table("authors")->where("books_id", $books_id)->get();

            $findBooks["authors"] =$authors;
         //   array_push($findBooks, $reponse);

           // $reponse = ["name"=>];
           return $findBooks;
        }
        else {
            return null;
        }

    }

    public function AddNewBook()
    {
        $isBookExist = $this->isBookExist($this->request->json("name"));

        if($isBookExist == true || $isBookExist == 1) {
                return null;
        }
        else {

            if(!empty($this->request->json("name")) || $this->request->json(("name") != null)) {

                $result = DB::table("books")->insertGetId([
                    "name"=>$this->request->json("name"),
                    "number_of_pages"=> $this->request->json("number_of_pages"),
                   // "isbn" => $this->request->json("isbn"),
                    "country" => $this->request->json("country"),
                    "publisher" => $this->request->json("publisher"),
                    "release_date" => $this->request->json("release_date")
                ]);

                if($result > 0) {
                    $book_id = $result;
                    $authors = $this->request->json("authors");
                    $_insert_author = 0;
                    foreach($authors as $author) {
                        $author_insert = DB::table("authors")->insertGetId([
                            "fullname"=>$author["fullname"],
                            "emailAddress"=>$author["emailAddress"],
                            'books_id' => $result
                            //"books_id">$result
                        ]);
                        $_insert_author = $author_insert;
                    }

                   $book_created = $this->getBookDetails($result);

                   return count($book_created) > 0 ? $book_created : null;
                }
                else {
                    return null;
                }


            }
            else {
                $response = ["error"=>"name is required"];
                return $response;
            }





        }

    }

    public function updateBooks($id)
    {
        $bookById = $this->getBookDetails($id);

        if($bookById != -1) {
            $updateBook = DB::table("books")->where("id","=",$id)
                ->update([
                "name"=>$this->request->json("name"),
                "number_of_pages"=> $this->request->json("number_of_pages"),
               // "isbn" => $this->request->json("isbn"),
                "country" => $this->request->json("country"),
                "publisher" => $this->request->json("publisher"),
                "release_date" => $this->request->json("release_date")
            ]);
            if($updateBook > 0) {
                //$book_id = $result;
                $authors = $this->request->json("authors");
                $_insert_author = 0;

               // Storage::put("hello.json", $ins);
                foreach($authors as $author) {

                     DB::table("authors")->where("books_id", "=", $id)
                     ->update([
                        "fullname"=>$author["fullname"],
                        "emailAddress"=>$author["emailAddress"]

                    ]);

                }

                return $this->getBookDetails($id);
            }
            else {
                return false;
            }

        }
        else {
            return false;
        }


    }
    public function DeleteBook($id)
    {
        $books = $this->getBookDetails($id);

        if($books != -1) {
           DB::table("authors")->where("books_id", "=", $books["id"])->delete();

            DB::table("books")->where("id", "=", $books["id"])->delete();

            return $this->getBookDetails($id) == -1;
        }
        else {
            return true;
        }

    }

    private function isBookExist($bookName) {
        $found = (array)DB::table("books")->where("name", "=", $bookName)->first();

        if(!empty($found) || count($found) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    private function getBookDetails($bookId) {
        $found = (array)DB::table("books")->where("id", $bookId)->first();

        if(count($found) > 0) {
            $books_id =$found["id"];
            $authors = DB::table("authors")->where("books_id", $books_id)->get();

            $found["authors"]=  $authors;
           // $reponse = ["authors" => $authors];
           // array_push($found, $reponse);

           // $reponse = ["name"=>];
           return $found;
        }
        else {
            return -1;
        }

    }

}
