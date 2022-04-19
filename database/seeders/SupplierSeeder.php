<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $supplierType = array('Corporate', 'Local', 'Hole Salar', 'Others');
      
        for ($i = 1; $i < 3; $i++) :
            $supplier = new Supplier();
            $supplier->contact_person = $faker->company;
            $supplier->company_id = 1;
            $supplier->supplier_type = rand(1, 10);
            $supplier->branch_id =  rand(1, 10);
            $supplier->name = 'Supplier '.$i;
            $supplier->email = $faker->email;
            $supplier->phone = $faker->phoneNumber;
            $supplier->address = $faker->address;
            $supplier->division_id =   rand(1, 4);
            $supplier->district_id = rand(1, 4);
            $supplier->union_id = rand(1, 4); //$faker->city;
            $supplier->upazila_id = rand(1, 4); //$faker->city;
            $supplier->pay_term = "CASH"; //$faker->country;
            $supplier->pay_term_type = "CASH";
            $supplier->status = 1;
            $supplier->updated_by = 1;
            $supplier->created_by = 1;
            $supplier->deleted_by = 1;
            $supplier->save();
        endfor;


        $formStructure =  array(
            'name' => 'suppliers',
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
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'readonly' => 'readonly',
                    'voucherInfo' => "supplier_prefix-suppliers",
                ),
                array(
                    'name' => 'supplier_type',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Supplier Group',
                    'placeholder' => 'Supplier Type',
                    'value' => null,
                    'required' => null,
                    'validation' => 'required',
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'supplier_groups',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.supplierGroup.store.ajax',

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
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
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
                    'table' => 'suppliers',
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|email|unique:suppliers,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'suppliers',
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
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
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
                    'validation' => 'required|max:100|min:2',
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,

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
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,

                ),
                array(
                    'name' => 'district_id',
                    'type' => 'select',
                    'class' => 'form-control district_id select2',
                    'id' => null,
                    'label' => 'Select District',
                    'placeholder' => 'Please select District',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'districts',
                    'customMethod' => null,

                ),
                array(
                    'name' => 'division_id',
                    'type' => 'select',
                    'class' => 'form-control division_id select2',
                    'id' => null,
                    'label' => 'Select Division',
                    'placeholder' => 'Please select Division',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'divisions',
                    'customMethod' => null,

                ),
                array(
                    'name' => 'union_id',
                    'type' => 'select',
                    'class' => 'form-control union_id select2',
                    'id' => null,
                    'label' => 'Select Union',
                    'placeholder' => 'Please select Union',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'unions',
                    'customMethod' => null,

                ),
                array(
                    'name' => 'upazila_id',
                    'type' => 'select',
                    'class' => 'form-control upazila_id select2',
                    'id' => null,
                    'label' => 'Select Thana',
                    'placeholder' => 'Please select Thana',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'upazilas',
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