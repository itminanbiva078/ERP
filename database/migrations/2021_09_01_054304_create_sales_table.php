<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->tinyInteger('form_id')->default(5)->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('sales_quatation_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->string('cheque_number',30)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('voucher_no',20)->nullable();
            $table->string('payment_type',25)->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('total_qty',12,2)->nullable();
            $table->float('discount',12,2)->nullable()->default(0);
            $table->string('documents')->nullable();
            $table->float('grand_total',12,2)->nullable();
            $table->float('debit',12,2)->nullable();
            $table->float('credit',12,2)->nullable();
            $table->float('paid_amount', 12, 2)->nullable();
            $table->float('due_amount', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->enum('challan_status', ['Approved','Pending','Partial Received'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
            $table->enum('sales_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
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
        Schema::dropIfExists('sales');
    }
}
