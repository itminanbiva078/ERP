<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases_payments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->nullable();
            $table->integer('voucher_id')->nullable()->comment("purchases voucher id");
            $table->string('voucher_no',25)->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->date('date')->nullable();
            $table->string("documents")->nullable();
            $table->string("payment_type",25)->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('cheque_number',25)->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('debit')->default(0)->nullable()->comment("invoice amount");
            $table->float('credit')->default(0)->nullable()->comment("purchases payment");
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
        Schema::dropIfExists('purchases_payments');
    }
}
