<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasesMrr extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function purchasesMrrDetails(){
        return $this->hasMany(PurchasesMrrDetails::class,'mrr_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
   
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
   
    public function purchases(){
        return $this->belongsTo(Purchases::class,'purchases_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
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
