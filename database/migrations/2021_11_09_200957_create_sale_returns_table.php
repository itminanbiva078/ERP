<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('sale_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->string('voucher_no',20)->nullable();
            $table->string('payment_type',25)->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('deduction_percen',5,2)->nullable();
            $table->float('deduction_amount',12,2)->nullable();
            $table->float('discount',12,2)->nullable()->default(0);
            $table->string('documents')->nullable();
            $table->float('total_qty',12,2)->nullable();
            $table->float('grand_total',12,2)->nullable();
            $table->float('debit',12,2)->nullable();
            $table->float('credit',12,2)->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('approved_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('sale_returns');
    }
}
