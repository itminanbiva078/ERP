<?php

namespace Database\Seeders;
use Faker\Generator as Faker;
use App\Models\DeliveryChallan;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class DeliveryChallanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //  $unixTimestamp =time();
        // for ($i = 0; $i < 2; $i++) :
        //     $deliveryChallan = new DeliveryChallan();
        //     $deliveryChallan->date =$faker->date;
        //     $deliveryChallan->customer_id = rand(1,10);
        //     $deliveryChallan->branch_id =  rand(1,10);
        //     $deliveryChallan->note = 'default note';
        //     $deliveryChallan->updated_by = 1;
        //     $deliveryChallan->created_by = 1;
        //     $deliveryChallan->deleted_by = 1;
        //     $deliveryChallan->save();
        // endfor;


        $formStructure =  array(
            'name' => 'delivery_challans',
            'input_field' => array(
                array(
                    'name' => 'receive_status',
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
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Challan Date',
                    'placeholder' => 'Challan Date',
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
                    'voucherInfo' => "delivery_challans_prefix-delivery_challans",

                ),
                array(
                    'name' => 'customer_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Customer',
                    'placeholder' => 'Select Customer',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'customers',
                    'customMethod' => null,
                    'validation' => 'required',
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'salesSetup.customer.store.ajax',
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
                    'name' => 'sales_id',
                    'type' => 'select',
                    'class' => 'form-control select2 sales_id',
                    'id' => null,
                    'label' => 'Sales',
                    'placeholder' => 'Please select Sales',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getSalesList()',
                ),



                array(
                    'name' => 'delivery_location',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Delivery Location',
                    'placeholder' => 'Delivery Location',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                ),
                array(
                    'name' => 'total_qty',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Challan Qty',
                    'placeholder' => 'Challan Qty',
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
