<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'services';
    protected $guarded = array();


    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_id', 'id');
    }
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
