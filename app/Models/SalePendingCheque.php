<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalePendingCheque extends Model
{
    use HasFactory; use SoftDeletes;
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
    
    public function purchases(){
        return $this->belongsTo(Purchases::class,'voucher_id','id');
    }

    public function sale(){
        return $this->belongsTo(Sales::class,'voucher_id','id');
    }
    public function posDetails(){
        return $this->belongsTo(Pos::class,'voucher_id','id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }
    
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function formInfo(){
        return $this->belongsTo(Form::class,'form_id','id');
    }

}
