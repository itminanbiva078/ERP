<?php
namespace App\Helpers;

use DB;
use App\Helpers\Helper;
use App\Models\ChartOfAccount;
use App\Models\General;
use App\Models\GeneralLedger;
use App\Models\OpeningBalance;
use PHPUnit\TextUI\Help;
use Illuminate\Support\Facades\Route;
class Journal
{


    public $parents=[];


    public static function purchasesCreditJournal($masterLedgerId,$date)
    {

      $generalId =   General::where("id",$masterLedgerId)->company()->first();
        //account payable = credit
        $accountPayable = new GeneralLedger();
        $accountPayable->company_id = helper::companyId();
        $accountPayable->general_id = $masterLedgerId;
        $accountPayable->form_id = 4;
        $accountPayable->account_id = 38; //account payable come from chartOfAccount
        $accountPayable->date = helper::mysql_date($date);
        $accountPayable->credit = $generalId->debit;
        $accountPayable->memo = 'Account Payable';
        $accountPayable->created_by = helper::userId();
        $accountPayable->save();
        //purchases stock or inventory stock = debit
        $purchases = new GeneralLedger();
        $purchases->company_id = helper::companyId();
        $purchases->general_id = $masterLedgerId;
        $purchases->form_id = 4;
        $purchases->account_id = 4; //purchases stock or inventory stock
        $purchases->date = helper::mysql_date($date);
        $purchases->debit = $generalId->debit;
        $purchases->memo = 'Purchases Stock';
        $purchases->created_by = helper::userId();
        $purchases->save();
    }


    public static function purchasesPaymentJournal($masterLedgerId,$payment,$cash_account_id=null,$date)
    {
        $generalId =   General::where("voucher_id",$masterLedgerId)->where('form_id',4)->company()->first();
        //account payable = debit
        $accountPayable = new GeneralLedger();
        $accountPayable->company_id = helper::companyId();
        $accountPayable->general_id = $generalId->id;
        $accountPayable->form_id = 4;
        $accountPayable->account_id = 38; //account payable come from chartOfAccount
        $accountPayable->date = helper::mysql_date($date);
        $accountPayable->debit = $payment;
        $accountPayable->memo = 'Account Payable';
        $accountPayable->created_by = helper::userId();
        $accountPayable->save();
        //cash or bank = credit
        $cashOrBank = new GeneralLedger();
        $cashOrBank->company_id = helper::companyId();
        $cashOrBank->general_id =  $generalId->id;
        $cashOrBank->form_id = 4;
        $cashOrBank->account_id = $cash_account_id; //purchases stock or inventory stock
        $cashOrBank->date = helper::mysql_date($date);
        $cashOrBank->credit = $payment;
        $cashOrBank->memo = 'Purchases payment';
        $cashOrBank->created_by = helper::userId();
        $cashOrBank->save();
    }


    public static function saleCreditJournal($masterLedgerId,$costOfGoods=null)
    {
        $generalId =   General::where("id",$masterLedgerId)->company()->first();
        //account Receiable = debit
        $accountReceiveable = new GeneralLedger();
        $accountReceiveable->company_id = helper::companyId();
        $accountReceiveable->general_id = $masterLedgerId;
        $accountReceiveable->form_id = 5;
        $accountReceiveable->account_id = 12; //account receiveable come from chartOfAccount
        $accountReceiveable->date = helper::mysql_date();
        $accountReceiveable->debit = $generalId->debit;
        $accountReceiveable->memo = 'Account Receivable';
        $accountReceiveable->created_by = helper::userId();
        $accountReceiveable->save();
        //sales = credit
        $sales = new GeneralLedger();
        $sales->company_id = helper::companyId();
        $sales->general_id = $masterLedgerId;
        $sales->form_id = 5;
        $sales->account_id = 44; //sales
        $sales->date = helper::mysql_date();
        $sales->credit = $generalId->debit;
        $sales->memo = 'Sales';
        $sales->created_by = helper::userId();
        $sales->save();
        //purchases = credit
        $purchases = new GeneralLedger();
        $purchases->company_id = helper::companyId();
        $purchases->general_id = $masterLedgerId;
        $purchases->form_id = 5;
        $purchases->account_id = 4; //purchases
        $purchases->date = helper::mysql_date();
        $purchases->credit = $costOfGoods;
        $purchases->memo = 'Purchases';
        $purchases->created_by = helper::userId();
        $purchases->save();
        //cost of good sold = debit
        $costOfGoodSols = new GeneralLedger();
        $costOfGoodSols->company_id = helper::companyId();
        $costOfGoodSols->general_id = $masterLedgerId;
        $costOfGoodSols->form_id = 5;
        $costOfGoodSols->account_id = 52; //purchases stock or inventory stock
        $costOfGoodSols->date = helper::mysql_date();
        $costOfGoodSols->debit = $costOfGoods;
        $costOfGoodSols->memo = 'Cost Of Goods Sold';
        $costOfGoodSols->created_by = helper::userId();
        $costOfGoodSols->save();
    }

