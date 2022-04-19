<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use helper;
use App\Services\InventoryTransaction\PurchasesRequsitionService;
use App\Services\InventorySetup\ProductService;

use App\Transformers\PurchasesRequsitionTransformer;

class PurchasesRequsitionController extends Controller
{

    /**
     * @var PurchasesRequsitionService
     */
    private $systemService;
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var PurchasesRequsitionTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesRequsitionController constructor.
     *      
     * 
     * * @param ProductService $productService
     * @param PurchasesRequsitionService $systemService
     * @param PurchasesRequsitionTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, PurchasesRequsitionService $purchasesRequsitionService, PurchasesRequsitionTransformer $purchasesRequsitionTransformer)

    {
        $this->productService = $productService;
        $this->systemService = $purchasesRequsitionService;
        $this->systemTransformer = $purchasesRequsitionTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Purchases Requisition List';
        $datatableRoute = 'inventoryTransaction.purchasesRequisition.dataProcessingpurchasesRequisition';
        return view('backend.pages.inventoryTransaction.purchasesRequisition.index', get_defined_vars());
    }


    public function dataProcessingpurchasesRequisition(Request $request)
    {
        $json_data = $this->systemService->getList($request);

        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $productListCategoryWise =  Category::select('id','name')->with(['products' =>function($query){
             $query->select('id','name')->where('status','Approved')->get();
          }])->get();

        $productListCategoryWise = Category::with('products')->get();
        $title = 'Add New Purchases Requisition';
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesRequisition.details.create');
        return view('backend.pages.inventoryTransaction.purchasesRequisition.create', get_defined_vars());
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
        if (is_integer($result)){
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('inventoryTransaction.purchasesRequisition.show',$result);
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

        $title = 'Purchases Requisition Edit';
        $invoiceDetails = $editInfo->requisitionDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesRequisition.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesRequisition.details.create');
        return view('backend.pages.inventoryTransaction.purchasesRequisition.edit', get_defined_vars());
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
        $title = 'Purchases Requisition Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesRequisition.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesRequisition.details.create');
       
        return view('backend.pages.inventoryTransaction.purchasesRequisition.show', get_defined_vars());
    }


    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->requisitionDetails($request->requisition_id);
        $details =   $this->systemService->details($request->requisition_id);
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesOrder.details.create');
        $returnHtml = view('backend.layouts.common.relationAppend', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml,'details'=>$details));
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
         $result = $this->systemService->update($request, $id);
         if (is_integer($result)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        } 

        return redirect()->route('inventoryTransaction.purchasesRequisition.show',$result);
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
  

    public function approved(Request $request,$id, $status)
    {

        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->approved($id, $request);
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
        $result =  $this->systemService->destroy($id);
        if ($result ===  true) {
            return response()->json($this->systemTransformer->delete($result), 200);
        }
    }
}
