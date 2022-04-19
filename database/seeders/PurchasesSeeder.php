<?php

namespace Database\Seeders;

use App\Models\Purchases;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PurchasesSeeder extends Seeder
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
        //     $purches = new Purchases();
        //     $purches->date = $faker->date;
        //     $purches->supplier_id = rand(1, 10);
        //     $purches->branch_id =  rand(1, 10);
        //     $purches->purchases_order_id =  rand(1, 10);
        //     $purches->voucher_no = rand(1, 4); //$faker->city;
        //     $purches->payment_type = 1;
        //     $purches->account_id = 1;
        //     $purches->subtotal = $faker->randomFloat;
        //     $purches->discount = $faker->randomFloat;
        //     $purches->grand_total =  $faker->randomFloat;
        //     $purches->loder = rand(1, 4);
        //     $purches->transportation = rand(1, 4); //$faker->city;
        //     $purches->paid_amount = rand(1, 4); //$faker->country;
        //     $purches->due_amount = $faker->randomFloat;
        //     $purches->status = 1;
        //     $purches->updated_by = 1;
        //     $purches->created_by = 1;
        //     $purches->deleted_by = 1;
        //     $purches->save();
        // endfor;
        $formStructure =  array(
            'name' => 'purchases',
            'input_field' => array(
                array(
                    'name' => 'purchases_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Payment Status',
                    'placeholder' => 'Select Payment Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'payment_statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'mrr_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'MRR Status',
                    'placeholder' => 'Select MRR Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'payment_statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),

                array(
                    'name' => 'supplier_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Supplier',
                    'placeholder' => 'Select Supplier',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'suppliers',
                    'customMethod' => null,
                    'validation' => 'required',
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.supplier.store.ajax',
                ),
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Purchases Date',
                    'placeholder' => 'Purchases Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
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
                    'voucherInfo' => "purchases_prefix-purchases",
                ),

                array(
                    'name' => 'voucher_reference',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher Reference.',
                    'placeholder' => 'Voucher Reference.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable',
                ),

                array(
                    'name' => 'purchases_order_id',
                    'type' => 'smultiple',
                    'class' => 'form-control select2 purchases_order_id',
                    'id' => null,
                    'label' => 'Purchases Order',
                    'placeholder' => 'Please select Purchases Order',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getOrderList()',
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'store_id',
                    'type' => 'select',
                    'class' => 'form-control select2 store_id',
                    'id' => null,
                    'label' => 'Store',
                    'placeholder' => 'Please select Store',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => false,
                    'foreignTable' => "stores",
                    'customMethod' => null,
                    'validation' => 'nullable',
                   ),
                array(
                    'name' => 'payment_type',
                    'type' => 'select',
                    'class' => 'form-control select2 payment_type',
                    'id' => null,
                    'label' => 'Payment Type',
                    'placeholder' => 'Please select Payment Type',
                    'value' => "Credit",
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getPaymentType()',
                    'validation' => 'required',
                ),

                array(
                    'name' => 'bank_id',
                    'type' => 'select',
                    'class' => 'form-control bank_id select2 hide',
                    'id' => null,
                    'label' => 'Select Bank',
                    'placeholder' => 'Please select Bank',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'hideDiv' => 'hide',
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' =>'getBankInfo()',
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'cheque_number',
                    'type' => 'text',
                    'class' => 'form-control cheque_number',
                    'id' => null,
                    'hideDiv' => 'hide',
                    'label' => 'Cheque Number',
                    'placeholder' => 'Cheque Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'cheque_date',
                    'type' => 'date',
                    'class' => 'form-control cheque_date',
                    'id' => null,
                    'label' => 'Cheque Date',
                    'placeholder' => 'Cheque Date',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),

                array(
                    'name' => 'account_id',
                    'type' => 'optionGroup',
                    'class' => 'form-control select2 account_id ',
                    'id' => null,
                    'label' => 'Account Head',
                    'placeholder' => 'Please Select Account Head',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'hideDiv' => 'hide',
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable',
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
                    'name' => 'subtotal',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Subtotal',
                    'placeholder' => 'Subtotal',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'discount',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Discount',
                    'placeholder' => 'Discount',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'grand_total',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total',
                    'placeholder' => 'Total',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'total_qty',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Quantity',
                    'placeholder' => 'Subtotal',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'loder',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Loder',
                    'placeholder' => 'Loder',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'transportation',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Transportation',
                    'placeholder' => 'Transportation',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'paid_amount',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Paid Amount',
                    'placeholder' => 'Paid Amount',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'due_amount',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Due Amount',
                    'placeholder' => 'Due Amount',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
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