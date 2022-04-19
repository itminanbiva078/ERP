<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerOpening extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }


    public function customerOpeningDetails(){
        return $this->hasMany(CustomerOpeningDetails::class,'customer_openings_id','id');
       }

}
