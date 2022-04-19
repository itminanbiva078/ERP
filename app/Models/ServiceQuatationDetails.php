<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceQuatationDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function sevice(){
        return $this->belongsTo(Service::class,'service_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
