<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

       
        $store = new Store();
        $store->name = 'Dhaka Store 1';
        $store->branch_id = 1;
        $store->email = $faker->email;
        $store->phone = $faker->PhoneNumber;
        $store->address = $faker->address;
        $store->company_id = 1;
        $store->is_default = "Yes";
        $store->updated_by = 1;
        $store->created_by = 1;
        $store->save();

        $store = new Store();
        $store->name = 'Dhaka Store 2';
        $store->branch_id = 1;
        $store->email = $faker->email;
        $store->phone = $faker->PhoneNumber;
        $store->address = $faker->address;
        $store->company_id = 1;
        $store->is_default = "Yes";
        $store->updated_by = 1;
        $store->created_by = 1;
        $store->save();




        $store = new Store();
        $store->name = 'Chittagong Store 1';
        $store->branch_id = 2;
        $store->email = $faker->email;
        $store->phone = $faker->PhoneNumber;
        $store->address = $faker->address;
        $store->company_id = 1;
        $store->is_default = "Yes";
        $store->updated_by = 1;
        $store->created_by = 1;
        $store->save();

        $store = new Store();
        $store->name =  'Chittagong Store 2';
        $store->branch_id = 2;
        $store->email = $faker->email;
        $store->phone = $faker->PhoneNumber;
        $store->address = $faker->address;
        $store->company_id = 1;
        $store->is_default = "Yes";
        $store->updated_by = 1;
        $store->created_by = 1;
        $store->save();

        
       
        $formStructure =   array(
            'name' => 'stores',
            'input_field' => array(
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Please type branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
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
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
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
                    'table' => 'stores',
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|email|unique:stores,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'stores',
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
                    'label' => 'is Default Store',
                    'placeholder' => 'is Default Store',
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