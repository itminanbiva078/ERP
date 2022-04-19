<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;

class SalePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'sale_payments',
            'input_field' => array(
                array(
                    'name' => 'date',
                    'type' => 'rdate',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Payment Date',
                    'placeholder' => 'Payment Date',
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
                    'voucherInfo' => "sales_payment_prefix-sale_payments",
                ),
                array(
                    'name' => 'customer_id',
                    'type' => 'rselect',
                    'class' => 'form-control select2 customer_id',
                    'id' => null,
                    'label' => 'Customer',
                    'placeholder' => 'Select Customer',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'customers',
                    'customMethod' => null,
                    'validation' => 'required',
                    
                ),
                array(
                    'name' => 'collection_type',
                    'type' => 'rselect',
                    'class' => 'form-control select2 collection_type ',
                    'id' => null,
                    'label' => ' Collection Type',
                    'placeholder' => 'Please select Collection Type',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getSetupData(22)',
                    'validation' => 'required',
                ),
                array(
                    'name' => 'payment_type',
                    'type' => 'rselect',
                    'class' => 'form-control select2 payment_type ',
                    'id' => null,
                    'label' => 'Payment Type',
                    'placeholder' => 'Please select Payment Type',
                    'value' => "Credit",
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getCashAndBankPaymentType()',
                    'validation' => 'required',
                ),
                array(
                    'name' => 'account_id',
                    'type' => 'roptionGroup',
                    'class' => 'form-control select2 account_id ',
                    'id' => null,
                    'label' => 'Account Head',
                    'placeholder' => 'Please Select Account Head',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable',
                ),
               
                array(
                    'name' => 'bank_id',
                    'type' => 'rselect',
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
                    'type' => 'rtext',
                    'class' => 'form-control cheque_number',
                    'id' => null,
                    'hideDiv' => 'hide',
                    'label' => 'Cheque Number',
                    'placeholder' => 'Cheque Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'cheque_date',
                    'type' => 'cheque_date',
                    'class' => 'form-control cheque_date',
                    'id' => null,
                    'label' => 'Cheque Date',
                    'placeholder' => 'Cheque Date',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'branch_id',
                    'type' => 'rselect',
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
                    'name' => 'documents',
                    'type' => 'rfile',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Document Upload',
                    'placeholder' => 'Document Upload',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                    'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name' => 'credit',
                    'type' => 'rtext',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Payment',
                    'placeholder' => 'Total Payment',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'unique' => false,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
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
