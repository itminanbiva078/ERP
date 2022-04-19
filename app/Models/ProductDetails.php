<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetails extends Model
{
    use HasFactory; use SoftDeletes;

    // Scope Of Company
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function floor(){
        return $this->belongsTo(Floor::class,'floor_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
