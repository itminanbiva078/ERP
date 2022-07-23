<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'suppliers';
    protected $guarded = array();


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }



    public function supplierType(){
        return $this->belongsTo(SupplierGroup::class,'supplier_type','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function ppayment()
    {
        return $this->hasMany(PurchasesPayment::class, 'supplier_id', 'id');
    }
    
    public function pcpayment()
    {
        return $this->hasMany(PurchasesPendingCheque::class, 'supplier_id', 'id');
    }
}