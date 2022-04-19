<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalYear extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='fiscal_years';

    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
