<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table= 'product_attributes';
    protected $guarded = array();
    //Product  
    public function product(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }
    // Scope Of Company
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
