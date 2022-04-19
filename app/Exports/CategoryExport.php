<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::where('company_id',Helper::companyId())->get();
    }
}
