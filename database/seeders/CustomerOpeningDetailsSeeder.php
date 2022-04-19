<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;

class CustomerOpeningDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'customer_opening_details',
            'input_field' => array(
                array(
                    'name' => 'customer_id',
                    'type' => 'tselect',
                    'class' => 'form-control select2 customer_id',
                    'id' => null,
                    'label' => 'Customer',
                    'placeholder' => 'Customer',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'customers',
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'opening_balance',
                    'type' => 'tnumber',
                    'class' => 'form-control opening_balance decimal',
                    'id' => null,
                    'label' => 'Opening Balance',
                    'placeholder' => 'Opening Balance',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                   
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
