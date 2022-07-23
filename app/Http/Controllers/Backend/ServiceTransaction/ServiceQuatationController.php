<?php

namespace App\Http\Controllers\Backend\ServiceTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\ServiceTransaction\ServiceQuatationService;
use App\Services\ServiceSetup\ServiceService;
use App\Transformers\ServiceQuatationTransformer;

class ServiceQuatationController extends Controller
{

    /**
     * @var ServiceQuatationService
     */
    private $systemService;
    /**
     * @var ServiceService
     */
    private $serviceService;
    /**
     * @var ServiceQuatationTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesRequsitionController constructor.
     *      
     * 
     * * @param ServiceService $serviceService
     * @param ServiceQuatationService $systemService
     * @param ServiceQuatationTransformer $systemTransformer
     */
    public function __construct(ServiceService $serviceService, ServiceQuatationService $serviceQuatationService, ServiceQuatationTransformer $serviceQuatationTransformer)

    {
        $this->serviceService = $serviceService;
        $this->systemService = $serviceQuatationService;
        $this->systemTransformer = $serviceQuatationTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Service Quatation List';
        $companyInfo =   helper::companyInfo();
        $datatableRoute = 'serviceTransaction.serviceQuatation.dataProcessingServiceQuatation';
        return view('backend.pages.serviceTransaction.serviceQuatation.index', get_defined_vars());
    }


    public function dataProcessingServiceQuatation(Request $request)
    {
        $json_data = $this->systemService->getList($request);

        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Service Quatation';
        $companyInfo =   helper::companyInfo();
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceQuatation.details.create');
        return view('backend.pages.serviceTransaction.serviceQuatation.create', get_defined_vars());
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
        return redirect()->route('serviceTransaction.serviceQuatation.show',$result);
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
        $companyInfo =   helper::companyInfo();
        $title = 'Service Quatation Edit';
        $invoiceDetails = $editInfo->serviceQuatationDetails;
        $services = $this->serviceService->getActiveService();
        $activeColumn = Helper::getQueryProperty('serviceTransaction.serviceQuatation.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceQuatation.details.create');
        return view('backend.pages.serviceTransaction.serviceQuatation.edit', get_defined_vars());
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

        $title = 'Service Quatation Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('serviceTransaction.serviceQuatation.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceQuatation.details.create');
        return view('backend.pages.serviceTransaction.serviceQuatation.show', get_defined_vars());
    }


    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->serviceQuatationDetails($request->service_quatation_id);
        $services = $this->serviceService->getActiveService();
        $activeColumn = Helper::getQueryProperty('serviceTransaction.serviceQuatation.details.create');
        $returnHtml = view('backend.layouts.common.serviceAppend', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
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

        return redirect()->route('serviceTransaction.serviceQuatation.show',$result);
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
