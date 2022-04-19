<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryChallan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function deliveryChallanDetails(){
        return $this->hasMany(DeliveryChallanDetails::class,'delivery_challan_id','id');
       }

       public function salesDetails(){
        return $this->hasMany(SalesDetails::class,'sales_id','id');
       }

       public function scopeCompany($query)
       {
           return $query->where('company_id', Helper::companyId());
       }
       public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }      
        
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }      

    public function approvedBy(){
        return $this->belongsTo(User::class,'approved_by','id');
    }

}
