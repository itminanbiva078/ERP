<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pos extends Model
{
    use HasFactory; use SoftDeletes;


    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
    public function posDetails(){
        return $this->hasMany(PosDetails::class,'pos_id','id');
    }

    public function salesDetails(){
        return $this->hasMany(SalesDetails::class,'sales_id','id');
    }
   

    public function general(){
        return $this->hasOne(General::class,'voucher_id','id')->where('form_id',5);
    }



}
