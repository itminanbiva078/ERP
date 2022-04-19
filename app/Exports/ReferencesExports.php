<?php

namespace App\Exports;

use App\Models\Reference;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Helpers\Helper;

class ReferencesExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reference::where('company_id',Helper::companyId())->get();

    }
}
