<?php

namespace Database\Seeders;

use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SupplierOpeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure =  array(
            'name' => 'supplier_openings',
            'input_field' => array(
            
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Date',
                    'placeholder' => 'Date',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'voucher_no',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher No',
                    'placeholder' => 'Voucher No',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'readonly' =>'readonly',
                    'validation' => 'required|max:100|min:2',
                    'voucherInfo' => "supplier_opening_prefix-supplier_openings",
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
