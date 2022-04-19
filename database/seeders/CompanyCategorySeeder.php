<?php

namespace Database\Seeders;

use App\Models\CompanyCategory;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\FormInput;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {


      /// $allNavigation =  FormInput::select('navigation_id')->get();
        $companyCategory = new  CompanyCategory();
        $companyCategory->name = 'ERP';
       // $companyCategory->module_details = json_encode($allNavigation);
        $companyCategory->status = 'Approved';
        $companyCategory->save();

        $formStructure = array(
            'name' => 'company_categories',
            'input_field' => array(
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
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',

                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Company Name',
                    'placeholder' => 'Company Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'email',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'password',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Password',
                    'placeholder' => 'Password',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
               
               
                array(
                    'name' => 'is_branch',
                    'type' => 'checkbox',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Is Branch Enable',
                    'placeholder' => 'Check For Enable Branch',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => null,
                ),
                array(
                    'name' => 'is_store',
                    'type' => 'checkbox',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Is Store Enable',
                    'placeholder' => 'Check For Enable Store',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => null,
                ),
                
                array(
                    'name' => 'module',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Module',
                    'placeholder' => 'Module',
                    'value' => null,
                    'required' => null,
                    'inputShow' => false,
                    'tableshow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'module_details',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Sub-Module',
                    'placeholder' => 'Sub-Module',
                    'value' => null,
                    'required' => null,
                    'inputShow' => false,
                    'tableshow' => false,
                    'unique' => false,
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