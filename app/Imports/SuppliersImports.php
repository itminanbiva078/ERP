<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class SuppliersImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'name' => $row[0],
            'email' => $row[1],
            'phone' => $row[2],
            'business_name' => $row[3],
            'address' => $row[4],
            'supplier_type' => "1",
            'branch_id' => "1",
            'store_id' => "1",
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
