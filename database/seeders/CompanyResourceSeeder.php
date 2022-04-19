<?php

namespace Database\Seeders;

use App\Models\CompanyResource;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CompanyResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $formInput = FormInput::get();

      

        foreach ($formInput as $key => $value) :
            $company = new CompanyResource();
            $company->company_category_id = 1;
            $company->table = $value->table;
            $company->navigation_id = $value->navigation_id;
            $company->form_input =$value->input;
            $company->save();
        endforeach;
    }
}