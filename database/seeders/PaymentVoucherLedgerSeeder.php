<?php

namespace Database\Seeders;
use App\Models\PaymentVoucherLedger;
use Faker\Generator as Faker;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class PaymentVoucherLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $unixTimestamp = time();
        // for ($i = 0; $i < 2; $i++) :
        //     $paymentVoucherLedger = new PaymentVoucherLedger();
        //     $paymentVoucherLedger->payment_id = rand(1, 10);
        //     $paymentVoucherLedger->account_id = rand(1, 10);
        //     $paymentVoucherLedger->date = $faker->date;
        //     $paymentVoucherLedger->debit = $faker->creditCardNumber;
        //     $paymentVoucherLedger->credit = $faker->creditCardNumber;
        //     $paymentVoucherLedger->memo = $faker->text;
        //     $paymentVoucherLedger->updated_by = 1;
        //     $paymentVoucherLedger->created_by = 1;
        //     $paymentVoucherLedger->deleted_by = 1;
        //     $paymentVoucherLedger->save();
        // endfor;

        
        $formStructure =  array(
            'name' => 'payment_voucher_ledgers',
            'input_field' => array(
                array(
                    'name' => 'debit_id',
                    'type' => 'toptionGroup',
                    'class' => 'form-control debit_id select2',
                    'id' => null,
                    'label' => 'Please select',
                    'placeholder' => 'Please select',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'debit',
                    'type' => 'tnumber',
                    'class' => 'form-control debit decimal',
                    'id' => null,
                    'label' => 'Amount',
                    'placeholder' => '0.00',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'memo',
                    'type' => 'ttext',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Memo',
                    'placeholder' => 'Memo',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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
