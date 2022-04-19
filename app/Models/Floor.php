<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table= 'floors';
    protected $guarded = array();

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }


    public function products(){
        return $this->hasMany(Product::class,'floor_id','id')->where('type_id','Rooms');
    }


}
