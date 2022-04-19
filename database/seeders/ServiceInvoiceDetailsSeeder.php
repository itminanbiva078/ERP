<?php

namespace Database\Seeders;
use Faker\Generator as Faker;
use App\Models\ServiceInvoiceDetails;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class ServiceInvoiceDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp =time();
        for ($i = 0; $i < 2; $i++) :
            $serviceInvoiceDetails = new ServiceInvoiceDetails();
            $serviceInvoiceDetails->service_id =rand(1,10);
            $serviceInvoiceDetails->company_id = 1;
            $serviceInvoiceDetails->service_invoice_id =rand(1,10);
            $serviceInvoiceDetails->quantity = $faker->randomNumber;
            $serviceInvoiceDetails->unit_price = $faker->randomNumber;
            $serviceInvoiceDetails->total_price = $faker->randomNumber;
            $serviceInvoiceDetails->updated_by = 1;
            $serviceInvoiceDetails->created_by = 1;
            $serviceInvoiceDetails->deleted_by = 1;
            $serviceInvoiceDetails->save();
        endfor;
        $formStructure = array(
            'name' => 'service_invoice_details',
            'input_field' => array(
                array(
                    'name' => 'service_id',
                    'type' => 'tsoptionGroup',
                    'class' => 'form-control service_id select2',
                    'id' => null,
                    'label' => 'Service',
                    'placeholder' => 'Select Service',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'services',
                    'customMethod' => null,
                    'validation' => 'required|array|min:1',
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
                    'name' => 'unit_price',
                    'type' => 'tnumber',
                    'class' => 'form-control unit_price decimal',
                    'id' => null,
                    'label' => 'Unit Price',
                    'placeholder' => 'Unit Price',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|array|min:1',
                ),
                array(
                    'name' => 'total_price',
                    'type' => 'tnumber',
                    'class' => 'form-control total_price decimal',
                    'id' => null,
                    'label' => 'Total Price',
                    'placeholder' => 'Total Price',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'readonly' => 'readonly',
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
