<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesLoanReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_loan_return_details', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('slreturn_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->string('batch_no')->nullable()->default(0);
            $table->float('pack_size')->nullable()->default(0);
            $table->float('pack_no')->nullable()->default(0);
            $table->float('deduction_percent',12,2)->nullable();
            $table->float('deduction_amount',12,2)->nullable();
            $table->float('quantity',12,2)->nullable();
            $table->float('unit_price',12,2)->nullable();
            $table->float('total_price',12,2)->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['branch_id','slreturn_id','product_id']);
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
        Schema::dropIfExists('sales_loan_return_details');
    }
}
