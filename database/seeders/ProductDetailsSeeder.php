<?php

namespace Database\Seeders;

use App\Models\ProductDetails;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $formStructure =  array(
            'name' => 'product_details',
            'input_field' => array(
                array(
                    'name' => 'number_of_bed',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Number Of Bed',
                    'placeholder' => 'Number Of Bed',
                    'value' => null,
                     'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:1',
                ),
                array(
                    'name' => 'advance_percentage',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Advance Percentage',
                    'placeholder' => 'Advance Percentage',
                    'value' => 50,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:1',
                ),
                array(
                    'name' => 'room_no',
                    'type' => 'text',
                    'class' => 'form-control decimal',
                    'id' => null,
                    'label' => 'Room No',
                    'placeholder' => 'Room No',
                    'value' => null,
                     'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:5000|min:1',
                ),
                array(
                    'name' => 'number_of_room',
                    'type' => 'text',
                    'class' => 'form-control decimal',
                    'id' => null,
                    'label' => 'Number Of Person',
                    'placeholder' => 'Number Of Person',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'floor_id',
                    'type' => 'select',
                    'class' => 'form-control select2 floor_id',
                    'id' => null,
                    'label' => 'Floor No',
                    'placeholder' => 'Floor No',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'floors',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'product_attributes',
                    'type' => 'smultiple',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Product Attribute',
                    'placeholder' => 'Please select product type',
                    'value' => null,
                    'required' => null,
                    'hideDiv' => 'hide',
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                    'foreignTable' => null,
                    'customMethod' => 'getSetupData(13)',
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
