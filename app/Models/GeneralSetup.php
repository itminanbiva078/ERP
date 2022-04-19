<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralSetup extends Model
{
    use HasFactory;
    use SoftDeletes;

     
    public function language()
    {
        return $this->belongsTo(Language::class,'language_id', 'id')->select('id','name');
    }
    public function currencie()
    {
        return $this->belongsTo(Currency::class, 'currencie_id', 'id')->select('id','name');
    }
    public function company(){
        return $this->belongsTo(CompanyCategory::class,'company_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
