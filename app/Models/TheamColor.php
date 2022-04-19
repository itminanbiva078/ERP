<?php

namespace App\Models;
use App\Helpers\Helper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheamColor extends Model
{
    use HasFactory;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
