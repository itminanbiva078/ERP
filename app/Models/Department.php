<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $guarded = array();

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
