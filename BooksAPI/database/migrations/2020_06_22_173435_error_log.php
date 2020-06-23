<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ErrorLog extends Migration
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
        Schema::create("errorlogs", function(Blueprint $table){
                $table->bigIncrements("id");
                $table->string("MethodName");
                $table->string("ErrorMessage");
                $table->string("ErrorDetails");
                $table->string("dateLogged");
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
