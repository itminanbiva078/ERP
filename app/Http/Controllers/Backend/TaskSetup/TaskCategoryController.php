<?php

namespace App\Http\Controllers\Backend\TaskSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\TaskSetup\TaskCategoryService;
use App\Transformers\TaskCategoryTransformer;
use App\SM\SM;

class TaskCategoryController extends Controller
{

    /**
     * @var TaskCategoryService
     */
    private $systemService;
    /**
     * @var TaskCategoryTransformer
     */
    private $systemTransformer;

    /**
     * TaskCategoryController constructor.
     * @param ServiceCategoryService $systemService
     * @param ServiceCategoryTransformer $systemTransformer
     */
    public function __construct(TaskCategoryService $taskCategoryService, TaskCategoryTransformer $taskCategoryTransformer)
    {
        $this->systemService = $taskCategoryService;
        $this->systemTransformer = $taskCategoryTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Task Setup | Task Category - List';
        $explodeRoute = "taskSetup.taskCategory.explode";
        $createRoute = "taskSetup.taskCategory.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'taskSetup.taskCategory.dataProcessingTaskCategory';
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

    }


    public function dataProcessingTaskCategory(Request $request)
    {
        $json_data = $this->systemService->getList($request);
     return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Task Setup | Add New - Task Category";
        $listRoute = "taskSetup.taskCategory.index";
        $explodeRoute = "taskSetup.taskCategory.explode";
        $implodeModal ="'inventory-setup-load-import-form','taskSetup.taskCategory.import','Import Task Category List','/backend/assets/excelFormat/taskSetup/taskCategory/taskCategory.csv','2'";
        $storeRoute = "taskSetup.taskCategory.store";
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

        return redirect()->route('taskSetup.taskCategory.index');
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
        $title = "Task Setup | Edit - Task Category";
        $listRoute = "taskSetup.taskCategory.index";
        $explodeRoute = "taskSetup.taskCategory.explode";
        $implodeModal ="'inventory-setup-load-import-form','taskSetup.taskCategory.import','Import Task Category List','/backend/assets/excelFormat/taskSetup/taskCategory/taskCategory.csv','2'";
        $storeRoute = "taskSetup.taskCategory.update";
        $formInput =  helper::getFormInputByRoute();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars()); 
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskCategoryImport(Request $request) {
        $statusInfo =  $this->systemService->implodeTaskCategory($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Task Category successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('taskSetup.taskCategory.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskCategoryExplode() 
    {
        return  $this->systemService->explodeTaskCategory();
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
        return redirect()->route('taskSetup.taskCategory.index');
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