<?php

namespace App\Exports;

use App\Models\CustomerGroup;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Helpers\Helper;

class CustomerGroupExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomerGroup::where('company_id',Helper::companyId())->get();

    }
}
