<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *add user login history
     * @return void
     */



    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->integer('user_id');
            $table->integer('date');
            $table->dateTime('login', $precision = 0);
            $table->dateTime('logout', $precision = 0);
            $table->string('browser');
            $table->string('ipaddress');
            $table->float('totalStay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
}