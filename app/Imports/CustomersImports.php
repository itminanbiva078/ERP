<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class CustomersImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'name' => $row[0],
            'business_name' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'address' => $row[4],
            'customer_type' => "1",
            'branch_id' => "1",
            'store_id' => "1",
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
