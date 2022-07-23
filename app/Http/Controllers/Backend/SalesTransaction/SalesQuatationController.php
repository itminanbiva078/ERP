<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesQuatationService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\SalesQuatationTransformer;
use App\Services\SalesTransaction\SalesService;

class SalesQuatationController extends Controller
{

      /**
     * @var SalesService
     */
    private $salesService;
      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var SalesQuatationService
     */
    private $systemService;
    /**
     * @var SalesQuatationTransformer
     */
    private $systemTransformer;

    /**
     * SalesQuatationController constructor.
     * @param SalesQuatationService $systemService
     * @param SalesQuatationTransformer $systemTransformer
     */
    public function __construct(SalesService  $salesService,ProductService $productService, SalesQuatationService $salesQuatationService, SalesQuatationTransformer $salesQuatationTransformer)
    {
        $this->salesService = $salesService;
        $this->productService = $productService;
        $this->systemService = $salesQuatationService;
        $this->systemTransformer = $salesQuatationTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Sales Quatation List';
       $companyInfo =   helper::companyInfo();
       $datatableRoute = 'salesTransaction.salesQuatation.dataProcessingSalesQuatation';
       return view('backend.pages.salesTransaction.salesQuatation.index', get_defined_vars());
    }



    public function dataProcessingSalesQuatation(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Sales Quatation';
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.salesQuatation.details.create');
        return view('backend.pages.salesTransaction.salesQuatation.create', get_defined_vars());
    }

    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->salesQuatations($request->sales_quatation_id);
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $batchList = helper::getActiveBatch();
        $returnHtml = view('backend.layouts.common.salesAppend', get_defined_vars())->render();
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

        if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('salesTransaction.salesQuatation.show',$result);
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
        $title = 'Sales Quatation Edit';
        $companyInfo =   helper::companyInfo();
        $invoiceDetails = $editInfo->salesQuatationDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.salesQuatation.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.salesQuatation.details.create');
        return view('backend.pages.salesTransaction.salesQuatation.edit', get_defined_vars());
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

        $title = 'Sales Quatation Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('salesTransaction.salesQuatation.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.salesQuatation.details.create');
        return view('backend.pages.salesTransaction.salesQuatation.show', get_defined_vars());
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
        return redirect()->route('salesTransaction.salesQuatation.show',$result);
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
