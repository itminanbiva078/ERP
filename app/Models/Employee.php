<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'employees';
    protected $guarded = array();


    public function branch(){
        return $this->belongsTo(Branch::class ,'branch_id', 'id');
    }
    
    public function store(){
        return $this->belongsTo(Store::class ,'store_id', 'id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
