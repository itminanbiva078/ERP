<?php

namespace App\Imports;
use App\Helpers\Helper;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Product([
            'name' => $row[0],
            'purchases_price' => $row[1],
            'sale_price' => $row[2],
            'low_stock' => $row[3],
            'category_id' => "1",
            'brand_id' => "1",
            'unit_id' => "1",
            'company_id' => Helper::companyId(),
            'status' => 'Approved',
        ]);
    }
}
