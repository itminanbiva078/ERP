<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Brand([
            'name' => $row[0],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
