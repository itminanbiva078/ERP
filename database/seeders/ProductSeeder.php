<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\FormInput;
use App\Models\ProductDetails;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i < 10; $i++) :
            $product = new Product();
            $product->code = rand(1000, 5000).$i;
            $product->name = 'Product '.$i;
            $product->company_id = 1;
            $product->category_id = rand(1, 2);
            $product->brand_id = rand(1, 10);
            $product->unit_id = rand(1, 10);
            if($i < 5)
                $product->type_id = 'Pos Product';
            else
                $product->type_id = 'Pos Product';
            $product->purchases_price = $faker->randomNumber;
            $product->sale_price = $faker->randomNumber;
            $product->low_stock = $faker->randomNumber;
            $product->updated_by = 1;
            $product->created_by = 1;
            $product->deleted_by = 1;
            $product->save();
            if($i < 5)
                $productDetails = new ProductDetails();
                $productDetails->product_id = $product->id;
                $productDetails->number_of_bed  = rand(1,2);
                $productDetails->number_of_room  = rand(1,2);
                $productDetails->advance_percentage  = rand(1,2);
                $productDetails->room_no  = rand(1,2);
                $productDetails->floor_id  = rand(1,2);
                $productDetails->product_attributes  = 'AC,NON AC';
                $productDetails->save();


        endfor;
        $formStructure =  array(
            'name' => 'products',
            'input_field' => array(
                array(
                    'name' => 'code',
                    'type' => 'text',
                    'class' => 'form-control readonly',
                    'id' => null,
                    'label' => 'Code',
                    'placeholder' => 'Code',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'readonly' =>'readonly',
                    'voucherInfo' => "product_prefix-products",
                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Name',
                    'placeholder' => 'Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => true,
                    'validation' => 'required|min:2|unique:products,name',

                ),

                 array(
                    'name' => 'type_id',
                    'type' => 'select',
                    'class' => 'form-control select2 product_type',
                    'id' => null,
                    'label' => 'Product Type',
                    'placeholder' => 'Please select product type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                    'foreignTable' => null,
                    'customMethod' => 'getSetupData(12)',
                ),
                array(
                    'name' => 'category_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Category',
                    'placeholder' => 'Please select category',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                    'foreignTable' => 'categories',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.category.store.ajax',
                ),
                array(
                    'name' => 'unit_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Unit',
                    'placeholder' => 'Please select Unit',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                    'foreignTable' => 'product_units',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.unit.store.ajax',
                ),
                array(
                    'name' => 'brand_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Brand',
                    'placeholder' => 'Please select Brand',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                    'foreignTable' => 'brands',
                    'customMethod' => null,
                    'jqueryMethod' => 'loadModal',
                    'jqueryRoute' => 'inventorySetup.brand.store.ajax',
                ),

                array(
                    'name' => 'purchases_price',
                    'type' => 'text',
                    'class' => 'form-control decimal',
                    'id' => null,
                    'label' => 'Purchases Price',
                    'placeholder' => 'Purchases Price',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
                ),
                array(
                    'name' => 'sale_price',
                    'type' => 'text',
                    'class' => 'form-control decimal',
                    'id' => null,
                    'label' => 'Sale price',
                    'placeholder' => 'Sale price',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'low_stock',
                    'type' => 'text',
                    'class' => 'form-control decimal',
                    'id' => null,
                    'label' => 'Alert Qty',
                    'placeholder' => 'Alert Qty',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'nullable',
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
                    'foreignTable' => 'statuses',
                    'inputShow' => true,
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),

                array(
                    'name' => 'description',
                    'type' => 'textarea',
                    'class' => 'form-control ',
                    'id' => null,
                    'label' => 'Description',
                    'placeholder' => 'Description',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
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
