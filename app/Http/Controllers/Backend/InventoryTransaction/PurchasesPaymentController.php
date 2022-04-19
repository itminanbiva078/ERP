<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesPaymentService;
use App\Transformers\PurchasesPaymentTransformer;

class PurchasesPaymentController extends Controller
{
    /**
     * @var PurchasesPaymentService
     */
    private $systemService;
    /**
     * @var PurchasesPaymentTransformer
     */
    private $systemTransformer;
    /**
     * PurchasesController constructor.
     *      
     * 
     * @param PurchasesPaymentService $systemService
     * @param PurchasesPaymentTransformer $systemTransformer
     */
    public function __construct(PurchasesPaymentService $purchasesPaymentService, PurchasesPaymentTransformer $purchasesPaymentTransformer)
    {
        $this->systemService = $purchasesPaymentService;
        $this->systemTransformer = $purchasesPaymentTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Purchases Payment List';
        $datatableRoute = 'inventoryTransaction.purchasesPayment.dataProcessingPurchasesPayment';
        return view('backend.pages.inventoryTransaction.purchasesPayment.index', get_defined_vars());
    }


    public function dataProcessingPurchasesPayment(Request $request)
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
      
        return view('backend.pages.inventoryTransaction.purchasesPayment.create', get_defined_vars());
    }

    public function supplierDueVoucherList(Request $request)
    {
        $dueVoucherList = $this->systemService->dueVoucherList($request->supplier_id);
        $returnHtml = view('backend.pages.inventoryTransaction.purchasesPayment.dueVoucherList', get_defined_vars())->render();
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

        if($request->payment_type == "Cash"): 
            return redirect()->route('inventoryTransaction.purchasesPayment.show',$result);
        else: 
            return redirect()->route('inventoryTransaction.purchases.pendingCheque.show',$result);
        endif;
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
        $title = 'Purchases Payment Money Receipt';
        $companyInfo =   helper::companyInfo();

       
        return view('backend.pages.inventoryTransaction.purchasesPayment.show', get_defined_vars());
    }

}