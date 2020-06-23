<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Authors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create("authors", function(Blueprint $table){
                $table->bigIncrements("id");
                $table->string("fullname");
                $table->string("emailAddress");
                $table->unassignedBigIncrements("books_id");
                $table->foreign("books_id")->references("id")->on("books");

        });
        */
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
