<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('general_setups', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->unsigned()->default(0);
            $table->tinyInteger('general_table_id')->unsigned()->nullable();
            $table->tinyInteger('currencie_id')->unsigned()->nullable();
            $table->tinyInteger('language_id')->unsigned()->nullable();
            $table->string('currency_position',20)->nullable();
            $table->string('input_display_type',50)->nullable();
            $table->string('timezone',20)->nullable();
            $table->string('dateformat',30)->nullable();
            $table->string('price_calculate_type',30)->nullable();
            $table->string('decimal_separate',5)->nullable();
            $table->string('thousand_separate',5)->nullable();
            $table->string('discount_type',25)->nullable();
            $table->tinyInteger('transaction_edit_days')->nullable()->comment('any kind of transaction can edit by given days');
            $table->tinyInteger('default_datatable_list_number')->nullable()->comment('the given number will be show in list');
            $table->string('is_branch',30)->nullable();
            $table->tinyInteger('is_store')->nullable()->comment('1=store can create, 2= store not create, all are depend on branch active');
            $table->string('stock_account_method',25)->nullable()->comment('1=fifo , 2= lifo');
            $table->string('voucher_length',25)->nullable();
            $table->string('product_prefix',25)->nullable();
            $table->string('supplier_prefix',25)->nullable();
            $table->string('customer_prefix',25)->nullable();
            $table->string('purchases_order_prefix',25)->nullable();
            $table->string('purchases_requisition_prefix',25)->nullable();
            $table->string('purchases_prefix',25)->nullable();
            $table->string('account_prefix',25)->nullable();
            $table->string('service_prefix',25)->nullable();
            $table->string('service_quatation_prefix',25)->nullable();
            $table->string('sales_prefix',25)->nullable();
            $table->string('delivery_challans_prefix',25)->nullable();
            $table->string('service_invoice_prefix',25)->nullable();
            $table->string('sales_quatation_prefix',25)->nullable();
            $table->string('payment_voucher_prefix',25)->nullable();
            $table->string('receive_voucher_prefix',25)->nullable();
            $table->string('journal_voucher_prefix',25)->nullable();
            $table->string('purchases_payment_prefix',25)->nullable();
            $table->string('sales_payment_prefix',25)->nullable();
            $table->string('hotel_booking_prefix',25)->nullable();
            $table->string('purchases_mrr_prefix',25)->nullable();
            $table->string('transfer_prefix',25)->nullable();
            $table->string('sales_approval',40)->nullable();
            $table->string('delivery_challan',40)->nullable();
            $table->string('inventory_approval',40)->nullable();
            $table->string('invoice_approval',40)->nullable();
            $table->string('purchases_mrr',40)->nullable();
            $table->string('mrr_approval',40)->nullable();
            $table->string('challan_approval',40)->nullable();
            $table->string('account_approval',40)->nullable();
            $table->string('purchases_return_approval',40)->nullable();
            $table->string('sales_return_approval',40)->nullable();
            $table->string('sales_loan_return_prefix',40)->nullable();
            $table->string('head_prefix',40)->nullable();
            $table->string('account_code',40)->nullable();
            $table->string('sales_pending_cheque_prefix',40)->nullable();
            $table->string('purchases_pending_cheque_prefix',40)->nullable();
            $table->string('contra_voucher_prefix',40)->nullable();
            $table->string('service_invoice_approbal',40)->nullable();

            $table->string('customer_opening_prefix',40)->nullable();
            $table->string('supplier_opening_prefix',40)->nullable();
            $table->string('inventory_opening_prefix',40)->nullable();
            $table->string('inventory_adjust_prefix',40)->nullable();
            $table->string('inventory_adjust_approval',40)->nullable();

            $table->enum('purchases_sms', ['Yes', 'No'])->default('No');
            $table->enum('purchases_email', ['Yes', 'No'])->default('No');
            $table->enum('purchases_download', ['Yes', 'No'])->default('No');
            $table->enum('sales_sms', ['Yes', 'No'])->default('No');
            $table->enum('sales_email', ['Yes', 'No'])->default('No');
            $table->enum('sales_download', ['Yes', 'No'])->default('No');
            $table->enum('account_sms', ['Yes', 'No'])->default('No');
            $table->enum('account_email', ['Yes', 'No'])->default('No');
            $table->enum('account_download', ['Yes', 'No'])->default('No');
            $table->enum('service_sms', ['Yes', 'No'])->default('No');
            $table->enum('service_email', ['Yes', 'No'])->default('No');
            $table->enum('service_download', ['Yes', 'No'])->default('No');

            $table->string('pos_prefix',40)->nullable();
            $table->string('pos_approval',40)->nullable();
            $table->integer('deposit_account_id')->nullable();

            $table->enum('status', ['Approved', 'Inactive', 'Pending', 'Cancel'])->default('Approved')->comment('default status set active , penidng status waiting for approbal');
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
        Schema::dropIfExists('general_setups');
    }
}
