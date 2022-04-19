<?php

namespace App\Imports;

use App\Models\ServiceCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class ServiceCategoryImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ServiceCategory([
            'name' => $row[0],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
