<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;
class SalesLon extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function salesLoanDetails(){
      return $this->hasMany(SalesLonDetails::class,'sales_lons_id','id');
     }
 
     public function customer(){
         return $this->belongsTo(Customer::class,'customer_id','id');
     }
 
     public function branch(){
         return $this->belongsTo(Branch::class,'branch_id','id')->select('id','name');
     }
     public function store(){
         return $this->belongsTo(Store::class,'store_id','id');
     }

     public function scopeCompany($query)
     {
         return $query->where('company_id', Helper::companyId());
     }

     public function general(){
         
         return $this->hasOne(General::class,'voucher_id','id')->where('form_id',5);
     }
}
