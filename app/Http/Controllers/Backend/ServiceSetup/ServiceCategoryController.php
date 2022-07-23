<?php

namespace App\Http\Controllers\Backend\ServiceSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\ServiceSetup\ServiceCategoryService;
use App\Transformers\ServiceCategoryTransformer;


class ServiceCategoryController extends Controller
{

    /**
     * @var ServiceCategoryService
     */
    private $systemService;
    /**
     * @var ServiceCategoryTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param ServiceCategoryService $systemService
     * @param ServiceCategoryTransformer $systemTransformer
     */
    public function __construct(ServiceCategoryService $serviceCategoryService, ServiceCategoryTransformer $serviceCategoryTransformer)
    {
        $this->systemService = $serviceCategoryService;
        $this->systemTransformer = $serviceCategoryTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Service Setup | Service  Category - List';
        $explodeRoute = "serviceSetup.serviceCategory.explode";
        $createRoute = "serviceSetup.serviceCategory.create";
        $datatableRoute = 'serviceSetup.serviceCategory.dataProcessingServiceCategory';
        $columns = helper::getTableProperty();
        $companyInfo =   helper::companyInfo();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

    
    }


    public function dataProcessingServiceCategory(Request $request)
    {
        $json_data = $this->systemService->getList($request);
     return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Service Setup | Add New - Service  Category";
        $listRoute = "serviceSetup.serviceCategory.index";
        $explodeRoute = "serviceSetup.serviceCategory.explode";
        $implodeModal ="'inventory-setup-load-import-form','serviceSetup.serviceCategory.import','Import Service Category List','/backend/assets/excelFormat/serviceSetup/serviceCategory/serviceCategory.csv','2'";
        $storeRoute = "serviceSetup.serviceCategory.store";
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
        return redirect()->route('serviceSetup.serviceCategory.index');
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
        $title = "Service Setup | Add New - Service  Category";
        $listRoute = "serviceSetup.serviceCategory.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "serviceSetup.serviceCategory.update";
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
        return redirect()->route('serviceSetup.serviceCategory.index');
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
    public function serviceCategoryImport(Request $request) {
        $statusInfo =  $this->systemService->implodeServiceCategory($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Service Category successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('serviceSetup.serviceCategory.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function serviceCategoryGroupExplode() 
    {
        return  $this->systemService->explodeServiceCategory();
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