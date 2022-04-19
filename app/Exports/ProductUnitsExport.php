<?php

namespace App\Exports;

use App\Models\ProductUnit;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductUnitsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductUnit::where('company_id',Helper::companyId())->get();

    }
}
