<?php

namespace App\Imports;

use App\Models\Reference;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class ReferencesImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Reference([
            'name' => $row[0],
            'email' => $row[1],
            'phone' => $row[2],
            'address' => $row[3],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
