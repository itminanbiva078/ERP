<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesReturnService;
use App\Services\SalesTransaction\SalesService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\SalesReturnTransformer;

class SalesReturnController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
      /**
     * @var SalesService
     */
    private $salesService;
    /**
     * @var SalesReturnService
     */
    private $systemService;
    /**
     * @var SalesReturnTransformer
     */
    private $systemTransformer;

    /**
     * SalesController constructor.
     * @param SalesReturnService $systemService
     * @param SalesReturnTransformer $systemTransformer
     */
 
    public function __construct(ProductService $productService, SalesReturnService $salesReturnService, SalesReturnTransformer $salesReturnTransformer, SalesService $salesService)
    {
        $this->salesService = $salesService;
        $this->productService = $productService;
        $this->systemService = $salesReturnService;
        $this->systemTransformer = $salesReturnTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

       $title = 'Sales Return List';
       $datatableRoute = 'salesTransaction.salesReturn.dataProcessingSalesReturn';
       return view('backend.pages.salesTransaction.salesReturn.index', get_defined_vars());

    
    }


    public function dataProcessingSalesReturn(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Sales Return';
        return view('backend.pages.salesTransaction.salesReturn.create', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salesListAutocomplete(Request $request)
    {
        $salesList = $this->systemService->salesList($request->search);
        return json_encode($this->systemTransformer->getList($salesList));

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salesDetails(Request $request)
    {
        $formInput =  helper::getFormInputByRoute('salesTransaction.sales.create');
        $salesList = $this->systemService->details($request->sale_id);

        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $returnHtml = view('backend.layouts.common.salesReturn', get_defined_vars())->render();
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
        return redirect()->route('salesTransaction.salesReturn.show',$result);
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

        $title = 'Sales Return Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('salesTransaction.salesReturn.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.salesReturn.details.create');
        return view('backend.pages.salesTransaction.salesReturn.show', get_defined_vars());
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
