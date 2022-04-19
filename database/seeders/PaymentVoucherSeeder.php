<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentVoucher;
use App\Models\FormInput;
use Faker\Generator as Faker;
class PaymentVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // for ($i = 0; $i < 2; $i++) :
        //     $paymentVoucher = new PaymentVoucher();
        //     $paymentVoucher->voucher_no = rand(1, 10);
        //     $paymentVoucher->branch_id = rand(1, 10);
        //     $paymentVoucher->date = $faker->date;
        //     $paymentVoucher->debit = $faker->creditCardNumber;
        //     $paymentVoucher->credit = $faker->creditCardNumber;
        //     $paymentVoucher->note = $faker->text;
        //     $paymentVoucher->updated_by = 1;
        //     $paymentVoucher->created_by = 1;
        //     $paymentVoucher->deleted_by = 1;
        //     $paymentVoucher->save();
        // endfor;

        $formStructure =  array(
            'name' => 'payment_vouchers',
            'input_field' => array(
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Date',
                    'placeholder' => 'Date',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'voucher_no',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher No.',
                    'placeholder' => 'Voucher No.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                    'readonly' => 'readonly',
                    'voucherInfo' => "payment_voucher_prefix-payment_vouchers",
                ),
                // array(
                //     'name' => 'payment_type',
                //     'type' => 'select',
                //     'class' => 'form-control select2 payment_type',
                //     'id' => null,
                //     'label' => 'Select Type',
                //     'placeholder' => 'Please select Type',
                //     'value' => null,
                //     'required' => null,
                //     'tableshow' => true,
                //     'inputShow' => true,
                //     'unique' => false,
                //     'foreignTable' => null,
                //     'customMethod' => 'getSetupData(7)',
                // ),

                array(
                    'name' => 'account_type_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Select Type',
                    'placeholder' => 'Please select Type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'account_types',
                    'customMethod' => null,  
                ),
                array(
                    'name' => 'documents',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Document Upload',
                    'placeholder' => 'Document Upload',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name' => 'miscellaneous',
                    'type' => 'text',
                    'class' => 'form-control miscellaneous',
                    'id' => null,
                    'label' => 'Miscellaneous Info',
                    'placeholder' => 'Type Misecellaneous info',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'supplier_id',
                    'type' => 'select',
                    'class' => 'form-control select2 supplier_id',
                    'id' => null,
                    'label' => 'Select Supplier',
                    'placeholder' => 'Please select Type',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'suppliers',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.supplier.store.ajax',
                ),

                array(
                    'name' => 'customer_id',
                    'type' => 'select',
                    'class' => 'form-control select2 customer_id',
                    'id' => null,
                    'label' => 'Select Customer',
                    'placeholder' => 'Please select Customer',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'customers',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'salesSetup.customer.store.ajax',
                ),
                array(
                    'name' => 'credit_id',
                    'type' => 'optionGroup',
                    'class' => 'form-control select2 credit_id',
                    'id' => null,
                    'label' => 'Select Account (CR)',
                    'placeholder' => 'Please select Account',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => null,
                    
                ),

                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Select Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                ),

                array(
                    'name' => 'note',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Note',
                    'placeholder' => 'Note',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
                ),
                array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Status',
                    'placeholder' => 'Select Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',

                ),
            )
        );

        $formInfo = new FormInput();
        $formInfo->navigation_id = null;
        $formInfo->table = $formStructure['name'];
        $formInfo->input = json_encode($formStructure['input_field']);
        $formInfo->save();
    }
}
