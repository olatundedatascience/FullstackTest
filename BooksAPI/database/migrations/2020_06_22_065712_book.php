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
            $table->bigInteger("authors_id");
            $table->string("publisher");
            $table->integer("number_of_pages");
            $table->dateTime("release_date");
            $table->primary("id");
            $table->foreign("authors_id")->references("id")->on("authors");

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
