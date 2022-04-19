<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\SalesDetails;
use App\Models\FormInput;
class SalesDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $formStructure = array(
            'name' => 'sales_details',
            'input_field' => array(
                array(
                    'name' => 'product_id',
                    'type' => 'tpoptionGroup',
                    'class' => 'form-control product_id select2 sproduct_id',
                    'id' => null,
                    'label' => 'Product',
                    'placeholder' => 'Type Product',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'products',
                    'customMethod' => "getStockExitsProductList()",
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'batch_no',
                    'type' => 'tselect',
                    'class' => 'form-control batch_no select2',
                    'id' => null,
                    'label' => 'Batch',
                    'placeholder' => 'Batch No',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                    'customMethod' => "getActiveBatch()",
                ),
                array(
                    'name' => 'pack_size',
                    'type' => 'tnumber',
                    'class' => 'form-control pack_size decimal',
                    'id' => null,
                    'label' => 'Pack Size',
                    'placeholder' => 'Pack Size',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                ),
                array(
                    'name' => 'pack_no',
                    'type' => 'tnumber',
                    'class' => 'form-control pack_no decimal',
                    'id' => null,
                    'label' => 'Pack No.',
                    'placeholder' => 'Pack No.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                ),
                array(
                    'name' => 'quantity',
                    'type' => 'tnumber',
                    'class' => 'form-control quantity decimal',
                    'id' => null,
                    'label' => 'Quantity',
                    'placeholder' => 'Quantity',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'unit_price',
                    'type' => 'tnumber',
                    'class' => 'form-control unit_price decimal',
                    'id' => null,
                    'label' => 'Unit Price',
                    'placeholder' => 'Unit Price',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'total_price',
                    'type' => 'tnumber',
                    'class' => 'form-control total_price decimal',
                    'id' => null,
                    'label' => 'Total Price',
                    'placeholder' => 'Total Price',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'readonly' => 'readonly',
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
