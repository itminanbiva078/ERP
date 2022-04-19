<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

}
