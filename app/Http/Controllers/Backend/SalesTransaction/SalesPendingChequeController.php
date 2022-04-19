<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use App\Helpers\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesPendingChequeService;
use App\Transformers\SalesPendingChequeTransformer;

class SalesPendingChequeController extends Controller
{
    /**
     * @var SalePaymentService
     */
    private $systemService;
    /**
     * @var SalesPendingChequeTransformer
     */
    private $systemTransformer;
    /**
     * PurchasesController constructor.
     *      
     * 
     * @param SalesPendingChequeService $systemService
     * @param SalesPendingChequeTransformer $systemTransformer
     */
    public function __construct(SalesPendingChequeService $salesPendingChequeService, SalesPendingChequeTransformer $salesPendingChequeTransformer)
    {
        $this->systemService = $salesPendingChequeService;
        $this->systemTransformer = $salesPendingChequeTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Sale Pending Cheque List';
        $datatableRoute = 'salesTransaction.sales.pendingCheque.dataProcessingSalePendingCheque';
        return view('backend.pages.salesTransaction.salesPendingCheque.index', get_defined_vars());
    }


    public function dataProcessingSalePendingCheque(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $accountLedger = helper::getLedgerHead();
        $title = 'Add New Payment';
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.salesTransaction.salesPendingCheque.create', get_defined_vars());
    }
  

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
       $journalList =  Journal::getChildHeadList(8);

        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
       
        if(empty($posDetails)): 
            $details =  $this->systemService->posDetails($id);
        endif;

        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }

        $title = 'Sales Pending Cheque';
        $companyInfo =   helper::companyInfo();
      
        return view('backend.pages.salesTransaction.salesPendingCheque.show', get_defined_vars());
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
 
    public function salesPendingChequeApproved(Request $request,$id,$status)
    {

      

        if (!is_numeric($id)) {
            session()->flash('error', 'Approved id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        
        if(empty($posDetails)): 
            $details =  $this->systemService->posDetails($id);
        endif;

        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }
        $statusInfo =  $this->systemService->approvedCheque($id, $request);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
       
    }


}