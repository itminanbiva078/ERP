<?php

namespace Database\Seeders;

use App\Models\CustomerMedia;
use App\Models\FormInput;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class CustomerMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
         // $unixTimestamp = time();
         for ($i = 0; $i < 2; $i++) :
            $customerMedia = new CustomerMedia();
            $customerMedia->name = $faker->company;
            $customerMedia->company_id = 1;
            $customerMedia->updated_by = 1;
            $customerMedia->created_by = 1;
            $customerMedia->deleted_by = 1;
            // $brand->deleted_at = $faker->dateTime($unixTimestamp);
            $customerMedia->save();
        endfor;


        $formStructure =  array(
            'name' => 'customer_media',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Customer Media Name',
                    'placeholder' => 'Customer Media Name',
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
