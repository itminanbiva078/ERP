<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Helpers\Helper;

class DepartmentsExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Department::where('company_id',Helper::companyId())->get();

    }
}
