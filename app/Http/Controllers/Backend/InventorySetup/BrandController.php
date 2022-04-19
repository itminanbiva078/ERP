<?php

namespace App\Http\Controllers\Backend\InventorySetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventorySetup\BrandService;
use App\Transformers\BrandTransformer;
class BrandController extends Controller
{

    /**
     * @var BrandService
     */
    private $systemService;
    /**
     * @var BrandTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param BrandService $systemService
     * @param BrandTransformer $systemTransformer
     */
    public function __construct(BrandService $brandService, BrandTransformer $brandTransormer)
    {
        $this->systemService = $brandService;
        $this->systemTransformer = $brandTransormer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Product Manage | Brand - List';
        $explodeRoute = "inventorySetup.brand.explode";
        $createRoute = "inventorySetup.brand.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'inventorySetup.brand.dataProcessingBrand';
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }


    public function dataProcessingBrand(Request $request)
    {
        $json_data = $this->systemService->getList($request);
     return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Product Manage | Add New - Brand";
        $listRoute = "inventorySetup.brand.index";
        $explodeRoute = "inventorySetup.brand.explode";
        $implodeModal ="'inventory-setup-load-import-form','inventorySetup.brand.import','Import Brand List','/backend/assets/excelFormat/inventorySetup/brand/brand.csv','2'";
        $storeRoute = "inventorySetup.brand.store";
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
        return redirect()->route('inventorySetup.brand.index');
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
        $title = "Product Manage | Edit - Brand";
        $listRoute = "inventorySetup.brand.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "inventorySetup.brand.update";
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
        return redirect()->route('inventorySetup.brand.index');
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

    public function loadImportForm(Request $request){
        $importRoute= $request->importRoute;
        $downloadUrl= $request->downloadUrl;
        $returnHtml = view('backend.layouts.common.importForm', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));

    }

    public function brandimport(Request $request) {
        $statusInfo =  $this->systemService->implodeBrand($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Brand successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('inventorySetup.brand.index');

    }


    public function brandExplode() 
    {
        return  $this->systemService->exploadBrand();
    }   


       /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadModal(Request $request)
    {
        $saveRoute= route('inventorySetup.brand.store.ajaxSave');
        $formInput =  helper::getFormInputByRoute('inventorySetup.brand.create');
        if(!empty($request->errors)): 
            $errors = $request->errors ?? '';
            $input = $request->input ?? '';
        else: 
            $input = '';
        endif;
        $returnHtml = view('backend.pages.inventorySetup.brand.ajax.create', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxSave(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request,'inventorySetup.brand.store'));
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