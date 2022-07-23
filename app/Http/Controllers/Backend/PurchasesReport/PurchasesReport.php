<?php

namespace App\Http\Controllers\Backend\PurchasesReport;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\PurchasesReport\PurchasesReportService;
use App\Transformers\PurchasesReportTransformer;

class PurchasesReport extends Controller
{

    /**
     * @var PurchasesReportService
     */
    private $systemService;
    /**
     * @var PurchasesReportTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param PurchasesReportService $systemService
     * @param PurchasesReportTransformer $systemTransformer
     */
    public function __construct(PurchasesReportService $systemService, PurchasesReportTransformer $accountReportTransformer)
    {

        $this->systemService = $systemService;
        $this->systemTransformer = $accountReportTransformer;
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function supplierLedger(Request $request)
    {
        if($request->method() == 'POST'){

            $report_type = $request->purhcases_report_type;
            $suppplier_id = $request->supplier_id;
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening = "Opening";
            $oldValue = $request->all();

            if($report_type == "Ledger"){
                $reportTitle = "Supplier Ledger";
                $opening = $this->systemService->getSupplierLedger($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierLedger($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Payment"){
                $reportTitle = "Supplier Payment Ledger";
                $opening = $this->systemService->getSupplierPayment($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierPayment($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Cash Payment"){
                $reportTitle = "Supplier Cash Payment Ledger";
                $opening = $this->systemService->getSupplierCashPayment($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierCashPayment($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Cheque Payment"){
                $reportTitle = "Supplier Cheque Payment Ledger";
                $opening = $this->systemService->getSupplierChequePayment($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierChequePayment($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Pending Cheque"){
                $reportTitle = "Supplier Pending Cheque Ledger";
                $opening = $this->systemService->getSupplierPendingChequePayment($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierPendingChequePayment($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Purchases Voucher"){
                $reportTitle = "Supplier Purchases Ledger";
                $opening = $this->systemService->getSupplierPurchasesVoucher($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierPurchasesVoucher($suppplier_id,$from_date,$to_date);
            }else if($report_type == "Due Purchases Voucher"){
                $reportTitle = "Supplier Due Purchases Ledger";
                $opening = $this->systemService->getSupplierDuePurchasesVoucher($suppplier_id,$from_date,$opening);
                $reports = $this->systemService->getSupplierDuePurchasesVoucher($suppplier_id,$from_date,$to_date);
            }

        }
        $title = 'Supplier Ledger';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('supplier_id','purhcases_report_type','date_range'));
        return view('backend.pages.purchasesReport.supplierLedger', get_defined_vars());
    }





}
