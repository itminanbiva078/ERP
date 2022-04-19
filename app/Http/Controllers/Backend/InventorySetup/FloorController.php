<?php

namespace App\Http\Controllers\Backend\InventorySetup;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InventorySetup\FloorService;
use App\Transformers\FloorTransformer;
use Illuminate\Validation\ValidationException;

class FloorController extends Controller
{
    /**
     * @var FloorService
     */
    private $systemService;
    /**
     * @var FloorTransformer
     */
    private $systemTransformer;
    /**
     * FloorController constructor.
     * @param FloorService $systemService
     * @param FloorTransformer $systemTransformer
     */
    public function __construct(FloorService $floorService, FloorTransformer $floorTransformer)
    {
        $this->systemService = $floorService;
        $this->systemTransformer = $floorTransformer;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Floor | Floor List';
        $explodeRoute = "inventorySetup.floor.explode";
        $createRoute = "inventorySetup.floor.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'inventorySetup.floor.dataProcessingFloor';
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }
    public function dataProcessingFloor(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Floor | Add New - Floor";
        $listRoute = "inventorySetup.floor.index";
        $explodeRoute = "inventorySetup.floor.explode";
        $implodeModal ="'inventory-setup-load-import-form','inventorySetup.floor.import','Import Floor List','/backend/assets/excelFormat/inventorySetup/floor/floor.csv','2'";
        $storeRoute = "inventorySetup.floor.store";
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
        return redirect()->route('inventorySetup.floor.index');
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
        $title = "Floor | Edit - floor";
        $listRoute = "inventorySetup.floor.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "inventorySetup.floor.update";
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
        return redirect()->route('inventorySetup.floor.index');
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
    public function floorImport(Request $request) {
        $statusInfo =  $this->systemService->implodeFloor($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Floor successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('inventorySetup.floor.index');
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function floorExplode() 
    {
        return  $this->systemService->explodeFloor();
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

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadModal(Request $request)
    {
        $saveRoute= route('inventorySetup.floor.store.ajaxSave');
        $formInput =  helper::getFormInputByRoute('inventorySetup.floor.create');
        if(!empty($request->errors)): 
            $errors = $request->errors ?? '';
            $input = $request->input ?? '';
        else: 
            $input = '';
        endif;
        $returnHtml = view('backend.pages.inventorySetup.floor.ajax.create', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxSave(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request,'inventorySetup.floor.store'));
        } catch (ValidationException $e) {

        $input = $request->input();
            return response()->json($this->systemTransformer->error($e->errors(),$input), 200);
            // return response()->json(array('success' => false, 'error' => true, 'errors' => $e->errors(),'input' => $input));
        }

       $success =  $this->systemService->store($request);
       if($success){
        return response()->json($this->systemTransformer->details($success), 200);
       }
    }
}