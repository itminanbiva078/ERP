<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='products';
    protected $guarded = array();


    public function productDetails(){
        return $this->hasOne(ProductDetails::class,'product_id','id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id', 'id');
    }
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
    // Product Attribute
    public function productAttributes(){
        return $this->hasMany(ProductAttribute::class, 'product_attribute_id','id');
    }
    // Scope Of Company
    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}
