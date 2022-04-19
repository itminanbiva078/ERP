<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\PurchasesOrder;
use Faker\Generator as Faker;
use App\Models\FormInput;

class PurchasesOrderSeeder extends Seeder
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
        //     $purchasesOrder = new PurchasesOrder();
        //     $purchasesOrder->date =$faker->date;
        //     $purchasesOrder->supplier_id = rand(1,10);
        //     $purchasesOrder->branch_id =  rand(1,10);
        //     $purchasesOrder->requisition_id =  rand(1,10);
        //     $purchasesOrder->voucher_no = rand(1,4);//$faker->city;
        //     $purchasesOrder->payment_type =1;
        //     $purchasesOrder->subtotal = $faker->randomFloat;
        //     $purchasesOrder->discount = $faker->randomFloat;
        //     $purchasesOrder->grand_total =  $faker->randomFloat;
        //     $purchasesOrder->note = 'default note';
        //     $purchasesOrder->status = 'Pending';
        //     $purchasesOrder->updated_by = 1;
        //     $purchasesOrder->created_by = 1;
        //     $purchasesOrder->deleted_by = 1;
        //     $purchasesOrder->save();
        // endfor;


        $formStructure =  array(
            'name' => 'purchases_orders',
            'input_field' => array(
                array(
                    'name' => 'purchases_status',
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
                    'name' => 'order_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Order Status',
                    'placeholder' => 'Order Status',
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
                    'label' => 'Order Date',
                    'placeholder' => 'Order Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
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
                    'voucherInfo' => "purchases_order_prefix-purchases_orders",
                ),
                array(
                    'name' => 'supplier_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Supplier',
                    'placeholder' => 'Select Supplier',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'suppliers',
                    'customMethod' => null,
                    'validation' => 'required',
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.supplier.store.ajax',
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
                    'inputShow' => true,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
                ),
                array(
                    'name' => 'requisition_id',
                    'type' => 'smultiple',
                    'class' => 'form-control select2 requsisition_id',
                    'id' => null,
                    'label' => 'Purchases Requisition',
                    'placeholder' => 'Please select Purchases Requisition',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getRequisitionList()',
                    'validation' => 'nullable',
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
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                   
                ),
                array(
                    'name' => 'subtotal',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Subtotal',
                    'placeholder' => 'Subtotal',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => false,
                ),

                array(
                    'name' => 'grand_total',
                    'type' => 'text',
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
