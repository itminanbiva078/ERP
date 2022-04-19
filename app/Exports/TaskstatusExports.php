<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\TaskStatus;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskstatusExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TaskStatus::where('company_id',Helper::companyId())->get();

    }
}
