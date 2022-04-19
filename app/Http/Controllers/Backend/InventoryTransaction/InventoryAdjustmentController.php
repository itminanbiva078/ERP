<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\InventoryAdjustmentService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\InventoryAdjustmentTransformer;

class InventoryAdjustmentController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var InventoryAdjustmentService
     */
    private $systemService;
    /**
     * @var InventoryAdjustmentTransformer
     */
    private $systemTransformer;

    /**
     * MaterialIssueController constructor.
     * @param InventoryAdjustmentService $systemService
     * @param InventoryAdjustmentTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, InventoryAdjustmentService $inventoryAdjustmentService, InventoryAdjustmentTransformer $inventoryAdjustmentTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $inventoryAdjustmentService;
        $this->systemTransformer = $inventoryAdjustmentTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Inventory Adjustment List';
       $datatableRoute = 'inventoryTransaction.inventoryAdjustment.dataProcessingInventoryAdjustment';
       return view('backend.pages.inventoryTransaction.inventoryAdjustment.index', get_defined_vars());
    }


    public function dataProcessingInventoryAdjustment(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $stock =   helper::getProductStock(1,2);
        $title = 'Add New Inventory Adjustment';
        $formInput =  helper::getFormInputByRoute();
        $batchList = $this->systemService->getActiveBatch();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.inventoryAdjustment.details.create');
        return view('backend.pages.inventoryTransaction.inventoryAdjustment.create', get_defined_vars());


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
        if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('inventoryTransaction.inventoryAdjustment.index',$result);
    }
/**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->inventoryAdjustmentDetails($request->inven_ad_id );
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $returnHtml = view('backend.layouts.common.salesAppend', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
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
        $title = 'Inventory Adjustment Edit';

        $invoiceDetails = $editInfo->inventoryAdjustmentDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.inventoryAdjustment.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.inventoryAdjustment.details.create');

        return view('backend.pages.inventoryTransaction.inventoryAdjustment.edit', get_defined_vars());
    }



       /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBatch(Request $request)
    {
        $productId = $request->product_id;
        $batchList =   helper::getActiveBatch($productId);
        return response()->json($this->systemTransformer->getList($batchList), 200);
       
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBatchStock(Request $request)
    {
        $productId = $request->product_id;
        $batchNo = $request->batch_no;
        $batchWiseStock =   helper::getActiveBatchStock($productId,$batchNo);
        return response()->json(array("stock" => $batchWiseStock));
       
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

        $title = 'Inventory Adjustment Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.inventoryAdjustment.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.inventoryAdjustment.details.create');
        return view('backend.pages.inventoryTransaction.inventoryAdjustment.show', get_defined_vars());
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
          if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('inventoryTransaction.inventoryAdjustment.show',$result);
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
