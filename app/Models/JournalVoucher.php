<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalVoucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id')->select('id','name');
    }

    public function journalVoucherLedger(){
        return $this->hasMany(JournalVoucherLedger::class,'journal_id','id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function general(){
        return $this->hasOne(General::class,'voucher_id','id')->where('form_id',1);
    }

    public function accountType(){
        return $this->belongsTo(AccountType::class,'account_type_id','id');
    }
    
}
