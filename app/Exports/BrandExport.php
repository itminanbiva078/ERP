<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

       
       return Brand::where('company_id',Helper::companyId())->get();
       
    }
}
