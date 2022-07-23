<?php

namespace App\Http\Controllers\Backend\ServiceSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\ServiceSetup\ServiceService;
use App\Transformers\ServiceTransformer;


class ServiceController extends Controller
{

    /**
     * @var ServiceService
     */
    private $systemService;
    /**
     * @var ServiceTransformer
     */
    private $systemTransformer;

    /**
     * ServiceController constructor.
     * @param ServiceService $systemService
     * @param ServiceTransformer $systemTransformer
     */
    public function __construct(ServiceService $serviceService, ServiceTransformer $serviceTransformer)
    {
        $this->systemService = $serviceService;
        $this->systemTransformer = $serviceTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Service Setup | Service  - List';
        $explodeRoute = "serviceSetup.service.explode";
        $createRoute = "serviceSetup.service.create";
        $datatableRoute = 'serviceSetup.service.dataProcessingService';
        $columns = helper::getTableProperty();
        $companyInfo =   helper::companyInfo();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

    }


    public function dataProcessingService(Request $request)
    {
        $json_data = $this->systemService->getList($request);
     return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Service Setup | Add New - Service";
        $listRoute = "serviceSetup.service.index";
        $explodeRoute = "serviceSetup.service.explode";
        $implodeModal ="'inventory-setup-load-import-form','serviceSetup.service.import','Import Service List','/backend/assets/excelFormat/serviceSetup/service/service.csv','2'";
        $storeRoute = "serviceSetup.service.store";
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());

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
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('serviceSetup.service.index');
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
        $title = "Service Setup | Add New - Service";
        $listRoute = "serviceSetup.service.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "serviceSetup.service.update";
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());
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
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('serviceSetup.service.index');
    }



    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serviceImport(Request $request) {
        $statusInfo =  $this->systemService->implodeService($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Service successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('serviceSetup.service.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serviceExplode() 
    {
        return  $this->systemService->explodeService();
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
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }
}