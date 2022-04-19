<?php

namespace Database\Seeders;

use App\Models\FormInput;
use App\Models\TransferDetails;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TransferDetailsSeeder extends Seeder
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
        //     $transferDetails = new TransferDetails();
        //     $transferDetails->transfer_id = rand(1, 10);
        //     $transferDetails->branch_id = rand(1, 10);
        //     $transferDetails->store_id = rand(1, 10);
        //     $transferDetails->product_id = rand(1, 10);
        //     $transferDetails->date = $faker->date;
        //     $transferDetails->quantity = $faker->randomNumber;
        //     $transferDetails->unit_price = $faker->randomNumber;
        //     $transferDetails->total_price = $faker->randomNumber;
        //     $transferDetails->updated_by = 1;
        //     $transferDetails->created_by = 1;
        //     $transferDetails->deleted_by = 1;
        //     $transferDetails->save();
        // endfor;

        $formStructure = array(
            'name' => 'transfer_details',
            'input_field' => array(
                array(
                    'name' => 'product_id',
                    'type' => 'tpoptionGroup',
                    'class' => 'form-control product_id select2',
                    'id' => null,
                    'label' => 'Product',
                    'placeholder' => 'Type Product',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'products',
                    'customMethod' => null,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'batch_no',
                    'type' => 'tselect',
                    'class' => 'form-control batch_no select2',
                    'id' => null,
                    'label' => 'Batch Number',
                    'placeholder' => 'Batch No',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                    'customMethod' => "getActiveBatch()",
                ),
                array(
                    'name' => 'pack_size',
                    'type' => 'tnumber',
                    'class' => 'form-control pack_size decimal',
                    'id' => null,
                    'label' => 'Pack Size',
                    'placeholder' => 'Pack Size',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                ),
                array(
                    'name' => 'pack_no',
                    'type' => 'tnumber',
                    'class' => 'form-control pack_no decimal',
                    'id' => null,
                    'label' => 'Pack No.',
                    'placeholder' => 'Pack No.',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
                ),
                array(
                    'name' => 'quantity',
                    'type' => 'tnumber',
                    'class' => 'form-control quantity decimal',
                    'id' => null,
                    'label' => 'Quantity',
                    'placeholder' => 'Quantity',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
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