<?php

namespace App\Http\Controllers\Backend\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesTransaction\SalesPaymentService;
use App\Transformers\SalesPaymentTransformer;





class SalesPaymentController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var SalesPaymentService
     */
    private $systemService;
    /**
     * @var SalesPaymentTransformer
     */
    private $systemTransformer;

    /**
     * SalesController constructor.
     * @param SalesPaymentService $systemService
     * @param SalesPaymentTransformer $systemTransformer
     */
    public function __construct(SalesPaymentService $salesPaymentService, SalesPaymentTransformer $salesPaymentTransformer)
    {
        $this->systemService = $salesPaymentService;
        $this->systemTransformer = $salesPaymentTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Sales Payment List';
       $datatableRoute = 'salesTransaction.salePayment.dataProcessingSalePayment';
       return view('backend.pages.salesTransaction.salesPayment.index', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function dataProcessingSalePayment(Request $request)
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
        return view('backend.pages.salesTransaction.salesPayment.create', get_defined_vars());
    }


    public function customerDueVoucherList(Request $request)
    {

      

        $collectionType = $request->collection_type;
        if($collectionType == 'Pos Sale'): 
            $dueVoucherList = $this->systemService->dueVoucherList($request->customer_id,17);
            $returnHtml = view('backend.pages.salesTransaction.salesPayment.dueVoucherList', get_defined_vars())->render();
        elseif($collectionType == 'Booking'): 
            $dueVoucherList = $this->systemService->dueVoucherList($request->customer_id,18);
            $returnHtml = view('backend.pages.salesTransaction.salesPayment.dueVoucherList', get_defined_vars())->render();
        else: 
            $dueVoucherList = $this->systemService->dueVoucherList($request->customer_id,5);
            $returnHtml = view('backend.pages.salesTransaction.salesPayment.dueVoucherList', get_defined_vars())->render();
        endif;

       
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
           return redirect()->route('salesTransaction.salePayment.show',$result);
        else: 
          return redirect()->route('salesTransaction.sales.pendingCheque.show',$result);
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
        $title = 'Sales Payment Details';
        return view('backend.pages.salesTransaction.salesPayment.show', get_defined_vars());
    }

 
    
   
}
