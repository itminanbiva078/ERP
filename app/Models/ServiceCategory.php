<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'service_categories';
    protected $guarded = array();

    public function sevices(){
        return $this->hasMany(Service::class,'service_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
