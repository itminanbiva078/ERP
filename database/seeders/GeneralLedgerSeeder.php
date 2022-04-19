<?php

namespace Database\Seeders;

use App\Models\GeneralLedger;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\FormInput;

class GeneralLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // for ($i = 0; $i < 2; $i++) :
        //     $generalLedger = new GeneralLedger();
        //     $generalLedger->general_id = rand(1, 10);
        //     $generalLedger->form_id = rand(1, 10);
        //     $generalLedger->account_id = rand(1, 10);
        //     $generalLedger->date = $faker->date;
        //     $generalLedger->debit = $faker->creditCardNumber;
        //     $generalLedger->credit = $faker->creditCardNumber;
        //     $generalLedger->memo = $faker->text;
        //     $generalLedger->updated_by = 1;
        //     $generalLedger->created_by = 1;
        //     $generalLedger->deleted_by = 1;
        //     $generalLedger->save();
        // endfor;

        
        $formStructure =  array(
            'name' => 'general_ledgers',
            'input_field' => array(
               array(
                    'name' => 'general_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Select Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'generals',
                    'customMethod' => null,
                ),
               
                array(
                    'name' => 'form_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'forms',
                    'customMethod' => null,
                ),
                array(
                    'name' => 'account_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'chart_of_accounts',
                    'customMethod' => null,
                ),
                array(
                    'name' => 'debit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Debit',
                    'placeholder' => 'Debit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'credit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Credit',
                    'placeholder' => 'Credit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'memo',
                    'type' => 'textarea',
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