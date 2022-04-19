<?php

namespace App\Exports;
use App\Helpers\Helper;
use App\Models\TaskCategory;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskCategoryExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TaskCategory::where('company_id',Helper::companyId())->get();

    }
}
