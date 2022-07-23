<?php

namespace App\Http\Controllers\Backend\PurchasesReport;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\PurchasesReport\StockReportService;
use App\Transformers\StockReportTransformer;

class StockReport extends Controller
{

    /**
     * @var StockReportService
     */
    private $systemService;
    /**
     * @var StockReportTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param StockReportService $systemService
     * @param StockReportTransformer $systemTransformer
     */
    public function __construct(StockReportService $systemService, StockReportTransformer $accountReportTransformer)
    {
        $this->systemService = $systemService;
        $this->systemTransformer = $accountReportTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stockLedger(Request $request)
    {
        if($request->method() == 'POST'){

            $report_type = $request->stock_report_type;
            $branch_id = $request->branch_id ?? '';
            $store_id = $request->store_id ?? '';
            $category_id = $request->category_id ?? '';
            $batch_no = $request->batch_id ?? '';
            $product_id = $request->product_id ?? '';
            $brand_id = $request->brand_id ?? '';
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening="Opening";
            $oldValue = $request->all();

          

            if($report_type == "Stock Summary"){
                $reportTitle = "Stock Summary";
                $reports = $this->systemService->getStockSummary($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            }else if($report_type == "Stock Ledger"){
                $reportTitle = "Stock Ledger";
                $reports = $this->systemService->getStockLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            }else if($report_type == "Product Ledger"){
                $reportTitle = "Product Ledger";
                $reports = $this->systemService->getProductLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            
            }else if($report_type == "Purchases Ledger"){
                $reportTitle = "Purchases Ledger";
                $reports = $this->systemService->getPurchasesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            
            }else if($report_type == "Sales Ledger"){
                $reportTitle = "Sales Ledger";
                $reports = $this->systemService->getSalesedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            }else if($report_type == "Transfer Send Ledger"){
                $reportTitle = "Transfer Send Ledger";
                $reports = $this->systemService->getTransferSendLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
              
           
            }else if($report_type == "Purchases Return Ledger"){
                $reportTitle = "Purchases Return Ledger";
                $reports = $this->systemService->getPurchasesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
              
           
            }else if($report_type == "Sales Return Ledger"){
                $reportTitle = "Sales Return Ledger";
                $reports = $this->systemService->getSalesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
              
           
            }

        }
        $title = 'Stock  Ledger';
        $companyInfo =   helper::companyInfo();
        $formInput = helper::getColumnProperty('report_models',array('brand_id','store_id','category_id','product_id','batch_id','date_range','stock_report_type'));
        return view('backend.pages.purchasesReport.stockLedger', get_defined_vars());
    }

}
