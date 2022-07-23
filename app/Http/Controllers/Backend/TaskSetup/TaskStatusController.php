<?php

namespace App\Http\Controllers\Backend\TaskSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\TaskSetup\TaskStatusService;
use App\Transformers\TaskStatusTransformer;


class TaskStatusController extends Controller
{

    /**
     * @var TaskStatusService
     */
    private $systemService;
    /**
     * @var TaskStatusTransformer
     */
    private $systemTransformer;

    /**
     * TaskStatusController constructor.
     * @param TaskStatusService $systemService
     * @param TaskStatusTransformer $systemTransformer
     */
    public function __construct(TaskStatusService $taskStatusService, TaskStatusTransformer $taskStatusTransformer)
    {
        $this->systemService = $taskStatusService;
        $this->systemTransformer = $taskStatusTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $title = 'Task Setup | Task Status - List';
        $explodeRoute = "taskSetup.taskStatus.explode";
        $createRoute = "taskSetup.taskStatus.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'taskSetup.taskStatus.dataProcessingTaskStatus';
        $companyInfo =   helper::companyInfo();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

        }


    public function dataProcessingTaskStatus(Request $request)
    {
        $json_data = $this->systemService->getList($request);
     return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Task Setup | Add New - Task Status";
        $listRoute = "taskSetup.taskStatus.index";
        $explodeRoute = "taskSetup.taskStatus.explode";
        $implodeModal ="'inventory-setup-load-import-form','taskSetup.taskStatus.import','Import Task Category List','/backend/assets/excelFormat/taskSetup/taskStatus/taskStatus.csv','2'";
        $storeRoute = "taskSetup.taskStatus.store";
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
        return redirect()->route('taskSetup.taskStatus.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskStatusImport(Request $request) {
        $statusInfo =  $this->systemService->implodeTaskStatus($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Task Status Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('taskSetup.taskStatus.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskStatusExplode() 
    {
        return  $this->systemService->explodeTaskStatus();
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
        $title = "Task Setup | Edit - Task Status";
        $listRoute = "taskSetup.taskStatus.index";
        $explodeRoute = "taskSetup.taskStatus.explode";
        $implodeModal ="'inventory-setup-load-import-form','taskSetup.taskStatus.import','Import Task Category List','/backend/assets/excelFormat/taskSetup/taskStatus/taskStatus.csv','2'";
        $storeRoute = "taskSetup.taskStatus.update";
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
        return redirect()->route('taskSetup.taskStatus.index');
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