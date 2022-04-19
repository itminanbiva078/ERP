<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\SupplierGroup;
use Maatwebsite\Excel\Concerns\FromCollection;

class SupplierGroupsExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SupplierGroup::where('company_id',Helper::companyId())->get();

    }
}
