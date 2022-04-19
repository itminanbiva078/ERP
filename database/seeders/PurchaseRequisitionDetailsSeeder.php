<?php

namespace Database\Seeders;
use App\Models\PurchaseRequisitionDetails;
use Faker\Generator as Faker;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class PurchaseRequisitionDetailsSeeder extends Seeder
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
        //     $purchasesOrderDetails = new PurchaseRequisitionDetails();
        //     $purchasesOrderDetails->requisition_id = rand(1, 10);
        //     $purchasesOrderDetails->branch_id = rand(1, 10);
        //     $purchasesOrderDetails->product_id = rand(1, 10);
        //     $purchasesOrderDetails->date = $faker->date;
        //     $purchasesOrderDetails->batch_no = rand(1, 4); //$faker->city;
        //     $purchasesOrderDetails->unit_price = $faker->randomNumber;
        //     $purchasesOrderDetails->total_price = $faker->randomNumber;
        //     $purchasesOrderDetails->discount = $faker->randomFloat;
        //     $purchasesOrderDetails->updated_by = 1;
        //     $purchasesOrderDetails->created_by = 1;
        //     $purchasesOrderDetails->deleted_by = 1;
        //     $purchasesOrderDetails->save();
        // endfor;
        $formStructure = array(
            'name' => 'purchase_requisition_details',
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
                    'name' => 'pack_size',
                    'type' => 'tnumber',
                    'class' => 'form-control pack_size decimal',
                    'id' => null,
                    'label' => 'Pack Size',
                    'placeholder' => 'Pack Size',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'inputShow' => true,
                    'tableshow' => true,
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
                    'inputShow' => true,
                    'tableshow' => true,
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
