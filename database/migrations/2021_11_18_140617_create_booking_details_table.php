<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->integer('booking_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('room_price')->default(0);
            $table->integer('quantity')->unsigned();
            $table->integer('adult')->unsigned();
            $table->integer('child')->unsigned();
            $table->date('entry_date');
            $table->date('exit_date');
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('booking_details');
    }
}
