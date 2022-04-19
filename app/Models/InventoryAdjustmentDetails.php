<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;
class InventoryAdjustmentDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function batch(){
        return $this->belongsTo(BatchNumber::class,'batch_no','id');
    }
}
