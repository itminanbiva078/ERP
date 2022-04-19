<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\ServiceQuatationDetails;
use App\Models\FormInput;

class ServiceQuatationDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp =time();
        for ($i = 0; $i < 2; $i++) :
            $serviceQuatationDetails = new ServiceQuatationDetails();
            $serviceQuatationDetails->company_id = 1;
            $serviceQuatationDetails->service_quatation_id =rand(1,10);
            $serviceQuatationDetails->branch_id =rand(1,10);
            $serviceQuatationDetails->service_id =rand(1,10);
            $serviceQuatationDetails->date = $faker->date;
            $serviceQuatationDetails->total_price = $faker->randomNumber;
            $serviceQuatationDetails->discount = $faker->randomFloat;
            $serviceQuatationDetails->updated_by = 1;
            $serviceQuatationDetails->created_by = 1;
            $serviceQuatationDetails->deleted_by = 1;
            $serviceQuatationDetails->save();
        endfor;
        $formStructure = array(
            'name' => 'service_quatation_details',
            'input_field' => array(
                array(
                    'name' => 'service_id',
                    'type' => 'tsoptionGroup',
                    'class' => 'form-control service_id select2',
                    'id' => null,
                    'label' => 'Service',
                    'placeholder' => 'Type Service',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'services',
                    'customMethod' => null,
                    'validation' => 'required|array|min:1',
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
                    'readonly' => 'readonly',
                    'inputShow' => true,
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
