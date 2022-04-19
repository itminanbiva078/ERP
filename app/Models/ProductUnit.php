<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_units';
    protected $guarded = array();

    public function products(){
        return $this->hasMany(Product::class, 'unit_id','id');
    }


    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
