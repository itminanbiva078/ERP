<?php

namespace Database\Seeders;
use App\Models\PaymentStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $paymentStatus = array(
            'Approved',
            'Inactive',
            'Pending',
        );
        foreach ($paymentStatus as $key => $value) :
            $paymentStatus = new PaymentStatus();
            $paymentStatus->name = $value;
            $paymentStatus->company_id = 1;//$value;
            $paymentStatus->save();
        endforeach;
    }
}
