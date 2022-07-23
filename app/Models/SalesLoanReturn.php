<?php

namespace App\Models;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesLoanReturn extends Model
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
    
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id')->select('id','name');
    }


    public function slreturnDetails(){
        return $this->hasMany(SalesLoanReturnDetails::class,'slreturn_id','id');
    }
    public function general(){
        return $this->hasOne(General::class,'voucher_id','id')->where('form_id',6);
    } 
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }      
        
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    } 
}
