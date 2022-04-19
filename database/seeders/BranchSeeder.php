<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       
      
            $branch = new Branch();
            $branch->company_id = 1;
            $branch->name = 'Dhaka';
            $branch->email = $faker->email;
            $branch->phone = '01711111111';
            $branch->address = $faker->address;
            $branch->is_default = "Yes";
            $branch->updated_by = 1;
            $branch->created_by = 1; 
            $branch->save();



            $branch = new Branch();
            $branch->company_id = 1;
            $branch->name = 'Chittagong';
            $branch->email = $faker->email;
            $branch->phone = '01711112365';
            $branch->address = $faker->address;
            $branch->is_default = "Yes";
            $branch->updated_by = 1;
            $branch->created_by = 1; 
            $branch->save();
       

        $formStructure =   array(
            'name' => 'branches',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Name',
                    'placeholder' => 'Name',
                    'value' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'required' => null,
                    'validation' => 'required|max:100|min:2',
                ),

                array(
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'table' => 'branches',
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|email|unique:branches,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'branches',
                    'unique' => true,
                    'required' => null,
                    'tableshow' => true,
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

                array(
                    'name' => 'is_default',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'is Default Branch',
                    'placeholder' => 'is Default Branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getSetupData(14)',
                    'validation' => 'nullable',

                ),
                array(
                    'name' => 'address',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Address',
                    'placeholder' => 'Address',
                    'value' => null,
                    'required' => null,
                    'rows' => 0,
                    'cols' => 0,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable|max:200',
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
