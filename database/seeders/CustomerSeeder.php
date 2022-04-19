<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $customerType = array('Corporate', 'Local', 'Whole Salar', 'Others');
        for ($i = 1; $i < 3; $i++) :
            $customer = new Customer();
            $customer->company_id = 1;
            $customer->contact_person = "ABC"; //$faker->company;
            $customer->customer_type = rand(1, 10);//corporate,ecommerce,general
            $customer->branch_id = rand(1, 10);
            $customer->name = 'Customer '.$i;
            $customer->email = $faker->email;
            $customer->phone = $faker->phoneNumber;
            $customer->address = $faker->address;
            $customer->division_id = rand(1, 4); //$faker->city;
            $customer->district_id = rand(1, 4); //$faker->city;
            $customer->upazila_id = rand(1, 4); //$faker->country;
            $customer->union_id = rand(1, 4); //$faker->country;
            $customer->sr_id = rand(1, 4); //$faker->country;
            $customer->media_id = rand(1, 4); //$faker->country;
            $customer->pay_term = $faker->languageCode;
            $customer->pay_term_type = $faker->languageCode;
            $customer->status = 1;
            $customer->updated_by = 1;
            $customer->created_by = 1;
            $customer->deleted_by = 1;
            // $customer->deleted_at = $faker->dateTime($unixTimestamp);
            $customer->save();
        endfor;

        $formStructure =  array(
            'name' => 'customers',
            'input_field' => array(
                array(
                    'name' => 'code',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Code',
                    'placeholder' => 'Code',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'readonly' =>'readonly',
                    'voucherInfo' => "customer_prefix-customers",
                ),
                array(
                    'name' => 'customer_type',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'customer Type',
                    'placeholder' => 'customer Type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'unique' => false,
                    'validation' => 'required',
                    'foreignTable' => 'customer_groups',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'inputShow' => true,
                    'jqueryRoute' => 'salesSetup.customerGroup.store.ajax',
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
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'table' => 'customers',
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'email|unique:customers,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'customers',
                    'unique' => true,
                    'required' => null,
                    'tableshow' => true,
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
                    'name' => 'contact_person',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Contact Person',
                    'placeholder' => 'Contact Person',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                    'validation' => 'max:100|min:2',
                ),
               
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Branch',
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
                    'name' => 'division_id',
                    'type' => 'select',
                    'class' => 'form-control division_id select2',
                    'id' => null,
                    'label' => 'Division',
                    'placeholder' => 'Select Division',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'divisions',
                    'customMethod' => null,
                ),
                array(
                    'name' => 'district_id',
                    'type' => 'select',
                    'class' => 'form-control district_id select2',
                    'id' => null,
                    'label' => 'District',
                    'placeholder' => 'Select Division',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'districts',
                    'customMethod' => null,

                ),
               
                array(
                    'name' => 'upazila_id',
                    'type' => 'select',
                    'class' => 'form-control upazila_id select2',
                    'id' => null,
                    'label' => 'Thana',
                    'placeholder' => 'Select Thana',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'upazilas',
                    'customMethod' => null,

                ),
                array(
                    'name' => 'union_id',
                    'type' => 'select',
                    'class' => 'form-control union_id select2',
                    'id' => null,
                    'label' => 'Union',
                    'placeholder' => 'Select Union',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'foreignTable' => 'unions',
                    'inputShow' => true,
                    'customMethod' => null,

                ),   
                array(
                    'name' => 'media_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Customer Media',
                    'placeholder' => 'Customer Media',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                    'foreignTable' => 'customer_media',
                    'customMethod' => null,

                ),   
                array(
                    'name' => 'sr_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Sales Representative',
                    'placeholder' => 'Sales Representative',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                    'foreignTable' => 'employees',
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