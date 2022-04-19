<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesQuatationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_quatations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->string('voucher_no',20)->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('discount',12,2)->nullable()->default(0);
            $table->string('documents')->nullable();
            $table->float('grand_total',12,2)->nullable();
            $table->float('debit',12,2)->nullable();
            $table->float('credit',12,2)->nullable();
            $table->text('note')->nullable();
            $table->enum('sales_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->enum('quatation_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Pending')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->index(['branch_id','customer_id']);
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
        Schema::dropIfExists('sales_quatations');
    }
}
