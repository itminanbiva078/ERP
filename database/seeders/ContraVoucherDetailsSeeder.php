<?php

namespace Database\Seeders;
use App\Models\FormInput;

use Illuminate\Database\Seeder;

class ContraVoucherDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        $formStructure =  array(
            'name' => 'contra_voucher_details',
            'input_field' => array(
            
                array(
                    'name' => 'debit_id',
                    'type' => 'toptionGroup',
                    'class' => 'form-control debit_id select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'debit',
                    'type' => 'tnumber',
                    'class' => 'form-control debit decimal',
                    'id' => null,
                    'label' => 'Debit',
                    'placeholder' => '0.00',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'credit',
                    'type' => 'tnumber',
                    'class' => 'form-control credit decimal',
                    'id' => null,
                    'label' => 'Credit',
                    'placeholder' => '0.00',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'memo',
                    'type' => 'ttext',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Memo',
                    'placeholder' => 'Memo',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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
