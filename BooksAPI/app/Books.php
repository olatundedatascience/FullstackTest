<?php

namespace App;

use Authors;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    //

    protected $tableName = "books";

    public function Authors(){
        return $this->belongsTo(Authors::class, "books_id", "id");
    }
}
