<?php

namespace App\Imports;

use App\Models\TaskCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;

class TaskCategoryImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TaskCategory([
            'name' => $row[0],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
