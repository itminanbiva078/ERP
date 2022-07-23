<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\SalesTransformer;

class SalesController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var SalesService
     */
    private $systemService;
    /**
     * @var SalesTransformer
     */
    private $systemTransformer;

    /**
     * SalesController constructor.
     * @param SalesService $systemService
     * @param SalesTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, SalesService $salesService, SalesTransformer $salesTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $salesService;
        $this->systemTransformer = $salesTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Sales List';
       $companyInfo =   helper::companyInfo();
       $datatableRoute = 'salesTransaction.sales.dataProcessingSales';
       return view('backend.pages.salesTransaction.sales.index', get_defined_vars());
    }


    public function dataProcessingSales(Request $request)
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
        $title = 'Add New Sales';
        $formInput =  helper::getFormInputByRoute();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $companyInfo =   helper::companyInfo();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.sales.details.create');
        $batchList = $this->systemService->getActiveBatch();
        return view('backend.pages.salesTransaction.sales.create', get_defined_vars());
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->salesDetails($request->sales_id);
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $returnHtml = view('backend.layouts.common.deliveryChallanAppend', get_defined_vars())->render();
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
        $checkResult = $this->systemService->checkPendingQuatation($request);
        if($checkResult >= 1){
            session()->flash('error', $checkResult);
            return redirect()->route('salesTransaction.sales.index');
        }
        $result = $this->systemService->store($request);
        if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('salesTransaction.sales.show',$result);
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
        $title = 'Sales Edit';
        $companyInfo =   helper::companyInfo();
        $invoiceDetails = $editInfo->salesDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.sales.details.create');
        return view('backend.pages.salesTransaction.sales.edit', get_defined_vars());
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
        $title = 'Sales Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.sales.details.create');
        return view('backend.pages.salesTransaction.sales.show', get_defined_vars());
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
        return redirect()->route('salesTransaction.sales.show',$result);
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
