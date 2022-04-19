<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;

class SupplierOpeningDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'supplier_opening_details',
            'input_field' => array(
                array(
                    'name' => 'supplier_id',
                    'type' => 'tselect',
                    'class' => 'form-control select2 supplier_id',
                    'id' => null,
                    'label' => 'Supplier',
                    'placeholder' => 'Supplier',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'suppliers',
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
