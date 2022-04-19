<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAdjustment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function inventoryAdjustmentDetails(){
        return $this->hasMany(InventoryAdjustmentDetails::class,'inven_ad_id','id');
       }
   
     
       public function branch(){
           return $this->belongsTo(Branch::class,'branch_id','id');
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
      
      public function product(){
          return $this->belongsTo(Product::class,'product_id','id');
      }
      public function batch(){
          return $this->belongsTo(BatchNumber::class,'batch_no','id');
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
