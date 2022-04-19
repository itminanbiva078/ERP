<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\DeliveryChallanService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\DeliveryChallanTransformer;

class DeliveryChallanController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var DeliveryChallanService
     */
    private $systemService;
    /**
     * @var DeliveryChallanTransformer
     */
    private $systemTransformer;

    /**
     * DeliveryChallanController constructor.
     * @param DeliveryChallanService $systemService
     * @param DeliveryChallanTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, DeliveryChallanService $deliveryChallanService, DeliveryChallanTransformer $deliveryChallanTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $deliveryChallanService;
        $this->systemTransformer = $deliveryChallanTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Delivery Challan List';
       $datatableRoute = 'salesTransaction.deliveryChallan.dataProcessingDeliveryChallan';
       return view('backend.pages.salesTransaction.deliveryChallan.index', get_defined_vars());
    }


    public function dataProcessingDeliveryChallan(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Delivery Challan';
        $formInput =  helper::getFormInputByRoute();
        $activeColumn = Helper::getQueryProperty('salesTransaction.deliveryChallan.details.create');
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.deliveryChallan.details.create');
        return view('backend.pages.salesTransaction.deliveryChallan.create', get_defined_vars());
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
        return redirect()->route('salesTransaction.deliveryChallan.show',$result);
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
        $title = 'Delivery Challan Edit';
        $invoiceDetails = $editInfo->deliveryChallanDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('salesTransaction.deliveryChallan.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.deliveryChallan.details.create');
        return view('backend.pages.salesTransaction.deliveryChallan.edit', get_defined_vars());
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

        $title = 'Delivery Challan Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('salesTransaction.deliveryChallan.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.deliveryChallan.details.create');
        return view('backend.pages.salesTransaction.deliveryChallan.show', get_defined_vars());
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
        return redirect()->route('salesTransaction.deliveryChallan.show',$result);
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
