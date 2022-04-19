<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customers';
    protected $guarded = array();

        public function branch()
        {
            return $this->belongsTo(Branch::class ,'branch_id', 'id');
        }
        public function store()
        {
            return $this->belongsTo(Store::class ,'store_id', 'id');
        }
        public function customerType()
        {
            return $this->belongsTo(CustomerGroup::class,'customer_type','id');
        }
        public function scopeCompany($query)
        {
            return $query->where('company_id', Helper::companyId());
        }
        public function spayment()
        {
            return $this->hasMany(SalePayment::class, 'customer_id', 'id');
        }
        public function scpayment()
        {
            return $this->hasMany(SalePendingCheque::class, 'customer_id', 'id');
        }

}
