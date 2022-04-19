<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveVoucherLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_voucher_ledgers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->integer('receive_id')->unsigned()->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('debit_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->float('debit',20,2)->nullable();
            $table->float('credit',20,2)->nullable();
            $table->text('memo')->nullable();
            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->index(['receive_id','debit_id']);
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
        Schema::dropIfExists('receive_voucher_ledgers');
    }
}
