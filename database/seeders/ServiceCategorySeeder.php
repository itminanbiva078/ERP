<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\ServiceCategory;
use App\Models\FormInput;
class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
        $unixTimestamp = time();
        for ($i = 0; $i < 2; $i++) :
            $serviceCategory = new  ServiceCategory();
            $serviceCategory->name = $faker->name;
            $serviceCategory->company_id = 1;
            $serviceCategory->parent_id = rand(1, 2);
            $serviceCategory->updated_by = 1;
            $serviceCategory->created_by = 1;
            $serviceCategory->deleted_by = 1;
            $serviceCategory->save();
        endfor;


        $formStructure =  array(
            'name' => 'service_categories',
            'input_field' => array(
               
                array(
                    'name' => 'parent_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Parent Category',
                    'placeholder' => 'Please type parent category',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'service_categories',
                    'customMethod' => null,


                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Name',
                    'placeholder' => 'Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
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
