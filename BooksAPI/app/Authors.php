<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    //
    public $tableName = "authors";

    public function Books() {
        return $this->hasMany(Books::class);
    }
}
