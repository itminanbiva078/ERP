<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='branches';

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
    public function fiscal_years()
    {
        return $this->hasMany(FiscalYear::class);
    }
    public function suppliers()
    {
        return $this->hasMany(Supplier::class,'branch_id','id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class,'branch_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
