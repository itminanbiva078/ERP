<?php

namespace App\Http\Controllers\Backend\Settings;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\EmployeeService;
use App\Transformers\EmployeeTransformer;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{

     /**
     * @var EmployeeService
     */
    private $systemService;
    /**
     * @var EmployeeTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param EmployeeService $systemService
     * @param EmployeeTransformer $systemTransformer
     */
    public function __construct(EmployeeService $employeeService, EmployeeTransformer $employeeTransformer)
    {
        $this->systemService = $employeeService;
        $this->systemTransformer = $employeeTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Settings | Employee - List';
        $explodeRoute = "settings.employee.explode";
        $createRoute = "settings.employee.create";
        $datatableRoute = 'settings.employee.dataProcessingEmployee';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

    }


    public function dataProcessingEmployee(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Settings | Add New - Employee";
        $listRoute = "settings.employee.index";
        $explodeRoute = "settings.employee.explode";
        $implodeModal ="'inventory-setup-load-import-form','settings.employee.import','Import Employee List','/backend/assets/excelFormat/settings/employee/employee.csv','2'";
        $storeRoute = "settings.employee.store";
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
        return redirect()->route('settings.employee.index');
    }

     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employeeImport(Request $request) {
        $statusInfo =  $this->systemService->implodeEmployee($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Eployee successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('settings.employee.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employeeExplode() 
    {
        return  $this->systemService->explodeEmployee();
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
        $title = "Settings | Add New - Employee";
        $listRoute = "settings.employee.index";
        $explodeRoute = "settings.employee.explode";
        $implodeModal ="'inventory-setup-load-import-form','settings.employee.import','Import Employee List','/backend/assets/excelFormat/settings/employee/employee.csv','2'";
        $storeRoute = "settings.employee.update";
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
        return redirect()->route('settings.employee.index');
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