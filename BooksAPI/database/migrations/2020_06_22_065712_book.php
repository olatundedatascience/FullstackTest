<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Book extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /*
        Schema::create("books", function(Blueprint $table){

            $table->bigIncrements("id");
            $table->string("name");
            $table->string("country");
            
            $table->string("publisher");
            $table->integer("number_of_pages");
            $table->dateTime("release_date");


        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
