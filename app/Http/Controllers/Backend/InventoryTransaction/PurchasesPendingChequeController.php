<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use App\Helpers\Helper as HelpersHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesPendingChequeService;
use App\Transformers\PurchasesPendingChequeTransformer;

class PurchasesPendingChequeController extends Controller
{
    /**
     * @var PurchasesPaymentService
     */
    private $systemService;
    /**
     * @var PurchasesPendingChequeTransformer
     */
    private $systemTransformer;
    /**
     * PurchasesController constructor.
     *      
     * 
     * @param PurchasesPendingChequeService $systemService
     * @param PurchasesPendingChequeTransformer $systemTransformer
     */
    public function __construct(PurchasesPendingChequeService $purchasesPendingChequeService, PurchasesPendingChequeTransformer $purchasesPendingChequeTransformer)
    {
        $this->systemService = $purchasesPendingChequeService;
        $this->systemTransformer = $purchasesPendingChequeTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Purchases Pending Cheque List';
        $columns = helper::getTableProperty();
        $datatableRoute = 'inventoryTransaction.purchases.pendingCheque.dataProcessingPurchasesPendingCheque';
        return view('backend.pages.inventoryTransaction.purchasesPendingCheque.index', get_defined_vars());
    }


    public function dataProcessingPurchasesPendingCheque(Request $request)
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
        return view('backend.pages.inventoryTransaction.purchasesPendingCheque.create', get_defined_vars());
    }

    public function supplierDueVoucherList(Request $request)
    {
        $dueVoucherList = $this->systemService->dueVoucherList($request->supplier_id);
        $returnHtml = view('backend.pages.inventoryTransaction.purchasesPendingCheque.dueVoucherList', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $result = $this->systemService->store($request);
        if (is_integer($result)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('inventoryTransaction.purchases.show',$result);
    }
    

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }

        $title = 'Purchases Pending Cheque';
        $companyInfo =   helper::companyInfo();
      
        return view('backend.pages.inventoryTransaction.purchasesPendingCheque.show', get_defined_vars());
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchasesPendingChequeApproved(Request $request,$id,$status)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Approved id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
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