    public static function inventoryAdjustmentJournal($masterLedgerId,$date)
    {

        $generalId =   General::where("id",$masterLedgerId)->company()->first();
        //account Receiable = debit
        $materialIssue = new GeneralLedger();
        $materialIssue->company_id = helper::companyId();
        $materialIssue->general_id = $masterLedgerId;
        $materialIssue->form_id = 16;
        $materialIssue->account_id = 55; //work in process
        $materialIssue->date = helper::mysql_date($date);
        $materialIssue->debit = $generalId->debit;
        $materialIssue->memo = 'inventory adjustment loss';
        $materialIssue->created_by = helper::userId();
        $materialIssue->save();
        //consultancy = credit
        $inventoryStock = new GeneralLedger();
        $inventoryStock->company_id = helper::companyId();
        $inventoryStock->general_id = $masterLedgerId;
        $inventoryStock->form_id = 16;
        $inventoryStock->account_id = 4; //inventory stock
        $inventoryStock->date = helper::mysql_date($date);
        $inventoryStock->credit = $generalId->debit;
        $inventoryStock->memo = 'inventory adjustment Deduct';
        $inventoryStock->created_by = helper::userId();
        $inventoryStock->save();
        return true;

    }

    public static function salePaymentJournal($masterLedgerId,$paidAmount,$accountId,$date,$from_id=null)
    {

        //account receivable = credit
        $accountReceiveable = new GeneralLedger();
        $accountReceiveable->company_id = helper::companyId();
        $accountReceiveable->general_id = $masterLedgerId;
        $accountReceiveable->form_id = $from_id;
        $accountReceiveable->account_id = 12; //account receiable come from chartOfAccount
        $accountReceiveable->date = helper::mysql_date($date);
        $accountReceiveable->credit = $paidAmount;
        $accountReceiveable->memo = 'Account Receivable';
        $accountReceiveable->created_by = helper::userId();
        $accountReceiveable->save();
        //cash or bank = debit
        $cashOrBank = new GeneralLedger();
        $cashOrBank->company_id = helper::companyId();
        $cashOrBank->general_id = $masterLedgerId;
        $cashOrBank->form_id = $from_id;
        $cashOrBank->account_id = $accountId; //cash in hand
        $cashOrBank->date = helper::mysql_date($date);
        $cashOrBank->debit = $paidAmount;
        $cashOrBank->memo = 'Cash or bank debit';
        $cashOrBank->created_by = helper::userId();
        $cashOrBank->save();
    }

    public static function salesLoanLedgerSave($masterLedgerId,$paidAmount,$accountId,$date,$from_id=null)
    {
        //loan stock = debit
        $loanStock = new GeneralLedger();
        $loanStock->company_id = helper::companyId();
        $loanStock->general_id = $masterLedgerId;
        $loanStock->form_id = $from_id;
        $loanStock->account_id = 88; //cash in hand
        $loanStock->date = helper::mysql_date($date);
        $loanStock->debit = $paidAmount;
        $loanStock->memo = 'Loan Stock';
        $loanStock->created_by = helper::userId();
        $loanStock->save();
        //inventory stock = credit
        $inventoryStock = new GeneralLedger();
        $inventoryStock->company_id = helper::companyId();
        $inventoryStock->general_id = $masterLedgerId;
        $inventoryStock->form_id = $from_id;
        $inventoryStock->account_id = 4; //inventory stock come from chartOfAccount
        $inventoryStock->date = helper::mysql_date($date);
        $inventoryStock->credit = $paidAmount;
        $inventoryStock->memo = 'Inventory Stock';
        $inventoryStock->created_by = helper::userId();
        $inventoryStock->save();
       
    }
    
