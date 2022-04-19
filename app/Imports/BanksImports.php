<?php

namespace App\Imports;
use App\Helpers\Helper;
use App\Models\Bank;
use Maatwebsite\Excel\Concerns\ToModel;

class BanksImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Bank([
            'bank_name' => $row[0],
            'account_name' => $row[1],
            'account_number' => $row[2],
            'branch' => $row[3],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
