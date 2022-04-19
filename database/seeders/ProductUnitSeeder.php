<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        for ($i = 1; $i < 3; $i++) :
            $productUnit = new ProductUnit();
            $productUnit->company_id = 1;
            $productUnit->name = 'Unit '.$i;
            $productUnit->updated_by = 1;
            $productUnit->created_by = 1;
            $productUnit->deleted_by = 1;
            $productUnit->save();
        endfor;
        $formStructure = array(
            'name' => 'product_units',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Unit Name',
                    'placeholder' => 'Unit Name',
                    'value' => null,
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|min:2|unique:product_units,name',
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