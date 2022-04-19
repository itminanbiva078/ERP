<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class ChartOfAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function parent()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id', 'id');
    }
    
    public function childs()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id', 'id');
    }


    public function child()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id', 'id');
    }

    // recursive, loads all descendants
    public function children()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id', 'id');
    }

    //8,13,11,18

    public function getAllChildren()
    {
        $sections = new Collection();

        foreach ($this->child as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }

        return $sections;
    }


    // Recursive children
    public function childrens() {
        return $this->hasMany(ChartOfAccount::class, 'parent_id')->with('childrens')->latest();
    }
    


    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }

    public function childrenAccounts()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id', 'id');
    }

    public function allChildrenAccounts()
    {
        return $this->childrenAccounts()->with('allChildrenAccounts');
    }




    function getLedgerHead()
    {
        $ledgerParent = ChartOfAccount::select('parent_id')->where('is_posted', 1)->distinct()->get();
        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $ledgerParent = ChartOfAccount::where('id', $value->parent_id)->get();
            $accountLedger = ChartOfAccount::where('parent_id', $value->parent_id)->where('is_posted', 1)->get();
            $ledgerAccount[] = $ledgerParent;
            $ledgerAccount[$key][] = $accountLedger;
        }
        return $ledgerAccount;
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }

    public function accountType(){
        return $this->belongsTo(AccountType::class,'account_type_id','id');
    }



}