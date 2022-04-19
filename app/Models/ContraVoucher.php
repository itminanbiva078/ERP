<?php

namespace App\Models;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContraVoucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
    public function accountType(){
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }
    public function contraVoucherLedger(){
        return $this->hasMany(ContraVoucherDetails::class,'contra_voucher_id','id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
