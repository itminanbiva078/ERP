<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Subscribe extends Model
{
    use HasFactory;
    
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
