<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesReturnService;
use App\Services\InventoryTransaction\PurchasesService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\PurchasesReturnTransformer;

class PurchasesReturnController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
      /**
     * @var PurchasesService
     */
    private $purchasesService;
    /**
     * @var PurchasesReturnService
     */
    private $systemService;
    /**
     * @var PurchasesReturnTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesRetuenController constructor.
     * @param PurchasesReturnService $systemService
     * @param purchasesReturnTransformer $systemTransformer
     * @param PurchasesService $purchasesService
     */
    public function __construct(ProductService $productService, PurchasesService $purchasesService, PurchasesReturnTransformer $purchasesReturnTransformer, PurchasesReturnService $purchasesReturnService)
    {
        $this->purchasesService = $purchasesService;
        $this->productService = $productService;
        $this->systemService = $purchasesReturnService;
        $this->systemTransformer = $purchasesReturnTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

       $title = 'Purchases Return List';
       $datatableRoute = 'inventoryTransaction.purchasesReturn.dataProcessingPurchasesReturn';
       return view('backend.pages.inventoryTransaction.purchasesReturn.index', get_defined_vars());
    }


    public function dataProcessingPurchasesReturn(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New purchases Return';
        return view('backend.pages.inventoryTransaction.purchasesReturn.create', get_defined_vars());
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchasesListAutocomplete(Request $request)
    {
        $purchasesList = $this->systemService->purchasesList($request->search);
        return json_encode($this->systemTransformer->getList($purchasesList));

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchasesDetails(Request $request)
    {

        $formInput =  helper::getFormInputByRoute('inventoryTransaction.purchases.create');
        $purchasesList = $this->systemService->details($request->purchases_id);
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchases.details.create');
        $returnHtml = view('backend.layouts.common.purchasesReturn', get_defined_vars())->render();
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
        return redirect()->route('inventoryTransaction.purchasesReturn.show',$result);
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
        $details =   $this->systemService->invoiceDetails($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }

        $title = 'purchases Return Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesReturn.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesReturn.create');
        return view('backend.pages.inventoryTransaction.purchasesReturn.show', get_defined_vars());
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
        $detailsInfo =   $this->systemService->invoiceDetails($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->approved($id, $request);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }

}
