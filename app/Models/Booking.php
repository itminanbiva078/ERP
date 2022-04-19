<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class Booking extends Model
{
    use HasFactory; 
    use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
    public function bookingDetails(){
        return $this->hasOne(BookingDetails::class,'booking_id','id');
    }
    public function payments(){
        return $this->hasMany(SalePayment::class,'voucher_id','id')->where('form_id',18);
    }
    
   
   
}  
