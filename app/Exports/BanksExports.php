<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\Bank;
use Maatwebsite\Excel\Concerns\FromCollection;

class BanksExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bank::where('company_id',Helper::companyId())->get();

    }
}
