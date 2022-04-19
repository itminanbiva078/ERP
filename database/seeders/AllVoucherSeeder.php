<?php

namespace Database\Seeders;

use App\Models\AllVoucher;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AllVoucherSeeder extends Seeder
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
            $allvoucher = new AllVoucher();
            $allvoucher->date = $faker->date;
            $allvoucher->form_id = rand(1, 10);
            $allvoucher->voucher_no = $faker->phoneNumber;
            $allvoucher->branch_id = rand(1, 10);
            $allvoucher->store_id = rand(1, 10);
            $allvoucher->debit = $faker->creditCardNumber;
            $allvoucher->credit = $faker->creditCardNumber;
            $allvoucher->status_id = rand(1, 10);
            $allvoucher->updated_by = 1;
            $allvoucher->created_by = 1;
            $allvoucher->deleted_by = 1;
            // $allvoucher->deleted_at = $faker->dateTime($unixTimestamp);
            $allvoucher->save();
        endfor;

        $formStructure = array(
            'name' => 'all_vouchers',
            'input_field' => array(
                array(
                    'name' => 'date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Date',
                    'placeholder' => 'Date',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',

                ),
                array(
                    'name' => 'form_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'forms',

                ),
                array(
                    'name' => 'voucher_no',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Voucher Number',
                    'placeholder' => 'Voucher Number',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'branches',

                ),
                array(
                    'name' => 'store_id',
                    'type' => 'select',
                    'class' => 'form-control select2 store_id',
                    'id' => null,
                    'label' => 'Store',
                    'placeholder' => 'Please select Store',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'stores',

                ),
                array(
                    'name' => 'debit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Debit',
                    'placeholder' => 'Debit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',

                ),
                array(
                    'name' => 'credit',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Credit',
                    'placeholder' => 'Credit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',

                ),
                array(
                    'name' => 'status_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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