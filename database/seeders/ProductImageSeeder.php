<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $formStructure = array(
            'name' => 'product_images',
            'input_field' => array(
                array(
                    'name' => 'product_id',
                    'type' => 'select2',
                    'class' => 'form-control product_id',
                    'id' => null,
                    'label' => 'Product ',
                    'placeholder' => 'Product',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'image',
                    'type' => 'file',
                    'class' => 'form-control image',
                    'id' => null,
                    'label' => 'Image',
                    'placeholder' => 'Select Image',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
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
