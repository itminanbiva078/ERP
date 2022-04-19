<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerOpeningDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
