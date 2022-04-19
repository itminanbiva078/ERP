<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FiscalYearSeeder extends Seeder
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
        //     $fiscicalYear = new FiscalYear();
        //     $fiscicalYear->branch_id = rand(1, 10);
        //     $fiscicalYear->date = $faker->date;
        //     $fiscicalYear->fiscal_year = $faker->date;
        //     $fiscicalYear->updated_by = 1;
        //     $fiscicalYear->created_by = 1;
        //     $fiscicalYear->deleted_by = 1;
        //     $fiscicalYear->save();
        // endfor;

        $formStructure =  array(
            'name' => 'fiscal_years',
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
                    'validation' => 'required',

                ),
                array(
                    'name' => 'fiscal_year',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Fiscal year',
                    'placeholder' => 'Fiscal year',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',

                ),
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Please type branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
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