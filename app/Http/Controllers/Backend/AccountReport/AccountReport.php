<?php

namespace App\Http\Controllers\Backend\AccountReport;

use App\Helpers\Helper as HelpersHelper;
use App\Helpers\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use helper;
use App\Services\AccountReport\AccountReportService;
use App\Transformers\AccountReportTransformer;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class AccountReport extends Controller
{

    /**
     * @var JournalVoucherService
     */
    private $systemService;
    /**
     * @var AccountReportTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param JournalVoucherService $systemService
     * @param AccountReportTransformer $systemTransformer
     */
    public function __construct(AccountReportService $systemService, AccountReportTransformer $AccountReportTransformer)
    {

        $this->systemService = $systemService;
        $this->systemTransformer = $AccountReportTransformer;
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generalLedger(Request $request)
    {
        if($request->method() == 'POST'){

            $account_id = $request->account_id;
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening =  helper::getOpeningBalance($account_id,$from_date);
            $oldValue = $request->all();
            $reportTitle='General Ledger';
            $reportResult = $this->systemService->getAccountLedger($account_id,$from_date,$to_date);
        }
        $companyInfo =   helper::companyInfo();
        $title = 'General Ledger';
        $reportTitle = 'General Ledger';
        $accountLedger = helper::getLedgerHead();
        $formInput = helper::getColumnProperty('report_models',array('account_id','date_range'));
        return view('backend.pages.accountReport.generalLedger', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
 

    public function trialBalance(Request $request)
    {
       
        if($request->method() == 'POST'){

            $account_id = $request->account_id;
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $oldValue = $request->all();
            $assetLedger = Journal::getChildList(2,$from_date,$to_date);
            //dd($assetLedger );
            $liabilityLedger = Journal::getChildList(31,$from_date,$to_date,'liability');
            $incomeLedger = Journal::getChildList(41,$from_date,$to_date);
            $expenseLedger = Journal::getChildList(50,$from_date,$to_date);
           
        }
        $title = 'Trial Balance';
        $reportTitle='Trial Balance';
        $accountLedger = helper::getLedgerHead();
        $formInput = helper::getColumnProperty('report_models',array('date_range'));
        return view('backend.pages.accountReport.trialBalance', get_defined_vars());
        
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function balanceSheet(Request $request)
    {

        if($request->method() == 'POST'){
            $from_date = date('Y-m-d',strtotime($request->date));
            $reportTitle = 'Balance Sheet';
            /*balance sheet start*/
            $assetLedger = Journal::getChildList(2,$from_date);
            $liabilityLedger = Journal::getChildList(31,$from_date,null,'liability');
            /*balance sheet end*/
            /*income statement start*/
            $profitOrLoss = Journal::incomeStatement($from_date);
            /*income statement end*/
            $oldValue = $request->all();
        }

        $title = 'Balance Sheet';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('date'));
        return view('backend.pages.accountReport.balanceSheet', get_defined_vars());
    }

     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */



    public function incomeStatement(Request $request)
    {

       
        if($request->method() == 'POST'){
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $reportTitle = 'Income Statement';
            $salesLedger = Journal::getChildList(41,$from_date,$to_date);
            $expenseLedger = Journal::getChildList(50,$from_date,$to_date,51);
            $costOfGoodsLedger = Journal::getChildList(51,$from_date,$to_date);
            $oldValue = $request->all();
        }


       
        $title = 'Income Statement';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('date_range'));
        return view('backend.pages.accountReport.incomeStatement', get_defined_vars());
    }


    public function journalCheck(Request $request)
    {
        if($request->method() == 'POST'){
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $reportTitle = 'All Journal Ledger';
          
            $journalCheck = Journal::journalCheck($from_date,$to_date);
            $oldValue = $request->all();
        }

        $title = 'journal Check';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('date_range'));
        return view('backend.pages.accountReport.journalCheck', get_defined_vars());
    }

    


}
