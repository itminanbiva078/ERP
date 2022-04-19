<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp = time();
        $companySetUp = new Company();
        $companySetUp->company_id = 1;
        $companySetUp->logo = $faker->image;
        $companySetUp->favicon = 'favicon.png'; //$faker->image;
        $companySetUp->invoice_logo = 'logo.png'; // $faker->image;
        $companySetUp->name = $faker->company;
        $companySetUp->website = $faker->url;
        $companySetUp->phone = $faker->phoneNumber;
        $companySetUp->email = $faker->email;
        $companySetUp->address = $faker->address;
        $companySetUp->task_identification_number = $faker->randomDigit;
        $companySetUp->updated_by = 1;
        $companySetUp->created_by = 1;
        $companySetUp->deleted_by = 1;
        // $companySetUp->deleted_at = $faker->dateTime($unixTimestamp);
        $companySetUp->save();


        $formStructure = array(
            'name' => 'companies',
            'input_field' => array(

                array(
                    'name' => 'company_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Company Category',
                    'placeholder' => 'Select Company name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'company_categories',
                    'customMethod' => null,

                ),
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
                    'validation' => 'required',

                ),
                array(
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'table' => 'companies',
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|email|unique:companies,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'companies',
                    'unique' => true,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
              
                array(
                    'name' => 'website',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Website',
                    'placeholder' => 'Website',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable|url',
                ),


                array(
                    'name' => 'logo',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Logo',
                    'placeholder' => 'Logo',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name' => 'invoice_logo',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Invoice Logo',
                    'placeholder' => 'Invoice Logo',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name'  => 'favicon',
                    'type'  => 'file',
                    'class' => 'form-control',
                    'id'    => null,
                    'label' => 'Favicon',
                    'placeholder' => 'Favicon',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name' => 'task_identification_number',
                    'type' => 'number',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Task Identification Number',
                    'placeholder' => 'Task Identification Number',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',

                ),
                array(
                    'name' => 'address',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Address',
                    'placeholder' => 'Address',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable|max:200',

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