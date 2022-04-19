<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\ProductSummary;
use App\Models\FormInput;

class ProductSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       
        // $unixTimestamp =time();
        // for ($i = 0; $i < 2; $i++) :
        //     $productSummary = new ProductSummary();
        //     $productSummary->branch_id =rand(1,10);
        //     $productSummary->product_id =rand(1,10);
        //     $productSummary->total_purchases = $faker->randomNumber;
        //     $productSummary->total_sales = $faker->randomNumber;
        //     $productSummary->current_stock = $faker->randomNumber;
        //     $productSummary->updated_by = 1;
        //     $productSummary->created_by = 1;
        //     $productSummary->deleted_by = 1;
        //     $productSummary->save();
        // endfor;
        $formStructure = array(
            'name' => 'product_summaries',
            'input_field' => array(
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
                    'validation' => 'required',
                ),
                array(
                    'name' => 'product_id',
                    'type' => 'tselect',
                    'class' => 'form-control product_id select2',
                    'id' => null,
                    'label' => 'Product',
                    'placeholder' => 'Type Product',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'products',
                    'customMethod' => null,
                    'validation' => 'required|array|min:1',
                ),

                array(
                    'name' => 'total_purchases',
                    'type' => 'number',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Purchases',
                    'placeholder' => 'Total Purchases',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'total_sales',
                    'type' => 'number',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Sales',
                    'placeholder' => 'Total Sales',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'current_stock',
                    'type' => 'number',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Current Stock',
                    'placeholder' => 'Current Stock',
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
