<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormInput;

class SubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'subscribes',
            'input_field' => array(
               
                array(
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'table' => 'subscribes',
                    'inputShow' => true,
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'validation' => 'required|email|unique:subscribes,email',
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
