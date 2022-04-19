<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_openings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->date('date')->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('store_id')->unsigned()->nullable();
            $table->string('voucher_no', 20)->nullable();
            $table->string('documents')->nullable();
            $table->float('grand_total', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->string('stock_summary_id')->nullable();
            $table->enum('purchases_status', ['Approved', 'Inactive', 'Pending', 'Cancel','Partial Payment'])->default('Pending')->comment('default status set approved , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['branch_id', 'store_id']);
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
        Schema::dropIfExists('inventory_openings');
    }
}