    public static function salesLoanReturnLedgerSave($masterLedgerId,$paidAmount,$date,$from_id=null)
    {
        //loan stock = credit
        $loanStock = new GeneralLedger();
        $loanStock->company_id = helper::companyId();
        $loanStock->general_id = $masterLedgerId;
        $loanStock->form_id = $from_id;
        $loanStock->account_id = 88; //cash in hand
        $loanStock->date = helper::mysql_date($date);
        $loanStock->credit = $paidAmount;
        $loanStock->memo = 'Loan Stock';
        $loanStock->created_by = helper::userId();
        $loanStock->save();
        //inventory stock = debit
        $inventoryStock = new GeneralLedger();
        $inventoryStock->company_id = helper::companyId();
        $inventoryStock->general_id = $masterLedgerId;
        $inventoryStock->form_id = $from_id;
        $inventoryStock->account_id = 4; //inventory stock come from chartOfAccount
        $inventoryStock->date = helper::mysql_date($date);
        $inventoryStock-> debit = $paidAmount;
        $inventoryStock->memo = 'Inventory Stock';
        $inventoryStock->created_by = helper::userId();
        $inventoryStock->save();
        
      
    }
    public static function openingInventoryJournal($masterLedgerId,$date,$paidAmount)
    {
        //account receivable = credit
        $accountReceiveable = new GeneralLedger();
        $accountReceiveable->company_id = helper::companyId();
        $accountReceiveable->general_id = $masterLedgerId;
        $accountReceiveable->form_id = 5;
        $accountReceiveable->account_id = 12; //account receiable come from chartOfAccount
        $accountReceiveable->date = helper::mysql_date($date);
        $accountReceiveable->credit = $paidAmount;
        $accountReceiveable->memo = 'Account Receivable';
        $accountReceiveable->created_by = helper::userId();
        $accountReceiveable->save();

    }


