<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;
class Language extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
