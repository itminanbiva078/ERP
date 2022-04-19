<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CurrencySeeder extends Seeder
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
        //     $currency = new Currency();
        //     $currency->name = $faker->languageCode;
        //     $currency->currency_symbol = $faker->currencyCode;
        //     $currency->exchange_rate = $faker->randomDigit;
        //     $currency->updated_by = 1;
        //     $currency->created_by = 1;
        //     $currency->deleted_by = 1;
        //     // $currency->deleted_at = $faker->dateTime($unixTimestamp);
        //     $currency->save();
        // endfor;
        $formStructure = array(
            'name' => 'currencies',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Currency name',
                    'placeholder' => 'Currency name',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|max:100|min:2',
                ),
             
                array(
                    'name' => 'currency_symbol',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Currency symbol',
                    'placeholder' => 'Currency symbol',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'exchange_rate',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Exchange Rate',
                    'placeholder' => 'Exchange Rate',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',

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
                    'customMethod' => null,
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