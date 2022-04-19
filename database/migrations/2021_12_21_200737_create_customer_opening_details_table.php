<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOpeningDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_opening_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->nullable();
            $table->date('date')->nullable();
            $table->integer('customer_openings_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->float('opening_balance')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel','Partial Received'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
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
        Schema::dropIfExists('customer_opening_details');
    }
}
