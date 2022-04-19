<?php

namespace Database\Seeders;
use App\Models\Vehicle;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\FormInput;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // for ($i = 0; $i < 2; $i++) :
        //     $vehicles = new Vehicle();
        //     $vehicles->branch_id = rand(1, 10);
        //     $vehicles->brand = $faker->name;
        //     $vehicles->year = $faker->date;
        //     $vehicles->registration_no = $faker->randomFloat;
        //     $vehicles->chassis_no = $faker->randomFloat;
        //     $vehicles->status = 1;
        //     $vehicles->updated_by = 1;
        //     $vehicles->created_by = 1;
        //     $vehicles->deleted_by = 1;
        //     $vehicles->save();
        // endfor;

        $formStructure =  array(
            'name' => 'vehicles',
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
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'required',

                ),
            
                array(
                    'name' => 'brand',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Brand',
                    'placeholder' => 'Brand',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'year',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Date',
                    'placeholder' => 'Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'registration_no',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Registration Number',
                    'placeholder' => 'Registration Number',
                    'value' => null,
                    'unique' => false,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|max:200',
                ),
                array(
                    'name' => 'chassis_no',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Chassis No',
                    'placeholder' => 'Chassis No',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => true,
                    'validation' => 'nullable|max:200',

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

