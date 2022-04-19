<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchases extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function purchasesDetails(){
        return $this->hasMany(PurchasesDetails::class,'purchases_id','id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id')->select('id','name');
    }

    public function purchasesOrder(){
    return $this->belongsTo(PurchasesOrder::class,'purchases_order_id','id')->select('id','voucher_no');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
    
    public function general(){
        return $this->hasOne(General::class,'voucher_id','id')->where('form_id',4);
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
