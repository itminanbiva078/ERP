<?php

namespace App\Http\Controllers\Backend\Opening;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\Opening\CustomerOpeningService;
use App\Services\SalesSetup\CustomerService;

use App\Transformers\CustomerOpeningTransformer;

class CustomerOpeningController extends Controller
{

    /**
     * @var CustomerOpeningService
     */
    private $systemService;
    /**
     * @var CustomerService
     */
    private $customerService;
    /**
     * @var CustomerOpeningTransformer
     */
    private $systemTransformer;

    /**
     * TransferController constructor.
     *      
     * 
     * * @param CustomerService $customerService
     * @param customerOpeningService $systemService
     * @param CustomerOpeningTransformer $systemTransformer
     */
    public function __construct(CustomerService $customerService, CustomerOpeningService $customerOpeningService, CustomerOpeningTransformer $customerOpeningTransformer)

    {
        $this->customerService = $customerService;
        $this->systemService = $customerOpeningService;
        $this->systemTransformer = $customerOpeningTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Customer Opening List';
        $datatableRoute = 'openingSetup.customerOpening.dataProcessingCustomerOpening';

        return view('backend.pages.opening.customerOpening.index', get_defined_vars());
    }


    public function dataProcessingCustomerOpening(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Customer Opening';
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.customerOpening.details.create');
        return view('backend.pages.opening.customerOpening.create', get_defined_vars());
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
        return redirect()->route('openingSetup.customerOpening.show',$result);
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

        $title = 'Customer Opening Edit';
        $invoiceDetails = $editInfo->customerOpeningDetails;
        $customers = $this->customerService->getActiveCustomer();
        $activeColumn = Helper::getQueryProperty('openingSetup.customerOpening.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.customerOpening.details.create');
        return view('backend.pages.opening.customerOpening.edit', get_defined_vars());
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

        $title = 'Customer Opening Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('openingSetup.customerOpening.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.customerOpening.details.create');
        return view('backend.pages.opening.customerOpening.show', get_defined_vars());
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
         if ($result ===  true) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        } 
        
        return redirect()->route('openingSetup.customerOpening.show',$result);
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
