<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reference extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'references';
    protected $guarded = array();

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
