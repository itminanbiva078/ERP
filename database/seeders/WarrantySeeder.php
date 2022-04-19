<?php

namespace Database\Seeders;

use App\Models\FormInput;
use App\Models\Warranty;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp = time();
        for ($i = 0; $i < 2; $i++) :
            $warranty = new Warranty();
            $warranty->name = $faker->name;
            $warranty->description = "dsds";
            $warranty->duration = "2 Year";
            $warranty->duration_type = "Fixed";
            $warranty->updated_by = 1;
            $warranty->created_by = 1;
            $warranty->deleted_by = 1;
            $warranty->save();
        endfor;

        $formStructure = array(
            'name' => 'warranties',
            'input_field' => array(
               array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Warranty Name',
                    'placeholder' => 'Warranty Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'description',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Description',
                    'placeholder' => 'Description',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'duration',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Duration',
                    'placeholder' => 'Duration',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100',
                ),
                array(
                    'name' => 'duration_type',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Duration Type',
                    'placeholder' => 'Duration Type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',

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
                    'foreignTable' => 'statuses',
                    'inputShow' => true,
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
