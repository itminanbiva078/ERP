<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class EmployeesImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'name' => $row[0],
            'designation' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'address' => $row[4],
            'branch_id' => "1",
            'parent_id' => "1",
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
