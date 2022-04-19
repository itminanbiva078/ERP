<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->tinyInteger('form_id')->default(18);
            $table->integer('customer_id')->unsigned();
            $table->string('voucher_no',20)->nullable();
            $table->date('date')->nullable();
            $table->float('subtotal',12,2)->nullable();
            $table->float('discount',12,2)->nullable()->default(0);
            $table->string('documents')->nullable();
            $table->string('advance_paid')->default(0);
            $table->float('grand_total',12,2)->nullable();
            $table->string('payment_type',25)->nullable();
            $table->integer('account_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->string('cheque_number',30)->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('paid_amount', 12, 2)->nullable();
            $table->float('due_amount', 12, 2)->nullable();
            $table->string('addon')->nullable();
            $table->enum('payment_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
            $table->enum('booking_status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
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
        Schema::dropIfExists('bookings');
    }
}
