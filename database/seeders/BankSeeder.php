<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\FormInput;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      
        for ($i = 1; $i < 3; $i++) :
            $bank = new Bank();
            $bank->account_id =9;// $faker->name;
            $bank->bank_name = 'Bank '.$i;
            $bank->account_name = $faker->company;
            $bank->account_number = $faker->bankAccountNumber;
            $bank->branch = $faker->name;
            $bank->updated_by = 1;
            $bank->created_by = 1;
            $bank->deleted_by = 1;
            $bank->save();
        endfor;

        $formStructure = array(
            'name' => 'banks',
            'input_field' => array(
               array(
                    'name' => 'bank_name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Bank Name',
                    'placeholder' => 'Bank Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'account_name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Account Name',
                    'placeholder' => 'Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'account_number',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Account Number',
                    'placeholder' => 'Account Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100',
                ),
                array(
                    'name' => 'branch',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',

                ),
                array(
                    'name' => 'account_id',
                    'type' => 'optionGroup',
                    'class' => 'form-control select2 account_id ',
                    'id' => null,
                    'label' => 'Account Head',
                    'placeholder' => 'Please Select Account Head',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable',
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