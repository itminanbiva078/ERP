<?php

namespace Database\Seeders;

use App\Models\General;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class GeneralSeeder extends Seeder
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
        //     $general = new General();
        //     $general->voucher_id = rand(1, 10);
        //     $general->branch_id = rand(1, 10);
        //     $general->form_id = rand(1, 10);
        //     $general->date = $faker->date;
        //     $general->debit = $faker->creditCardNumber;
        //     $general->credit = $faker->creditCardNumber;
        //     $general->note = $faker->text;
        //     $general->updated_by = 1;
        //     $general->created_by = 1;
        //     $general->deleted_by = 1;
        //     $general->save();
        // endfor;

        $formStructure =  array(
            'name' => 'generals',
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
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
               
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Select Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'branches',
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
                    'unique' => false,
                    'foreignTable' => 'forms',
                    'inputShow' => true,
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
                    'name' => 'note',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Note',
                    'placeholder' => 'Note',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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