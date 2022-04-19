<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiveVoucherLedger;
use Faker\Generator as Faker;
use App\Models\FormInput;
class ReceiveVoucherLedgerSeeder extends Seeder
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
        //     $receiveVoucherLedger = new ReceiveVoucherLedger();
        //     $receiveVoucherLedger->receive_id = rand(1, 10);
        //     $receiveVoucherLedger->account_id = rand(1, 10);
        //     $receiveVoucherLedger->debit_id = rand(1, 10);
        //     $receiveVoucherLedger->date = $faker->date;
        //     $receiveVoucherLedger->debit = $faker->creditCardNumber;
        //     $receiveVoucherLedger->credit = $faker->creditCardNumber;
        //     $receiveVoucherLedger->memo = $faker->text;
        //     $receiveVoucherLedger->updated_by = 1;
        //     $receiveVoucherLedger->created_by = 1;
        //     $receiveVoucherLedger->deleted_by = 1;
        //     $receiveVoucherLedger->save();
        // endfor;

        
        $formStructure =  array(
            'name' => 'receive_voucher_ledgers',
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
