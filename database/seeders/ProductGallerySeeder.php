<?php

namespace Database\Seeders;

use App\Models\ProductGallery;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductGallerySeeder extends Seeder
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
        //     $product = new Product();
        //     $product->name = $faker->name;
        //     $product->company_id = 1;
        //     $product->category_id = rand(1, 2);
        //     $product->brand_id = rand(1, 10);
        //     $product->unit_id = rand(1, 10);
        //     $product->type_id = 1;
        //     $product->purchases_price = $faker->randomNumber;
        //     $product->sale_price = $faker->randomNumber;
        //     $product->low_stock = $faker->randomNumber;
        //     $product->updated_by = 1;
        //     $product->created_by = 1;
        //     $product->deleted_by = 1;
        //     $product->save();
        // endfor;


        $formStructure =  array(
            'name' => 'product_galleries',
            'input_field' => array(
                
                array(
                    'name' => 'image_gallery',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Image Gallery Upload',
                    'placeholder' => 'Image Gallery Upload',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
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
