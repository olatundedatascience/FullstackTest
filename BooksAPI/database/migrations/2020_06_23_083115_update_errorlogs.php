<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateErrorlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::table('errorlogs', function (Blueprint $table) {
            //
            /*
           $table->dropColumn("dateLogged");
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
        Schema::table('errorlogs', function (Blueprint $table) {
            //
        });
    }
}
