<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $divisions = array(
            array('id' => '1', 'name' => 'Chattagram', 'bn_name' => 'চট্টগ্রাম', 'url' => 'www.chittagongdiv.gov.bd'),
            array('id' => '2', 'name' => 'Rajshahi', 'bn_name' => 'রাজশাহী', 'url' => 'www.rajshahidiv.gov.bd'),
            array('id' => '3', 'name' => 'Khulna', 'bn_name' => 'খুলনা', 'url' => 'www.khulnadiv.gov.bd'),
            array('id' => '4', 'name' => 'Barisal', 'bn_name' => 'বরিশাল', 'url' => 'www.barisaldiv.gov.bd'),
            array('id' => '5', 'name' => 'Sylhet', 'bn_name' => 'সিলেট', 'url' => 'www.sylhetdiv.gov.bd'),
            array('id' => '6', 'name' => 'Dhaka', 'bn_name' => 'ঢাকা', 'url' => 'www.dhakadiv.gov.bd'),
            array('id' => '7', 'name' => 'Rangpur', 'bn_name' => 'রংপুর', 'url' => 'www.rangpurdiv.gov.bd'),
            array('id' => '8', 'name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ', 'url' => 'www.mymensinghdiv.gov.bd')
        );
        $unixTimestamp = time();
        foreach ($divisions as $key => $value) :

            $division = new Division();
            $division->company_id = 1;
            $division->name = $value['name'];
            $division->bn_name = $value['bn_name'];
            $division->url = $value['url'];
            $division->updated_by = 1;
            $division->created_by = 1;
            $division->deleted_by = 1;
            $division->save();
        endforeach;


        $formStructure = array(
            'name' => 'divisions',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Division Name',
                    'placeholder' => 'Division English Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',

                ),
              
                array(
                    'name' => 'bn_name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Division name',
                    'placeholder' =>  'Division Bangla name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',


                ),
                array(
                    'name' => 'url',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'URL',
                    'placeholder' => 'URL',
                    'value' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable|url',

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