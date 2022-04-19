<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->tinyInteger('form_id')->default(4);
            $table->integer('supplier_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->integer('purchases_order_id')->unsigned()->nullable();
            $table->string('voucher_no', 20)->nullable();
            $table->string('payment_type',25)->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('cheque_number',30)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('documents')->nullable();
            $table->string('voucher_reference')->nullable();
            $table->float('debit', 12, 2)->nullable();
            $table->float('credit', 12, 2)->nullable();
            $table->float('subtotal', 12, 2)->nullable();
            $table->float('total_qty',12,2)->nullable();
            $table->float('discount', 12, 2)->nullable();
            $table->float('grand_total', 12, 2)->nullable();
            $table->integer('loder')->nullable();
            $table->text('note')->nullable();
            $table->integer('transportation')->nullable();
            $table->float('paid_amount', 12, 2)->nullable();
            $table->float('due_amount', 12, 2)->nullable();
            $table->enum('mrr_status', ['Approved','Pending','Partial Received'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
            $table->enum('purchases_status', ['Approved', 'Inactive', 'Pending', 'Cancel','Partial Payment'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->index(['supplier_id', 'branch_id', 'purchases_order_id']);
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
        Schema::dropIfExists('purchases');
    }
}