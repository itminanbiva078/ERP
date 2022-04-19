<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class SalePayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sale_payments';

    public function scopeCompany($query)
    {
        return $query->where('sale_payments.company_id', Helper::companyId());
    }

    public function sale(){
        return $this->belongsTo(Sales::class,'voucher_id','id');
    }
    public function pos(){
        return $this->belongsTo(Pos::class,'voucher_id','id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function booking(){
        return $this->belongsTo(Booking::class,'voucher_id','id');
    }

}
