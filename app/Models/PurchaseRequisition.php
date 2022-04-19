<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Transformers\DepartmentTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequisition extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function requisitionDetails(){
       return $this->hasMany(PurchaseRequisitionDetails::class,'requisition_id','id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
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
