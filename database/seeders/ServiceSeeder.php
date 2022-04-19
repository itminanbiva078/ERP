<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Service;
use App\Models\FormInput;
class ServiceSeeder extends Seeder
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
            $service = new Service();
            $service->name = $faker->name;
            $service->company_id = 1;
            $service->service_id = rand(1, 2);
            $service->price = $faker->randomNumber;
            $service->updated_by = 1;
            $service->created_by = 1;
            $service->deleted_by = 1;
            // $service->deleted_at = $faker->dateTime($unixTimestamp);
            $service->save();
        endfor;


        $formStructure =  array(
            'name' => 'services',
            'input_field' => array(
                array(
                    'name' => 'code',
                    'type' => 'text',
                    'class' => 'form-control readonly',
                    'id' => null,
                    'label' => 'Code',
                    'placeholder' => 'Code',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'readonly' =>'readonly',
                    'voucherInfo' => "service_prefix-services",

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
                    'validation' => 'required|unique:services,name|min:2',
                ),
                array(
                    'name' => 'service_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Service Category',
                    'placeholder' => 'Please select category',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                    'foreignTable' => 'service_categories',
                    'customMethod' => null,

                ),
           
                array(
                    'name' => 'price',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Price',
                    'placeholder' => 'Price',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'unique' => false,
                    'inputShow' => true,
                    'validation' => 'required',
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
