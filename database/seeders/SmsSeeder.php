<?php

namespace Database\Seeders;
use Faker\Generator as Faker;
use App\Models\Sms;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class SmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // $sms = new Sms();
        // $sms->company_id = rand(1, 10);
        // $sms->sms_body = $faker->email;
        // $sms->updated_by = 1;
        // $sms->created_by = 1;
        // $sms->deleted_by = 1;
        // // $sms->deleted_at = $faker->dateTime($unixTimestamp);
        // $sms->save();
       


        $formStructure = array(
            'name' => 'sms',
            'input_field' => array(


                array(
                    'name' => 'sms_type',
                    'type' => 'select',
                    'class' => 'form-control select2 sms_type',
                    'id' => null,
                    'label' => 'Type',
                    'placeholder' => 'Type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                    
                ),

                
                array(
                    'name' => 'user_phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone Number',
                    'placeholder' => 'Phone Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',

                ),

                array(
                    'name' => 'sms_body',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'SMS Body',
                    'placeholder' => 'SMS Body',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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
