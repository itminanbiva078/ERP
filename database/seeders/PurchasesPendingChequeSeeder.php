<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;

class PurchasesPendingChequeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'purchases_pending_cheques',
            'input_field' => array(
                array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Payment Status',
                    'placeholder' => 'Select Check Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),
               
                array(
                    'name' => 'receive_date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Receive Date',
                    'placeholder' => 'Receive Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'cheque_date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Cheque Date',
                    'placeholder' => 'Cheque Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'deposit_date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Deposit Date',
                    'placeholder' => 'Deposit Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'voucher_no',
                    'type' => 'rtext',
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
                    'voucherInfo' => "purchases_payment_prefix-purchases_pending_cheques",
                ),

                array(
                    'name' => 'voucher_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Voucher Number',
                    'placeholder' => 'Voucher Number',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'purchases',
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
                    'inputShow' => false,
                    'foreignTable' => 'suppliers',
                    'customMethod' => null,
                    'validation' => 'nullable',
                    
                ),

                array(
                    'name' => 'form_id',
                    'type' => 'select',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher Type.',
                    'placeholder' => 'Voucher Type.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
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
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Cheque Number',
                    'placeholder' => 'Cheque Number',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'payment',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Payment',
                    'placeholder' => 'Payment',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'note',
                    'type' => 'textarea',
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
                
               
            )
        );
        $formInfo = new FormInput();
        $formInfo->navigation_id = null;
        $formInfo->table = $formStructure['name'];
        $formInfo->input = json_encode($formStructure['input_field']);
        $formInfo->save();
    }
}
