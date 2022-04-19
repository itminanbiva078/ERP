<?php

namespace App\Http\Controllers\Backend\SalesSetup;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\SalesSetup\CustomerService;
use App\Transformers\CustomerTransformer;
use Illuminate\Validation\ValidationException;


class CustomerController extends Controller
{

    

    /**
     * @var CustomerService
     */
    private $systemService;
    /**
     * @var CustomerTransformer
     */
    private $systemTransformer;

    /**
     * CustomerController constructor.
     * @param CustomerService $systemService
     * @param CustomerTransformer $systemTransformer
     */
    public function __construct(CustomerService $customerService, CustomerTransformer $customerTransformer)
    {

       
        $this->systemService = $customerService;
        $this->systemTransformer = $customerTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Customer Manage | Customer - List';
        $explodeRoute = "salesSetup.customer.explode";
        $createRoute = "salesSetup.customer.create";
        $datatableRoute = 'salesSetup.customer.dataProcessingCustomer';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
      
    }


    public function dataProcessingCustomer(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Customer Manage | Add New - Customer";
        $listRoute = "salesSetup.customer.index";
        $explodeRoute = "salesSetup.customer.explode";
        $implodeModal ="'inventory-setup-load-import-form','salesSetup.customer.import','Import Customer List','/backend/assets/excelFormat/salesSetup/customer/customer.csv','2'";
        $storeRoute = "salesSetup.customer.store";
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
        return redirect()->route('salesSetup.customer.index');
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
        $title = "Customer Manage | Edit - Customer";
        $listRoute = "salesSetup.customer.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "salesSetup.customer.update";
        $formInput =  helper::getFormInputByRoute();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());
    }

     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customerList(Request $request) {
        $searchCustomer =  $this->systemService->customerList($request);
        return response()->json($searchCustomer);
        //return json_encode($this->systemTransformer->getList($searchCustomer));
    }
     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customerImport(Request $request) {



        $statusInfo =  $this->systemService->implodeCustomer($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Customer successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('salesSetup.customer.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customerExplode() 
    {
        return  $this->systemService->explodeCustomer();
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
        return redirect()->route('salesSetup.customer.index');
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


     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadModal(Request $request)
    {
        $saveRoute= route('salesSetup.customer.store.ajaxSave');

        $formInput =  helper::getFormInputByRoute('salesSetup.customer.create');
        if(!empty($request->errors)): 
            $errors = $request->errors ?? '';
            $input = $request->input ?? '';
        else: 
            $input = '';
        endif;
        $returnHtml = view('backend.pages.salesSetup.customer.ajax.create', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxSave(Request $request)
    {
        try {
            $this->validate($request, helper::isErrorStore($request,'salesSetup.customer.store'));
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
