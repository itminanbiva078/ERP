<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;

class ServicesExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Service::where('company_id',Helper::companyId())->get();

    }
}
