<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->nullable();
            $table->integer('voucher_id')->nullable()->comment("sales voucher id");
            $table->tinyInteger('form_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->date('date')->nullable();
            $table->string("documents")->nullable();
            $table->string('collection_type',55)->nullable();
            $table->string("payment_type",25)->nullable();
            $table->string('cheque_number',25)->nullable();
            $table->date('cheque_date')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('bank_id')->nullable();
            $table->float('debit')->default(0)->nullable()->comment("invoice amount");
            $table->float('credit')->default(0)->nullable()->comment("sales payment");
            $table->string('note')->nullable();
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
        Schema::dropIfExists('sale_payments');
    }
}
