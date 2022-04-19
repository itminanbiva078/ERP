<?php

namespace Database\Seeders;
use Faker\Generator as Faker;
use App\Models\SalesQuatation;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class SalesQuatationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp =time();
        for ($i = 0; $i < 2; $i++) :
            $salesQuatation = new SalesQuatation();
            $salesQuatation->date =$faker->date;
            $salesQuatation->company_id = 1;
            $salesQuatation->customer_id = rand(1,10);
            $salesQuatation->branch_id =  rand(1,10);
            $salesQuatation->voucher_no = rand(1,4);//$faker->city;
            $salesQuatation->subtotal = $faker->randomFloat;
            $salesQuatation->discount = $faker->randomFloat;
            $salesQuatation->grand_total =  $faker->randomFloat;
            $salesQuatation->note = 'default note';
            $salesQuatation->updated_by = 1;
            $salesQuatation->created_by = 1;
            $salesQuatation->deleted_by = 1;
            $salesQuatation->save();
        endfor;


        $formStructure =  array(
            'name' => 'sales_quatations',
            'input_field' => array(
                   array(
                    'name' => 'quatation_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' =>  'Quatation Status',
                    'placeholder' => 'Select Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'validation' => 'nullable',
                ),
                   array(
                    'name' => 'sales_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Sales Status',
                    'placeholder' => 'Select Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Quatation Date',
                    'placeholder' => 'Quatation Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
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
                    'voucherInfo' => "sales_quatation_prefix-sales_quatations",
                ),
                array(
                    'name' => 'customer_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Customer',
                    'placeholder' => 'Select Customer',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'customers',
                    'customMethod' => null,
                    'validation' => 'required',
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'salesSetup.customer.store.ajax',
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
                    'inputShow' => false,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'nullable',
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
                    'name' => 'subtotal',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Subtotal',
                    'placeholder' => 'Subtotal',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
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
