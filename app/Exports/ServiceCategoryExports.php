<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\ServiceCategory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServiceCategoryExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceCategory::where('company_id',Helper::companyId())->get();

    }
}
