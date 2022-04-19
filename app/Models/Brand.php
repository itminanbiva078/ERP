<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table= 'brands';
    protected $guarded = array();

    public function products(){
     return $this->hasMany(Brand::class, 'brand_id','id');
    }


    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }


}
