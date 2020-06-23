<?php

namespace App\Http\Controllers;

use App\Books;
use App\Services\Repo\BookRepository;
use Authors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use stdClass;

class BooksController extends Controller
{
    //
    private $_book_repo;

    public function __construct()
    {
        $this->_book_repo = new BookRepository();
    }
    public function GetAll(Request $request) {
        $reponseObject = new stdClass();
        $reponseObject->status_code = 200;
        $reponseObject->status ="success";
        $reponseObject->data = $this->_book_repo->GetAllBooks();

        return response(json_encode($reponseObject), "200", ["Content-Type"=>"application/json"]);
    }

    public function AddNewBook(Request $request) {
        try {
            $this->_book_repo = new BookRepository($request);

            $objectFromDB = (array)$this->_book_repo->AddNewBook();

            if($objectFromDB != null || isset($objectFromDB) || count($objectFromDB) > 0) {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 201;
                $reponseObject->status ="success";
                $reponseObject->data = $objectFromDB;
                return response(json_encode($reponseObject), "201", ["Content-Type"=>"application/json"]);
            }
            else {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 400;
                $reponseObject->status ="failed";
                $reponseObject->data = $objectFromDB;
                return response(json_encode($reponseObject), "400", ["Content-Type"=>"application/json"]);
            }



        }
        catch(Exception $ex) {

            $this->_book_repo->LogError("AddNewBook", $ex->getMessage(),  $ex->getFile()." at line ".$ex->getLine());
                    $reponseObject = new stdClass();
                    $reponseObject->status_code = 500;
                    $reponseObject->status ="failed";
                    $reponseObject->message = "An Error has occured";
                return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
        }



    }

    public function GetBookById($id) {

        try {
                $findBook = $this->_book_repo->GetBookById($id);
                $reponseObject = new stdClass();
                $responseCode= 0;
                if($findBook != null) {
                    $reponseObject->status_code = 200;
                    $reponseObject->status ="success";
                    $reponseObject->data = $findBook;
                    $responseCode = "200";
                }
                else {
                    $reponseObject->status_code = 404;
                    $reponseObject->status ="failed";
                    $reponseObject->data = "No data found for id:'".$id."'";
                    $responseCode ="404";
                }

                return response(json_encode($reponseObject), $responseCode, ["Content-Type"=>"application/json"]);
            }
            catch(Exception $ex)
            {
                $this->_book_repo->LogError("Get Book with id: '".$id."'", $ex->getMessage(), $ex->getFile()."at line ".$ex->getLine());
                $reponseObject = new stdClass();
                $reponseObject->status_code = 500;
                $reponseObject->status ="failed";
                $reponseObject->message = "An Error has occured";
                return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
            }


    }

    public function UpdateBook(Request $request, $id) {
        try {
            $this->_book_repo = new BookRepository($request);
            $updated = $this->_book_repo->updateBooks($id);

            if($updated != 0 || $updated != false) {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 200;
                $reponseObject->status ="success";
                $reponseObject->message = "Book updated successfully";
                $reponseObject->data = $updated;

                return response(json_encode($reponseObject), "200", ["Content-Type"=>"application/json"]);
            }
            else {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 400;
                $reponseObject->status ="failed";
                $reponseObject->data = "update failed";

                return response(json_encode($reponseObject), "400", ["Content-Type"=>"application/json"]);
            }

        }
        catch(Exception $ex) {
            $this->_book_repo->LogError("Update Book with id: '".$id."'", $ex->getMessage(), $ex->getFile()." at line " + $ex->getLine());
            $erroObject = new stdClass();
            $erroObject->message = "An Error has occured";
            $erroObject->status_code = 500;

            return response(json_encode($erroObject), "500", ["Content-Type"=>"application/json"]);
        }
    }

    public function Delete(Request $request, $id) {
        try {
            $this->_book_repo = new BookRepository($request);
            $serverResponse = $this->_book_repo->DeleteBook($id);

            if($serverResponse) {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 204;
                $reponseObject->status ="success";
                $reponseObject->message ="book Deleted successfully";
                return response(json_encode($reponseObject), "200", ["Content-Type"=>"application/json"]);
            }
            else {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 400;
                $reponseObject->status ="failed";
                $reponseObject->message ="failed to deleted";
                return response(json_encode($reponseObject), "400", ["Content-Type"=>"application/json"]);
            }
        }
        catch(Exception $ex) {
                $this->_book_repo->LogError("Delete Book with id: '".$id."'", $ex->getMessage(), $ex->getFile() ." at line ".$ex->getLine());
                $reponseObject = new stdClass();
                $reponseObject->status_code = 500;
                $reponseObject->status ="failed";
                $reponseObject->message = "An Error has occured";
                return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
        }
    }

    public function HandleExternalCall(Request $request) {
        try {
             $bookName= strtolower($request->query("name"));

            if(!empty($bookName)) {
                $responseFromServer = Http::get("https://www.anapioficeandfire.com/api/books")->object();



//               $hj = $responseFromServer;

                $array_filter_by_name =[];
               //$array_filter_by_name[0] = $responseFromServer[0]["name"];
//Str::contains()
                $responseObject = new stdClass();
                $responseObject->status_code = 200;
                $responseObject->status = "success";


               foreach($responseFromServer as $response) {
                   // if(strtolower($response->name)  == strtolower($bookName)) {
                   if(Str::contains(strtolower($response->name), strtolower($bookName))) {
                        $currentResponse = new stdClass();
                        $currentResponse->name = $response->name;
                        $currentResponse->isbn = $response->isbn;
                        $currentResponse->authors = $response->authors;
                        $currentResponse->numbers_of_pages = $response->numberOfPages;
                        $currentResponse->publisher = $response->publisher;
                        $currentResponse->released_date= $response->released;

                        array_push($array_filter_by_name, $currentResponse);

                   }
               }

               $responseObject->data = $array_filter_by_name;

               return response(json_encode($responseObject), "200", ["Content-Type"=>"application/json"]);

            //   $responseObject->data = $array_filter_by_name;
              //  $response = $responseFromServer;

              // array_filter($hj, "getElementsByName");
              // response(json_encode($hj), "200", ["Content-Type"=>"application/json"]);
            }
            else {
                    $reponseObject = new stdClass();
                    $reponseObject->status_code = 400;
                    $reponseObject->status ="failed";
                    $reponseObject->message ="failed to fetch";
                    return response(json_encode($reponseObject), "400", ["Content-Type"=>"application/json"]);
            }
        }
        catch(Exception $ex) {
            $this->_book_repo->LogError("handling external api call", $ex->getMessage(), $ex->getFile()." at line ".$ex->getLine());
            $reponseObject = new stdClass();
            $reponseObject->status_code = 500;
            $reponseObject->status ="failed";
            $reponseObject->message = "An Error has occured";
            return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
        }

    }


}
