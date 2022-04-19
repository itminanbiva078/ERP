<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockSummary extends Model
{
    use HasFactory; use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    
    public function batch(){
        return $this->belongsTo(BatchNumber::class,'batch_no','id');
    }
    
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
    


}
