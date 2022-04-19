<?php

namespace Database\Seeders;
use Faker\Generator as Faker;
use App\Models\DeliveryChallanDetails;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class DeliveryChallanDetailsSeeder extends Seeder
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
        //     $deliveryChalanDetails = new DeliveryChallanDetails();
        //     $deliveryChalanDetails->delivery_challan_id =rand(1,10);
        //     $deliveryChalanDetails->branch_id =rand(1,10);
        //     $deliveryChalanDetails->product_id =rand(1,10);
        //     $deliveryChalanDetails->date = $faker->date;
        //     $deliveryChalanDetails->batch_no = rand(1,4);//$faker->city;
        //     $deliveryChalanDetails->discount = $faker->randomFloat;
        //     $deliveryChalanDetails->updated_by = 1;
        //     $deliveryChalanDetails->created_by = 1;
        //     $deliveryChalanDetails->deleted_by = 1;
        //     $deliveryChalanDetails->save();
        // endfor;

        $formStructure = array(
            'name' => 'delivery_challan_details',
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
                    'type' => 'ttext',
                    'class' => 'form-control batch_no',
                    'id' => null,
                    'label' => 'Batch Number',
                    'placeholder' => 'Batch No',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'nullable|array|min:1',
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
                array(
                    'name' => 'remaining_quantity',
                    'type' => 'tnumber',
                    'class' => 'form-control remaining_quantity decimal',
                    'id' => null,
                    'label' => 'Remaining Quantity',
                    'placeholder' => 'Remaining Quantity',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'approved_quantity',
                    'type' => 'tnumber',
                    'class' => 'form-control approved_quantity decimal',
                    'id' => null,
                    'label' => 'Receive Quantity',
                    'placeholder' => 'Receive Quantity',
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
