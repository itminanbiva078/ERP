<?php

namespace App\Http\Controllers\Backend\Settings;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\DepartmentService;
use App\Transformers\DepartmentTransformer;
use Illuminate\Validation\ValidationException;


class DepartmentController extends Controller
{

    
     /**
     * @var DepartmentService
     */
    private $systemService;
    /**
     * @var DepartmentTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param DepartmentService $systemService
     * @param DepartmentTransformer $systemTransformer
     */
    public function __construct(DepartmentService $departmentService, DepartmentTransformer $departmentTransformer)
    {
        $this->systemService = $departmentService;
        $this->systemTransformer = $departmentTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Settings | Department - List';
        $explodeRoute = "settings.department.explode";
        $createRoute = "settings.department.create";
        $datatableRoute = 'settings.department.dataProcessingDepartment';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
        
     
    }


    public function dataProcessingDepartment(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Settings | Add New - Department";
        $listRoute = "settings.department.index";
        $explodeRoute = "settings.department.explode";
        $implodeModal ="'inventory-setup-load-import-form','settings.department.import','Import Department List','/backend/assets/excelFormat/settings/department/department.csv','2'";
        $storeRoute = "settings.department.store";
        $formInput =  helper::getFormInputByRoute();
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
        return redirect()->route('settings.department.index');
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
        $title = "Settings | Edit - Department";
        $listRoute = "settings.department.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "settings.department.update";
        $formInput =  helper::getFormInputByRoute();
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
        return redirect()->route('settings.department.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentImport(Request $request) {
        $statusInfo =  $this->systemService->implodeDepartment($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Department successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('settings.department.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentExplode() 
    {
        return  $this->systemService->explodeDepartment();
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