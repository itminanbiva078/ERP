<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class General extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function journals(){
        return $this->hasMany(GeneralLedger::class,'general_id','id');
    }

    public function stocks(){
        return $this->hasMany(Stock::class,'general_id','id');
    }
    
    public function purchase(){
        return $this->belongsTo(Purchases::class,'voucher_id','id');
    }

    public function sale(){
        return $this->belongsTo(Sales::class,'voucher_id','id');
    }

    public function paymentVoucher(){
        return $this->belongsTo(PaymentVoucher::class,'voucher_id','id');
    }

    public function receiveVoucher(){
        return $this->belongsTo(ReceiveVoucher::class,'voucher_id','id');
    }

    public function journalVoucher(){
        return $this->belongsTo(JournalVoucher::class,'voucher_id','id');
    }

    public function formType(){
        return $this->belongsTo(Form::class,'form_id','id');
    }
    public function inventoryAdjust(){
        return $this->belongsTo(InventoryAdjustment::class,'voucher_id','id')->where('form_id',16);
    }

}
