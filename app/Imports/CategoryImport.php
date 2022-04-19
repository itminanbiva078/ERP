<?php

namespace App\Imports;
use App\Models\Category;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([

            'name' => $row[0],
            'company_id' => Helper::companyId(),
            'status' => 'Approved',

        ]);
    }
}
