<?php

namespace App\Http\Controllers\Backend\Opening;

use App\Helpers\Helper as HelpersHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\Opening\InventoryOpeningService;
use App\Transformers\InventoryOpeningTransformer;


class InventoryOpeningController extends Controller
{

    /**
     * @var inventoryOpeningService
     */
    private $systemService;
    /**
     * @var InventoryOpeningTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param inventoryOpeningService $systemService
     * @param InventoryOpeningTransformer $systemTransformer
     */
    public function __construct(InventoryOpeningService $coService, InventoryOpeningTransformer $ctTransformer)
    {
        $this->systemService = $coService;
        $this->systemTransformer = $ctTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Opening Balance | Opening Inventory - List';
        $createRoute = "openingSetup.inventory.create";
        $columns = helper::getTableProperty();
        $datatableRoute = 'openingSetup.Inventory.dataProcessingInventory';
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }


    public function dataProcessingInventoryOpening(Request $request)
    {
        

     
        
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Add Opening Inventory";
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.Inventory.details.create');
       return view('backend.pages.opening.inventory.create', get_defined_vars());   
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
        return redirect()->route('openingSetup.inventory.index');
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


        $title = "Opening Inventory Edit";
        $invoiceDetails = $editInfo->inventoryDetails;
        $products = $this->systemService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('openingSetup.inventory.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('openingSetup.inventory.details.create');
       return view('backend.pages.opening.inventory.edit', get_defined_vars());
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = "Inventory Opening Details";
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('openingSetup.inventory.details.create');
        $formInput =  HelpersHelper::getFormInputByRoute();
       return view('backend.pages.opening.inventory.show', get_defined_vars());
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
        return redirect()->route('openingSetup.inventory.index');
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