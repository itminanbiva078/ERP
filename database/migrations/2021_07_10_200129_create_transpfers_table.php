<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranspfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transpfers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->string('voucher_no')->nullable();
            $table->integer('from_branch_id')->unsigned()->nullable();
            $table->integer('from_store_id')->unsigned()->nullable();
            $table->integer('to_branch_id')->unsigned()->nullable();
            $table->integer('to_store_id')->unsigned()->nullable();
            $table->string('documents')->nullable();
            $table->float('total_quantity',12,2)->nullable();
            $table->float('total_price',12,2)->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('grand_total', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Pending')->comment('default status set active , penidng status waiting for approbal');
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
        Schema::dropIfExists('transpfers');
    }
}
