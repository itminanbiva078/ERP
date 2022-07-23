<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesLoanReturnService;
use App\Transformers\SalesLoanReturnTransformer;

class SalesLoanReturnController extends Controller
{

     
    /**
     * @var SalesLoanReturnService
     */
    private $systemService;
    /**
     * @var SalesLoanReturnTransformer
     */
    private $systemTransformer;

    /**
     * SalesController constructor.
     * @param SalesLoanReturnService $systemService
     * @param SalesLoanReturnTransformer $systemTransformer
     */
 
    public function __construct(SalesLoanReturnService $salesLoanReturnService, SalesLoanReturnTransformer $salesLoanReturnTransformer)
    {
       
        $this->systemService = $salesLoanReturnService;
        $this->systemTransformer = $salesLoanReturnTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

       $title = 'Sales Loan Return List';
       $companyInfo =   helper::companyInfo();
       $datatableRoute = 'salesTransaction.salesLoanReturn.dataProcessingSalesLoanReturn';
       return view('backend.pages.salesTransaction.salesLoanReturn.index', get_defined_vars());

    
    }


    public function dataProcessingSalesLoanReturn(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Sales Loan Return';
        $companyInfo =   helper::companyInfo();
        return view('backend.pages.salesTransaction.salesLoanReturn.create', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salesLoanListAutocomplete(Request $request)
    {
        $salesList = $this->systemService->salesLoanList($request->search);
        return json_encode($this->systemTransformer->getList($salesList));

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salesLoanDetails(Request $request)
    {
   
        $formInput =  helper::getFormInputByRoute('salesTransaction.salesLoan.details');
        $salesList = $this->systemService->details($request->sales_lons_id);
        
        $activeColumn = Helper::getQueryProperty('salesTransaction.salesLoan.details.create');
        $returnHtml = view('backend.layouts.common.salesLoanReturn', get_defined_vars())->render();

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
        return redirect()->route('salesTransaction.salesLoanReturn.show',$result);
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
        $activeColumn = Helper::getQueryProperty('salesTransaction.salesLoanReturn.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('salesTransaction.salesLoanReturn.details.create');
        return view('backend.pages.salesTransaction.salesLoanReturn.show', get_defined_vars());
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
