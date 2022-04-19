<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class StockSeeder extends Seeder
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
        //     $stock = new Stock();
        //     $stock->date = $faker->date;
        //     $stock->general_id = rand(1, 10);
        //     $stock->branch_id = rand(1, 10);
        //     $stock->store_id = rand(1, 10);
        //     $stock->product_id = rand(1, 10);
        //     $stock->quantity = rand(1, 10);
        //     $stock->unit_price = $faker->randomNumber;
        //     $stock->total_price = $faker->randomNumber;
        //     $stock->updated_by = 1;
        //     $stock->created_by = 1;
        //     $stock->deleted_by = 1;
        //     $stock->save();
        // endfor;
        $formStructure = array(
            'name' => 'stocks',
            'input_field' => array(
                array(
                    'name' => 'general_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'generals',
                    'customMethod' => null,
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
                    'inputShow' => true,
                    'foreignTable' => 'stores',
                    'customMethod' => null,
                ),
                array(
                    'name' => 'product_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Select Product',
                    'placeholder' => 'Please select Product',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'products',
                    'customMethod' => null,
                ),
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Date',
                    'placeholder' => 'Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,

                ),
                array(
                    'name' => 'unit_pirce',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Unit Pirce',
                    'placeholder' => 'Unit Pirce',
                    'value' => null,
                    'required' => null,
                    'validation' => 'required',
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,

                ),
                array(
                    'name' => 'total_price',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Price',
                    'placeholder' => 'Total Price',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,


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
                    'inputShow' => true,
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