<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyResource extends Model
{
    use HasFactory; use SoftDeletes;


    public function companyCategory(){
        return $this->belongsTo(CompanyCategory::class,'company_category_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
