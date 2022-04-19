<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $status = array(
            'Approved',
            'Inactive',
            'Pending',
        );
        foreach ($status as $key => $value) :
            $status = new Status();
            $status->name = $value;
            $status->company_id = 1;//$value;
            $status->save();
        endforeach;




    }
}
