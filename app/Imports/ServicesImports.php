<?php

namespace App\Imports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class ServicesImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Service([
            'name' => $row[0],
            'price' => $row[1],
            'service_id' => "1",
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
