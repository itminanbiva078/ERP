<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceInvoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function serviceInvoiceDetails(){
        return $this->hasMany(ServiceInvoiceDetails::class,'service_invoice_id','id');
       }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id')->select('id','name');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}

