<?php

namespace App\Imports;

use App\Models\SupplierGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class SupplierGroupsImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SupplierGroup([
            'name' => $row[0],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