    public static function accountAmount($account,$from_date,$to_date=null,$optional=null){

        if(empty($to_date) && $optional == "liability"):
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(credit,0)-ifnull(debit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->where('date', "<=",helper::mysql_date($from_date))->first();
        elseif(!empty($to_date) && $optional == "liability"):
        $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(credit,0)-ifnull(debit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->first();
       
        elseif(!empty($to_date) && empty($optional)):
           
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->first();
        else:
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->where('date', "<=",helper::mysql_date($from_date))->first();
        endif;
       return $amount;
    }

    
    public static function accountAmount2($account,$from_date,$to_date=null,$optional=null){

        if(empty($to_date) && $optional == "liability"):
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(credit,0)-ifnull(debit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->where('date', "<",helper::mysql_date($from_date))->first();
        elseif(!empty($to_date) && $optional == "liability"):
           
        $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(credit,0)-ifnull(debit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->first();
       
        elseif(!empty($to_date) && empty($optional)):   
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->first();
        else:
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$account)->where('date', "<",helper::mysql_date($from_date))->first();
        endif;
       return $amount;
    }

    public static function accountBalance($accountId){

            $openingBalance =  self::getOpBalance($accountId);
            $amount =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->where('account_id',$accountId)->first();
           return $amount->balance + $openingBalance;
    }


    public static function getChildList($parent_id,$from_date,$to_date=null,$optional=null){

        $allAccountHead =  ChartOfAccount::where('id',$parent_id)->first();
        $allChild = $allAccountHead->getAllChildren()->pluck('id');
        $allHead = self::getLedgerHead($allChild,$from_date,$to_date,$optional);
       return $allHead;

    }


    public static function getOpBalance($accountId){

      $openingBalance =   OpeningBalance::where('account_id',$accountId)->company()->first();
      $debit =  $openingBalance->debit ?? 0;
      $credit = $openingBalance->credit ?? 0;
      $balance = $debit+$credit;
      return $balance;

    }


    public static function getLedgerHead($ids,$from_date=null,$to_date=null,$optional=null)
    {
        if(!empty($optional) && is_int($optional)):
            $ledgerParent = ChartOfAccount::select('parent_id')->whereIn('id',$ids)->company()->where('is_posted', 1)->where('parent_id','!=',$optional)->distinct()->get();
        else:
            $ledgerParent = ChartOfAccount::select('parent_id')->whereIn('id',$ids)->company()->where('is_posted', 1)->distinct()->get();
        endif;

        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $index=array();
            $index['parent'] = ChartOfAccount::select('name', 'id','parent_id')->company()->where('id', $value->parent_id)->first();
            $data = ChartOfAccount::select('name', 'id','parent_id')->company()->where('parent_id', $value->parent_id)->where('is_posted', 1)->get();
            $data->map(function ($d) use($from_date,$to_date,$optional) {


                    // $balanceInfo =  self::accountAmount($d->id,$from_date,$to_date,$optional);
                    // $openingInfo=  self::accountAmount($d->id,$from_date);

                    if(Route::currentRouteName() == "accountReport.trialBalance"):
                        $balanceInfo =  self::accountAmount2($d->id,$from_date,$to_date,$optional);
                        $openingInfo=  self::accountAmount2($d->id,$from_date);
                    else:
                        $balanceInfo =  self::accountAmount($d->id,$from_date,$to_date,$optional);
                        $openingInfo=  self::accountAmount($d->id,$from_date);
        
                    endif;

                    $opening = self::getOpBalance($d->id);

                    $d['balance']=$balanceInfo->balance+$opening;
                    $d['balance_debit']=$balanceInfo->debit;
                    $d['balance_credit']=$balanceInfo->credit;

                    $d['opening']=$openingInfo->balance;
                    $d['opening_debit']=$openingInfo->debit;
                    $d['opening_credit']=$openingInfo->credit;
                    $d['final_balance'] = $balanceInfo->balance+$openingInfo->balance;

                return $d;
            });
            $balance = 0;
            $balance_debit = 0;
            $balance_credit = 0;
            $opening = 0;
            $opening_debit = 0;
            $opening_credit = 0;
            $final_balance=0;
            foreach($data as $value):

                    $opening = self::getOpBalance($value->id);
                    $balanceInfo =  self::accountAmount($value->id,$from_date,$to_date,$optional);
                    $openingInfo=  self::accountAmount($value->id,$from_date);

                    $balance+=$balanceInfo->balance+$opening;
                    $balance_debit+=$balanceInfo->debit;
                    $balance_credit+=$balanceInfo->credit;
                    $opening+=$openingInfo->balance;
                    $opening_debit+=$openingInfo->debit;
                    $opening_credit+=$openingInfo->credit;
                    $final_balance+=$balanceInfo->balance+$openingInfo->balance;

            endforeach;
            $index['opening'] = $opening;
            $index['opening_debit'] = $opening_debit;
            $index['opening_credit'] = $opening_credit;
            $index['balance'] = $balance;
            $index['final_balance'] = $final_balance;
            $index['balance_debit'] = $balance_debit;
            $index['balance_credit'] = $balance_credit;
            $index['parentChild'] = $data;
            array_push($ledgerAccount,$index);
        }
        return $ledgerAccount;
    }



    public static function getChildHeadList($parent_id,$optional=null){

        $allAccountHead =  ChartOfAccount::where('id',$parent_id)->first();
        $allChild = $allAccountHead->getAllChildren()->pluck('id');
        if(!empty($optional) && is_int($optional)):
            $ledgerParent = ChartOfAccount::select('parent_id')->whereIn('id',$allChild)->company()->where('is_posted', 1)->where('parent_id','!=',$optional)->distinct()->get();
        else:
            $ledgerParent = ChartOfAccount::select('parent_id')->whereIn('id',$allChild)->company()->where('is_posted', 1)->distinct()->get();
        endif;

        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $index=array();
            $index['parent'] = ChartOfAccount::select('name', 'id','parent_id')->company()->where('id', $value->parent_id)->first();
            $index['parentChild'] = ChartOfAccount::select('name', 'id','parent_id')->company()->where('parent_id', $value->parent_id)->where('is_posted', 1)->get();
            array_push($ledgerAccount,$index);
        }
        return $ledgerAccount;

    }


    public static function incomeStatement($from_date){

        $salesLedger = self::getChildList(41,$from_date);
        $expenseLedger = self::getChildList(50,$from_date,null,51);
        $costOfGoodsLedger = self::getChildList(51,$from_date);

        $sub_total_sales=0;
        $sub_total_cost_of_goods=0;
        $sub_total_expense=0;

        foreach($salesLedger as $key => $value):
          if($value['balance'] > 0):
                $sub_total_sales+=$value['balance'];
          endif;
        endforeach;
        foreach($costOfGoodsLedger as $key => $value):
           if($value['balance'] > 0):
            $sub_total_cost_of_goods+=$value['balance'];
           endif;
        endforeach;

        $grossProfit =  $sub_total_sales-$sub_total_cost_of_goods;
        foreach($expenseLedger as $key => $value):
            if($value['balance'] > 0):
            $sub_total_expense+=$value['balance'];
            endif;
        endforeach;
        $netProfit = $grossProfit-$sub_total_expense;


        return $netProfit;


    }



    public static function getAllJournal($from_date,$to_date){

        $allJournal =  GeneralLedger::selectRaw('ABS(sum(ifnull(debit,0)-ifnull(credit,0))) as balance,ABS(sum(debit)) as debit,ABS(sum(credit)) as credit')->company()->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->groupBy('general_id')->get();

        return $allJournal;


    }

    public static function journalCheck($from_date,$to_date=null){

        $journalLedger =   General::with(['formType','purchase','inventoryAdjust','sale','paymentVoucher','receiveVoucher','journalVoucher','journals','salesReturn' => function($q){
                             $q->select("*")->company()->get();
                         },'journals.account' => function($q){
                             $q->select('*');
                         }])->whereBetween('date', [helper::mysql_date($from_date), helper::mysql_date($to_date)])->company()->get();
         $journalLedger->map(function($data){
             $total_debit = 0;
             $total_credit = 0;
             foreach($data->journals as $eky => $eachLedger):
                 $total_debit+=$eachLedger->debit;
                 $total_credit+=$eachLedger->credit;
             endforeach;
             $data['total_debit_amount'] = $total_debit;
             $data['total_credit_amount'] = $total_credit;
             return $data;
         });

     return $journalLedger;

     }
















}
