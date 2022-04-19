<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('general_id')->unsigned();
            $table->integer('mrr_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->string('batch_no',100)->nullable();
            $table->integer('pack_size')->nullable();
            $table->integer('pack_no')->nullable();
            $table->integer('quantity')->unsigned();
            $table->float('unit_price',12,2)->nullable();
            $table->float('total_price',12,2)->nullable();
            $table->enum('type', ['in', 'out','rin','rout','tin','tout'])->default("in")->comment('1=purchases in,out=purchases out,3=return in, 4=return out,5=transfer in, 6=transfer out');
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['general_id','branch_id','store_id','product_id']);
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
        Schema::dropIfExists('stocks');
    }
}
