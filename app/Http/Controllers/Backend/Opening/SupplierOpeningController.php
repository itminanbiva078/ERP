<?php

namespace App\Http\Controllers\Backend\Opening;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use helper;
use App\Services\Opening\SupplierOpeningService;
use App\Services\InventorySetup\SupplierService;

use App\Transformers\SupplierOpeningTransformer;

class SupplierOpeningController extends Controller
{

    /**
     * @var SupplierOpeningService
     */
    private $systemService;
    /**
     * @var SupplierService
     */
    private $supplierService;
    /**
     * @var SupplierOpeningTransformer
     */
    private $systemTransformer;

    /**
     * TransferController constructor.
     *      
     * 
     * * @param SupplierService $supplierService
     * @param SupplierOpeningService $systemService
     * @param SupplierOpeningTransformer $systemTransformer
     */
    public function __construct(SupplierService $supplierService, SupplierOpeningService $supplierOpeningService, SupplierOpeningTransformer $supplierOpeningTransformer)

    {
        $this->supplierService = $supplierService;
        $this->systemService = $supplierOpeningService;
        $this->systemTransformer = $supplierOpeningTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Supplier Opening List';
        $datatableRoute = 'openingSetup.supplierOpening.dataProcessingSupplierOpening';
        $companyInfo =   helper::companyInfo();
        return view('backend.pages.opening.supplierOpening.index', get_defined_vars());
    }


    public function dataProcessingSupplierOpening(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Supplier Opening';
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.supplierOpening.details.create');
        $companyInfo =   helper::companyInfo();
        return view('backend.pages.opening.supplierOpening.create', get_defined_vars());
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
        return redirect()->route('openingSetup.supplierOpening.show',$result);
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
        $title = 'Supplier Opening Edit';
        $invoiceDetails = $editInfo->supplierOpeningDetails;
        $customers = Supplier::get();
        $activeColumn = Helper::getQueryProperty('openingSetup.supplierOpening.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.supplierOpening.details.create');
        return view('backend.pages.opening.supplierOpening.edit', get_defined_vars());
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

        $title = 'Supplier Opening Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('openingSetup.supplierOpening.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.supplierOpening.details.create');
        return view('backend.pages.opening.supplierOpening.show', get_defined_vars());
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
        
        return redirect()->route('openingSetup.supplierOpening.show',$result);
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
