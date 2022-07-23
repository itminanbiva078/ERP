<?php

namespace App\Http\Controllers\Backend\SalesReport;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesReport\SalesReportService;
use App\Transformers\SalesReportTransformer;

class SalesReport extends Controller
{

    /**
     * @var SalesReportService
     */
    private $systemService;
    /**
     * @var SalesReportTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param SalesReportService $systemService
     * @param SalesReportTransformer $systemTransformer
     */
    public function __construct(SalesReportService $systemService, SalesReportTransformer $accountReportTransformer)
    {

        $this->systemService = $systemService;
        $this->systemTransformer = $accountReportTransformer;
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stockReport(Request $request)
    {
        if($request->method() == 'POST'){
            $account_id = $request->account_id;
            $reportTitle = "Stock Report";
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening =  helper::getOpeningBalance($account_id,$from_date);
            $reportResult = $this->systemService->getAccountLedger($account_id,$from_date,$to_date);
        }
        $title = 'General Ledger';
        $companyInfo =   helper::companyInfo();
        $accountLedger = helper::getLedgerHead();
        $formInput = helper::getColumnProperty('report_models',array('account_id','date_range'));
        return view('backend.pages.accountReport.generalLedger', get_defined_vars());
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function customerLedger(Request $request)
    {

        if($request->method() == 'POST'){
            $report_type = $request->sale_report_type;
            $customer_id = $request->customer_id ?? '';
            $sr_id = $request->sr_id ?? '';
            $dateRange = $request->date_range;

            $from_to_date = explode("-",$dateRange);
            $reportTitle = "Customer Ledger";
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening="Opening";
            $oldValue = $request->all();
            if($report_type == "Ledger"){
                $reportTitle = "Customer Ledger";
                $opening = $this->systemService->getCustomerLedger($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerLedger($customer_id,$from_date,$to_date,$sr_id);

            }else if($report_type == "Ledger With Pending Cheque"){
                $reportTitle = "Customer Ledger With Pending Cheque";
                $opening = $this->systemService->getCustomerLedgerWithPendingCheque($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerLedgerWithPendingCheque($customer_id,$from_date,$to_date,$sr_id);
                $pendingReports = $this->systemService->getCustomerPendingCheque($customer_id,$from_date,$to_date,$sr_id);

            }else if($report_type == "Payment"){
                $reportTitle = "Customer Payment Ledger";
                $opening = $this->systemService->getCustomerPayment($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerPayment($customer_id,$from_date,$to_date,$sr_id);
            }else if($report_type == "Cash Payment"){
                $reportTitle = "Customer Cash Payment Ledger";
                $opening = $this->systemService->getCustomerCashPayment($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerCashPayment($customer_id,$from_date,$to_date,$sr_id);
            }else if($report_type == "Cheque Payment"){
                $reportTitle = "Customer Cheque Payment Ledger";
                $opening = $this->systemService->getCustomerChequePayment($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerChequePayment($customer_id,$from_date,$to_date,$sr_id);
            }else if($report_type == "Pending Cheque"){
                $reportTitle = "Customer Pending Cheque Ledger";
                $opening = $this->systemService->getCustomerPendingChequePayment($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerPendingChequePayment($customer_id,$from_date,$to_date,$sr_id);
            }else if($report_type == "Sale Voucher"){
                $reportTitle = "Customer Sale Ledger";
                $opening = $this->systemService->getCustomerSalesVoucher($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerSalesVoucher($customer_id,$from_date,$to_date,$sr_id);
            }else if($report_type == "Due Sale Voucher"){
                $reportTitle = "Customer Due Sale Ledger";
                $opening = $this->systemService->getCustomerDueSalesVoucher($customer_id,$from_date,$opening,$sr_id);
                $reports = $this->systemService->getCustomerDueSalesVoucher($customer_id,$from_date,$to_date,$sr_id);
            }

        }

        $title = 'Customer Ledger';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('customer_id','sr_id','sale_report_type','date_range'));
        return view('backend.pages.salesReport.customerLedger', get_defined_vars());
    }




}
