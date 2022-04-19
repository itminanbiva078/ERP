<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'customer_groups';
    protected $guarded = array();

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
