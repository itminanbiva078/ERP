<?php

namespace Database\Seeders;
use App\Models\FormInput;

use Illuminate\Database\Seeder;

class ContraVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'contra_vouchers',
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
                    'voucherInfo' => "contra_voucher_prefix-contra_vouchers",
                ),
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
                    'name' => 'debit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Debit',
                    'placeholder' => 'Debit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
                ),
                array(
                    'name' => 'credit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Credit',
                    'placeholder' => 'Credit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
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
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'salesSetup.customer.store.ajax',
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
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
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
