<?php

namespace App\Http\Controllers\Backend\SalesReport;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesReport\SaleStockReportService;
use App\Transformers\SaleStockReportTransformer;

class SalesStockReport extends Controller
{

    /**
     * @var SaleStockReportService
     */
    private $systemService;
    /**
     * @var SaleStockReportTransformer
     */
    private $systemTransformer;

    /**
     * SalesStockReport constructor.
     * @param SaleStockReportService $systemService
     * @param SaleStockReportTransformer $systemTransformer
     */
    public function __construct(SaleStockReportService $systemService, SaleStockReportTransformer $accountReportTransformer)
    {
        $this->systemService = $systemService;
        $this->systemTransformer = $accountReportTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function saleLedger(Request $request)
    {
       
        if($request->method() == 'POST'){
            $report_type = $request->sales_report_type;
            $branch_id = $request->branch_id ?? '';
            $store_id = $request->store_id ?? '';
            $category_id = $request->category_id ?? '';
            $batch_no = $request->batch_id ?? '';
            $product_id = $request->product_id ?? '';
            $brand_id = $request->brand_id ?? '';
            $customer_id = $request->customer_id ?? '';
            $sr_id = $request->sr_id ?? '';
            $dateRange = $request->date_range;
            $from_to_date = explode("-",$dateRange);
            $from_date = date('Y-m-d',strtotime($from_to_date[0]));
            $to_date = date('Y-m-d',strtotime($from_to_date[1]));
            $opening="Opening";
            $oldValue = $request->all();

            if($report_type == "Sales Ledger"){
                $reportTitle = "Sales Ledger";
                $reports = $this->systemService->getSalesedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);
            }else if($report_type == "Sales Return Ledger"){
                $reportTitle = "Sales Return Ledger";
                $reports = $this->systemService->getSalesReturnLedger($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date);
            }else if($report_type == "Top Customer Sales"){
                $reportTitle = "Top Customer Sale";
                $reports = $this->systemService->getTopCustomerSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id);

            }else if($report_type == "Top Product Sales"){
                $reportTitle = "Top Product Sales";
                $reports = $this->systemService->getTopProductSale($branch_id,$store_id,$category_id,$product_id,$batch_no,$brand_id,$from_date,$to_date,$customer_id);

            }else if($report_type == "Sales Loan Ledger"){
                $reportTitle = "Sales Loan Ledger";
                $reports = $this->systemService->getSaleLoansedger($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);

            } else if($report_type == "Net Sales Ledger"){
                $reportTitle = "Net Sales Ledger";
                $reports = $this->systemService->getSalesedgerWithReturn($branch_id,$store_id,$category_id,$product_id,$customer_id,$sr_id,$batch_no,$brand_id,$from_date,$to_date);

            }
           


        }
        $title = 'Sales  Ledger';
        $companyInfo =   helper::companyInfo();

        $formInput = helper::getColumnProperty('report_models',array('brand_id','store_id','category_id','product_id','batch_id','date_range','customer_id','sr_id','sales_report_type'));
        return view('backend.pages.salesReport.salesLedger', get_defined_vars());
    }

}
