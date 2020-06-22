<?php

namespace App\Http\Controllers;

use App\Books;
use App\Services\Repo\BookRepository;
use Authors;
use Exception;
use Illuminate\Http\Request;
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
            }
            else {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 400;
                $reponseObject->status ="failed";
                $reponseObject->data = $objectFromDB;
            }


            return response(json_encode($reponseObject), "400", ["Content-Type"=>"application/json"]);
        }
        catch(Exception $ex) {
            $reponseObject = new stdClass();
                $reponseObject->status_code = 500;
                $reponseObject->status ="failed";
                $reponseObject->error = $ex->getMessage();
                $reponseObject->lineNumebr = $ex->getLine();
                $reponseObject->trace = $ex->getTraceAsString();
                return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
        }



    }

    public function GetBookById($id) {

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

    public function UpdateBook(Request $request, $id) {
        try {
            $this->_book_repo = new BookRepository($request);
            $updated = $this->_book_repo->updateBooks($id);

            if($updated != 0 || $updated != false) {
                $reponseObject = new stdClass();
                $reponseObject->status_code = 400;
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
            $erroObject = new stdClass();
            $erroObject->message = $ex->getMessage();
            $erroObject->lineNumber = $ex->getLine();
            $erroObject->trace = $ex->getTraceAsString();
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
            $reponseObject = new stdClass();
            $reponseObject->status_code = 500;
            $reponseObject->status ="failed";
            $reponseObject->error = $ex->getMessage();
            $reponseObject->lineNumebr = $ex->getLine();
            $reponseObject->trace = $ex->getTraceAsString();
            return response(json_encode($reponseObject), "500", ["Content-Type"=>"application/json"]);
        }
    }


}
