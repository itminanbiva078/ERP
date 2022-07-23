<?php

namespace App\Http\Controllers\Backend\SalesSetup;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SalesSetup\SalesReferenceService;
use App\Transformers\SalesReferenceTransformer;
use Illuminate\Validation\ValidationException;


class SalesReferenceController extends Controller
{

    /**
     * @var SalesReferenceService
     */
    private $systemService;
    /**
     * @var SalesReferenceTransformer
     */
    private $systemTransformer;

    /**
     * SalesReferenceController constructor.
     * @param SalesReferenceService $systemService
     * @param SalesReferenceTransformer $systemTransformer
     */
    public function __construct(SalesReferenceService $salesReferenceService, SalesReferenceTransformer $salesReferenceTransformer)
    {
        $this->systemService = $salesReferenceService;
        $this->systemTransformer = $salesReferenceTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Customer Manage | Customer Media - List';
        $explodeRoute = "salesSetup.salesReference.explode";
        $createRoute = "salesSetup.salesReference.create";
        $datatableRoute = 'salesSetup.salesReference.dataProcessingSalesReference';
        $columns = helper::getTableProperty();
        $companyInfo =   helper::companyInfo();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }


    public function dataProcessingSalesReference(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $title = "Customer Manage | Add New - Customer Media";
        $listRoute = "salesSetup.salesReference.index";
        $explodeRoute = "salesSetup.salesReference.explode";
        $implodeModal ="'inventory-setup-load-import-form','salesSetup.salesReference.import','Import Customer Media List','/backend/assets/excelFormat/salesSetup/salesReference/salesReference.csv','2'";
        $storeRoute = "salesSetup.salesReference.store";
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
        return redirect()->route('salesSetup.salesReference.index');
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
        $title = "Customer Manage | Add New - Customer Media";
        $listRoute = "salesSetup.salesReference.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "salesSetup.salesReference.update";
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
        return redirect()->route('salesSetup.salesReference.index');
    }

      /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function salesReferenceImport(Request $request) {
        $statusInfo =  $this->systemService->implodeSaleReference($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Sales Reference successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('salesSetup.salesReference.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function salesReferenceExplode() 
    {
        return  $this->systemService->explodeSaleReference();
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
