<?php

namespace Database\Seeders;
use App\Models\PurchaseRequisition;
use Faker\Generator as Faker;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class PurchaseRequisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp =time();
        // for ($i = 0; $i < 2; $i++) :
        //     $purchaseRequisition = new PurchaseRequisition();
        //     $purchaseRequisition->date =$faker->date;
        //     $purchaseRequisition->department_id = rand(1,10);
        //     $purchaseRequisition->branch_id =  rand(1,10);
        //     $purchaseRequisition->voucher_no = rand(1,4);//$faker->city;
        //     $purchaseRequisition->payment_type =1;
        //     $purchaseRequisition->subtotal = $faker->randomFloat;
        //     $purchaseRequisition->discount = $faker->randomFloat;
        //     $purchaseRequisition->grand_total =  $faker->randomFloat;
        //     $purchaseRequisition->note = 'default note';
        //     $purchaseRequisition->status = 'Pending';
        //     $purchaseRequisition->updated_by = 1;
        //     $purchaseRequisition->created_by = 1;
        //     $purchaseRequisition->deleted_by = 1;
        //     $purchaseRequisition->save();
        // endfor;


        $formStructure =  array(
            'name' => 'purchase_requisitions',
            'input_field' => array(
                array(
                    'name' => 'purchases_order_status',
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
                    'name' => 'requisition_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Requisition Status',
                    'placeholder' => 'Requisition Status',
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
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Requisition Date',
                    'placeholder' => 'Requisition Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',
                ),

                array(
                    'name' => 'voucher_no',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher No.',
                    'placeholder' => 'Voucher No.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                    'readonly' => 'readonly',
                    'voucherInfo' => "purchases_requisition_prefix-purchase_requisitions",
                ),
                
                array(
                    'name' => 'department_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Department',
                    'placeholder' => 'Select Department',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'departments',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Please select Branch',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    
                ),
                array(
                    'name' => 'documents',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Document Upload',
                    'placeholder' => 'Document Upload',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => false,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
              
                array(
                    'name' => 'total_qty',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total Quantity',
                    'placeholder' => 'Subtotal',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                ),
                array(
                    'name' => 'note',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Total',
                    'placeholder' => 'Total',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
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
