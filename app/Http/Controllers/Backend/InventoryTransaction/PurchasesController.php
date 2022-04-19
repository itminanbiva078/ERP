<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\PurchasesTransformer;

class PurchasesController extends Controller
{

    /**
     * @var PurchasesService
     */
    private $systemService;
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var PurchasesTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesController constructor.
     *      
     * 
     * * @param ProductService $productService
     * @param PurchasesService $systemService
     * @param PurchasesTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, PurchasesService $purchasesService, PurchasesTransformer $purchasesTransformer)

    {
        $this->productService = $productService;
        $this->systemService = $purchasesService;
        $this->systemTransformer = $purchasesTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Purchases List';
        $datatableRoute = 'inventoryTransaction.purchases.dataProcessingPurchases';
        return view('backend.pages.inventoryTransaction.purchases.index', get_defined_vars());
    }


    public function dataProcessingPurchases(Request $request)
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
        $title = 'Add New Purchases';
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchases.details.create');
        return view('backend.pages.inventoryTransaction.purchases.create', get_defined_vars());
    }

    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->purchasesDetails($request->purchases_id);
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchases.details.create');
        $returnHtml = view('backend.layouts.common.purchasesMrrAppend', get_defined_vars())->render();
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
        $checkResult = $this->systemService->checkPendingOrder($request);
        if($checkResult >= 1){
            session()->flash('error', $checkResult);
            return redirect()->route('inventoryTransaction.purchases.index');
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
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        
        $title = 'Purchases Edit';
        $invoiceDetails = $editInfo->purchasesDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchases.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchases.details.create');
        return view('backend.pages.inventoryTransaction.purchases.edit', get_defined_vars());
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

        $title = 'Purchases Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchases.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchases.details.create');
        return view('backend.pages.inventoryTransaction.purchases.show', get_defined_vars());
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo = $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        try {
            $this->validate($request, helper::isErrorUpdate($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('inventoryTransaction.purchases.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statusUpdate($id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function accountApproved(Request $request,$id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->accountApproved($id, $request);
        if ($statusInfo) {
           
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }


    
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchasesApproved(Request $request,$id, $status)
    {
       
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }
   

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }
}