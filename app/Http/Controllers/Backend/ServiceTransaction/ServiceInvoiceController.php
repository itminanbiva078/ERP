<?php

namespace App\Http\Controllers\Backend\ServiceTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\ServiceTransaction\ServiceInvoiceService;
use App\Services\ServiceSetup\ServiceService;
use App\Transformers\ServiceInvoiceTransformer;

class ServiceInvoiceController extends Controller
{

      /**
     * @var ServiceService
     */
    private $serviceService;
    /**
     * @var ServiceInvoiceService
     */
    private $systemService;
    /**
     * @var ServiceInvoiceTransformer
     */
    private $systemTransformer;

    /**
     * SalesController constructor.
     * @param ServiceInvoiceService $systemService
     * @param ServiceInvoiceTransformer $systemTransformer
     */
    public function __construct(ServiceService $serviceService, ServiceInvoiceService $serviceInvoiceService, ServiceInvoiceTransformer $serviceInvoiceTransformer)
    {
        $this->serviceService = $serviceService;
        $this->systemService = $serviceInvoiceService;
        $this->systemTransformer = $serviceInvoiceTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Service Invoice List';
       $datatableRoute = 'serviceTransaction.serviceInvoice.dataProcessingServiceInvoice';
       return view('backend.pages.serviceTransaction.serviceInvoice.index', get_defined_vars());
    }


    public function dataProcessingServiceInvoice(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Service Invoice';
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceInvoice.details.create');
        return view('backend.pages.serviceTransaction.serviceInvoice.create', get_defined_vars());
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
            session()->flash('error', 'Validation error!!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

      $checkResult = $this->systemService->checkPendingRequisition($request);
      if($checkResult >= 1){
          session()->flash('error', $checkResult);
          return redirect()->route('serviceTransaction.serviceInvoice.index');
      }
        
        $result = $this->systemService->store($request);
        if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('serviceTransaction.serviceInvoice.show',$result);
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
        $title = 'Service Invoice Edit';

        $invoiceDetails = $editInfo->serviceInvoiceDetails;
        $services = $this->serviceService->getActiveService();
        $activeColumn = Helper::getQueryProperty('serviceTransaction.serviceInvoice.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceInvoice.details.create');
        return view('backend.pages.serviceTransaction.serviceInvoice.edit', get_defined_vars());
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

        $title = 'Service Invoice Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('serviceTransaction.serviceInvoice.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('serviceTransaction.serviceInvoice.details.create');
        return view('backend.pages.serviceTransaction.serviceInvoice.show', get_defined_vars());
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
        return redirect()->route('serviceTransaction.serviceInvoice.show',$result);
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
