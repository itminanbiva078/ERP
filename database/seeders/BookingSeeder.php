<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // for ($i = 0; $i < 10; $i++) :
        //     $product = new Booking();
        //     $product->customer_id = $faker->name;
        //     $product->company_id = 1;
        //     $product->category_id = rand(1, 2);
        //     $product->brand_id = rand(1, 10);
        //     $product->unit_id = rand(1, 10);
        //     $product->type_id = 1;
        //     $product->updated_by = 1;
        //     $product->created_by = 1;
        //     $product->deleted_by = 1;
        //     $product->save();
        // endfor;


        $formStructure =  array(
            'name' => 'bookings',
            'input_field' => array(
             array(
                    'name' => 'payment_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Payment Status',
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
                    'name' => 'booking_status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Booking Status',
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
                    'label' => 'Booking Date',
                    'placeholder' => 'Booking Date',
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
                    'voucherInfo' => "hotel_booking_prefix-bookings",
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
                    'name' => 'addon',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Addon',
                    'placeholder' => 'Addon',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'payment_type',
                    'type' => 'select',
                    'class' => 'form-control select2 payment_type',
                    'id' => null,
                    'label' => 'Payment Type',
                    'placeholder' => 'Please select Payment Type',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' => 'getPaymentType()',
                    'validation' => 'required',
                ),
                array(
                    'name' => 'account_id',
                    'type' => 'optionGroup',
                    'class' => 'form-control select2 account_id ',
                    'id' => null,
                    'label' => 'Account Head',
                    'placeholder' => 'Please Select Account Head',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'hideDiv' => 'hide',
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'bank_id',
                    'type' => 'select',
                    'class' => 'form-control bank_id select2 hide',
                    'id' => null,
                    'label' => 'Select Bank',
                    'placeholder' => 'Please select Bank',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'hideDiv' => 'hide',
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => null,
                    'customMethod' =>'getBankInfo()',
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'cheque_number',
                    'type' => 'text',
                    'class' => 'form-control cheque_number',
                    'id' => null,
                    'hideDiv' => 'hide',
                    'label' => 'Cheque Number',
                    'placeholder' => 'Cheque Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'cheque_date',
                    'type' => 'date',
                    'class' => 'form-control cheque_date',
                    'id' => null,
                    'label' => 'Cheque Date',
                    'placeholder' => 'Cheque Date',
                    'value' => null,
                    'hideDiv' => 'hide',
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
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
                    'name' => 'advance_paid',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Advance Amount',
                    'placeholder' => 'Advance Paid',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'due_amount',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Due Amount',
                    'placeholder' => 'Due Amount',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'paid_amount',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Paid Amount',
                    'placeholder' => 'Paid Amount',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required',
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
