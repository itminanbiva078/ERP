<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Brand;
use App\Models\FormInput;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       
        for ($i = 1; $i < 3; $i++) :
            $brand = new Brand();
            $brand->company_id = 1;
            $brand->name = 'Brand'.$i;
            $brand->updated_by = 1;
            $brand->created_by = 1;
            $brand->deleted_by = 1;
            // $brand->deleted_at = $faker->dateTime($unixTimestamp);
            $brand->save();
        endfor;
        $formStructure =  array(
            'name' => 'brands',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Brand Name',
                    'placeholder' => 'Brand Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => true,
                    'validation' => 'required|min:2|unique:brands,name',
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
                    'foreignTable' => 'statuses',
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