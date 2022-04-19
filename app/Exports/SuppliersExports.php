<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuppliersExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supplier::where('company_id',Helper::companyId())->get();

    }
}
