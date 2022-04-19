<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_challans', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->string('voucher_no',20)->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('sales_id')->unsigned()->nullable();
            $table->string('delivery_location',100)->nullable();
            $table->float('total_qty',12,2)->nullable();
            $table->text('note')->nullable();
            $table->enum('receive_status', ['Approved', 'Inactive', 'Pending', 'Cancel','Partial Received'])->default('Pending')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['branch_id','customer_id','sales_id']);
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
        Schema::dropIfExists('delivery_challans');
    }
}
