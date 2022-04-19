<?php

namespace Database\Seeders;

use App\Models\Transpfer;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\FormInput;

class TranspferSeeder extends Seeder
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
        //     $transfer = new Transpfer();
        //     $transfer->date = $faker->date;
        //     $transfer->voucher_no = $faker->randomNumber;
        //     $transfer->from_branch_id = rand(1, 10);
        //     $transfer->from_store_id = rand(1, 10);
        //     $transfer->to_branch_id = rand(1, 10);
        //     $transfer->to_store_id = rand(1, 10);
        //     $transfer->total_quantity = $faker->randomNumber;
        //     $transfer->total_price = $faker->randomNumber;
        //     $transfer->updated_by = 1;
        //     $transfer->created_by = 1;
        //     $transfer->deleted_by = 1;
        //     $transfer->save();
        // endfor;

        $formStructure =  array(
            'name' => 'transpfers',
            'input_field' => array(

                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Transfer Date',
                    'placeholder' => 'Transfer Date',
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
                    'voucherInfo' => "transfer_prefix-transpfers",
                ),
              
                array(
                    'name' => 'from_branch_id',
                    'type' => 'select',
                    'class' => 'form-control from_branch branch_id select2',
                    'id' => null,
                    'label' => 'From Branch',
                    'placeholder' => 'Select Branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'from_store_id',
                    'type' => 'select',
                    'class' => 'form-control from_store store_id select2',
                    'id' => null,
                    'label' => 'From Store',
                    'placeholder' => 'Select Store',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'stores',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'to_branch_id',
                    'type' => 'select',
                    'class' => 'form-control to_branch select2',
                    'id' => null,
                    'label' => 'To Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
             
              
                
                array(
                    'name' => 'to_store_id',
                    'type' => 'select',
                    'class' => 'form-control to_store select2',
                    'id' => null,
                    'label' => 'To Store',
                    'placeholder' => 'Please select Store',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'stores',
                    'customMethod' => null,
                    'validation' => 'required',
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
                    'name' => 'total_quantity',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Quantity',
                    'placeholder' => 'Total Quantity',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),

                array(
                    'name' => 'total_price',
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