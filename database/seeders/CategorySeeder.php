<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       
        for ($i = 1; $i < 3; $i++) :
            $category = new  Category();
            $category->company_id = 1;
            $category->name = 'Category '.$i;
            $category->parent_id = rand(1, 2);
            $category->priority = rand(01, 99);
            $category->updated_by = 1;
            $category->created_by = 1;
            $category->deleted_by = 1;
            // $category->deleted_at = $faker->dateTime($unixTimestamp);
            $category->save();
        endfor;


        $formStructure =  array(
            'name' => 'categories',
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
                    'unique' => false,
                    'inputShow' => true,
                    'foreignTable' => 'categories',
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
                    'name' => 'priority',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Priority',
                    'placeholder' => 'Priyority',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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