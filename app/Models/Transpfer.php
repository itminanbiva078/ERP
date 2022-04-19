<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transpfer extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function transferDetails(){
     return $this->hasMany(TransferDetails::class,'transfer_id','id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function fBranch(){
        return $this->belongsTo(Branch::class,'from_branch_id','id');
    }
    public function fStore(){
        return $this->belongsTo(Store::class,'from_store_id','id');
    }

    public function tBranch(){
        return $this->belongsTo(Branch::class,'to_branch_id','id');
    }

    public function tStore(){
        return $this->belongsTo(Store::class,'to_store_id','id');
    }

}
