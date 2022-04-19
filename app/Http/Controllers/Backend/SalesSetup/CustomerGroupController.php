<?php

namespace App\Http\Controllers\Backend\SalesSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\SalesSetup\CustomerGroupService;
use App\Transformers\CustomerGroupTransformer;

class CustomerGroupController extends Controller
{

    /**
     * @var CustomerGroupService
     */
    private $systemService;
    /**
     * @var CustomerGroupTransformer
     */
    private $systemTransformer;

    /**
     * CustomerGroupController constructor.
     * @param CustomerGroupService $systemService
     * @param CustomerGroupTransformer $systemTransformer
     */
    public function __construct(CustomerGroupService $customerGroupService, CustomerGroupTransformer $customerGroupTransformer)
    {
        $this->systemService = $customerGroupService;
        $this->systemTransformer = $customerGroupTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $title = 'Customer Manage | Customer Group - List';
        $explodeRoute = "salesSetup.customerGroup.explode";
        $createRoute = "salesSetup.customerGroup.create";
        $datatableRoute = 'salesSetup.customerGroup.dataProcessingCustomerGroup';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

      
    }


    public function dataProcessingCustomerGroup(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Customer Manage | Add New - Customer Group";
        $listRoute = "salesSetup.customerGroup.index";
        $explodeRoute = "salesSetup.customerGroup.explode";
        $implodeModal ="'inventory-setup-load-import-form','salesSetup.customerGroup.import','Import  Customer Group List','/backend/assets/excelFormat/salesSetup/customerGroup/customerGroup.csv','2'";
        $storeRoute = "salesSetup.customerGroup.store";
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
        return redirect()->route('salesSetup.customerGroup.index');
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
        $title = "Customer Manage | Edit - Customer Group";
        $listRoute = "salesSetup.customerGroup.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "salesSetup.customerGroup.update";
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
        return redirect()->route('salesSetup.customerGroup.index');
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
    public function customerGroupImport(Request $request) {
        $statusInfo =  $this->systemService->implodeCustomerGroup($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Customer Group successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('salesSetup.customerGroup.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customerGroupExplode() 
    {
        return  $this->systemService->explodeCustomerGroup();
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
        $saveRoute= route('salesSetup.customerGroup.store.ajaxSave');
        $formInput =  helper::getFormInputByRoute('salesSetup.customerGroup.create');
        if(!empty($request->errors)): 
            $errors = $request->errors ?? '';
            $input = $request->input ?? '';
        else: 
            $input = '';
        endif;
        $returnHtml = view('backend.pages.salesSetup.customerGroup.ajax.create', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxSave(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request,'salesSetup.customerGroup.store'));
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