<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('supplier_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->string('requisition_id',20)->nullable();
            $table->string('voucher_no',20)->nullable();
            $table->string('documents')->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('total_qty',12,2)->nullable();
            $table->float('discount',12,2)->nullable()->default(0);
            $table->float('grand_total',12,2)->nullable();
            $table->text('note')->nullable();
            $table->enum('order_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Pending')->comment('default status set active , penidng status waiting for approbal');
            $table->enum('purchases_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Pending')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->index(['branch_id','supplier_id','requisition_id']);
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
        Schema::dropIfExists('purchases_orders');
    }
}
