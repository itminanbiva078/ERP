<?php

namespace App\Repositories\AccountReport;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use App\Models\GeneralLedger;
use DB;

class AccountReportRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var AccountType
     */
    private $accountType;
    /**
     * CourseRepository constructor.
     * @param AccountType $accountType
     */
    public function __construct(AccountType $accountType)
    {
        $this->accountType = $accountType;
      
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAccountLedger($account_id,$from_date,$to_date)
    {
      
      $result =  GeneralLedger::with([
        'general' => function ($q) {
            $q->select('id', 'date', 'voucher_id',  'branch_id', 'form_id', 'debit', 'credit', 'note');
        }, 'general.purchase' => function ($q) {
            $q->select('id', 'date', 'voucher_no', 'supplier_id');
        },'general.purchase.supplier' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        }, 'general.sale' => function ($q) {
            $q->select('id', 'date', 'voucher_no', 'customer_id');
        },'general.sale.customer' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        }, 'general.paymentVoucher' => function ($q) {
            $q->select('id', 'voucher_no', 'date', 'customer_id', 'supplier_id','miscellaneous', 'debit', 'credit');
        },'general.paymentVoucher.customer' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        },'general.paymentVoucher.supplier' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        },'general.receiveVoucher' => function ($q) {
            $q->select('id', 'voucher_no', 'date', 'customer_id', 'supplier_id','miscellaneous', 'debit', 'credit');
        },'general.receiveVoucher.customer' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        },'general.receiveVoucher.supplier' => function ($q) {
            $q->select('id', 'code', 'name', 'email','phone');
        },'general.journalVoucher' => function ($q) {
            $q->select('id', 'voucher_no', 'date', 'customer_id', 'supplier_id','miscellaneous', 'debit', 'credit');
        }, 'general.journals.account' => function ($q) {
            $q->select('id', 'company_id', 'branch_id', 'parent_id', 'account_code', 'name', 'is_posted');
        },'general.formType' => function ($q) {
            $q->select('id', 'name');
        }
    ])->whereBetween('date', [$from_date, $to_date])->where('account_id',$account_id)->company()->get();
      return $result;
    }

    

}