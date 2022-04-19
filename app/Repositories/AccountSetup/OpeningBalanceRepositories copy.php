<?php

namespace App\Repositories\AccountSetup;

use App\Helpers\Helper;
use App\Models\CustomerOpening;
use App\Models\InventoryOpening;
use Illuminate\Support\Facades\Auth;
use App\Models\OpeningBalance;
use App\Models\SupplierOpening;

class OpeningBalanceRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var OpeningBalance
     */
    private $openingBalance;
    /**
     * openingBalanceRepositories constructor.
     * @param openingBalance $openingBalance
     */
    public function __construct(OpeningBalance $openingBalance)
    {
        $this->openingBalance = $openingBalance;
      
    }
    public function update($request)
    {
        $account_id = $request->account_id;
        $opening=array();
        if(!empty($account_id)):
            foreach($account_id as $key => $eachAccount):
                $each_balance['company_id']=helper::companyId();
                $each_balance['date']=date('Y-m-d',strtotime($request->date));
                $each_balance['account_id']=$eachAccount;
                $each_balance['debit']=$request->headDebit[$key];
                $each_balance['credit']=$request->headCredit[$key];
                array_push($opening,$each_balance);
            endforeach;
            $this->openingBalance::where('company_id',Helper::companyId())->delete();
            $saveInfo =  $this->openingBalance::insert($opening);
            return $saveInfo;
        endif;
       return false;
    }
    

    public function getAccountList()
    {
       return $this->openingBalance::where('company_id',Helper::companyId())->get();
    }


    public function inventoryBalance(){

       $inventoryBalance =  InventoryOpening::company()->sum('grand_total');
       return $inventoryBalance;
    }

    public function customerBalance(){

       $customerBalance =  CustomerOpening::company()->sum('total_balance');
       return $customerBalance;
    }

    public function supplierBalance(){

       $supplierBalance =  SupplierOpening::company()->sum('total_balance');
       return $supplierBalance;
    }


}