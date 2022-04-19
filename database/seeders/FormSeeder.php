<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(Faker $faker)
    {
        $transactionCategory = array(
            'Journal Voucher',
            'Payment Voucher',
            'Receive Voucher',
            'Purchase Voucher',
            'Sales Voucher',
            'Sales Return',
            'Purchases Return',
            'Customer Payment',
            'Supplier Payment',
            'Transfer In',
            'Transfer Out',
            'Sales Loan',
            'Sales Loan Return',
            'Opening Inventory',
            'Contra Voucher',
            'Inventory Adjustment',
            'Pos Sale',
            'Hotel Booking',

        );
      
       foreach($transactionCategory as $key => $value):
            $form = new Form();
            $form->name = $value;
            $form->updated_by = 1;
            $form->created_by = 1;
            $form->deleted_by = 1;
            $form->save();
       endforeach;

        $formStructure = array(
            'name' => 'forms',
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