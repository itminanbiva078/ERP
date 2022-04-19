<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralLedger extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }


    public function scopeBalance($query)
    {
        return $query->selectRaw('sum(ifnull(debit,0)-ifnull(credit,0)) as balance');
    }
    public function account(){
        return $this->belongsTo(ChartOfAccount::class,'account_id','id');
    }


    public function general(){
        return $this->belongsTo(General::class,'general_id','id');
    }

    public function accountAmount(){
        return $this->belongsTo(General::class,'general_id','id');
    }

}
