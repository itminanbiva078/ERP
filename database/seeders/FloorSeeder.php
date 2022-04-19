<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {


        $floors = array(
            '1st Floor',
            '2rd Floor',
            '3rd Floor',
            '4th Floor',
            '5th Floor',
            '6th Floor',
            '7th Floor',
            '8th Floor',
            '9th Floor',
            
        );

        
       foreach($floors as $key => $eachFloor):
            $fiscicalYear = new Floor();
            $fiscicalYear->company_id =1;// helper::companyId();
            $fiscicalYear->name = $eachFloor;
            $fiscicalYear->updated_by = 1;
            $fiscicalYear->created_by = 1;
            $fiscicalYear->deleted_by = 1;
            $fiscicalYear->save();
       endforeach;






        $formStructure =  array(
            'name' => 'floors',
            'input_field' => array(
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