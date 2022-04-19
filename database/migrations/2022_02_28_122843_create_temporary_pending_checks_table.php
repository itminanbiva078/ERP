<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryPendingChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_pending_checks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->nullable();
            $table->string('voucher_no',30)->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->date('receive_date')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('deposit_date')->nullable();
            $table->tinyInteger("form_id")->nullable()->comment("voucher type as like sale,purchases,payment voucher etc");
            $table->integer("voucher_id")->nullable()->comment("voucher id as like , purchases id,sales id");
            $table->integer('bank_id')->nullable();
            $table->integer('customer_supplier_id')->nullable();
            $table->string('cheque_number',55)->nullable();
            $table->float('payment')->nullable();
            $table->string('note')->nullable();
            $table->string('documents',120)->nullable();
            $table->enum('status', ['Approved', 'Dishonoured', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('temporary_pending_checks');
    }
}
