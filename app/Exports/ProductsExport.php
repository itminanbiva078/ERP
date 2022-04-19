<?php

namespace App\Exports;

use App\Models\Product;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('company_id',Helper::companyId())->get();

    }
}
