<?php

namespace App\Http\Controllers\Backend\InventoryTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesMrrService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\PurchasesMrrTransformer;

class PurchasesMrrController extends Controller
{

    /**
     * @var PurchasesMrrService
     */
    private $systemService;

    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var PurchasesMrrTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesMrrController constructor.
     * @param ProductService $ProductService
     * @param PurchasesMrrService $systemService
     * @param PurchasesMrrTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, PurchasesMrrService $purchasesMrrService, PurchasesMrrTransformer $purchasesMrrTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $purchasesMrrService;
        $this->systemTransformer = $purchasesMrrTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Purchases MRR List';
        $companyInfo =   helper::companyInfo();
        $datatableRoute = 'inventoryTransaction.purchasesMRR.dataProcessingpurchasesMRR';
        return view('backend.pages.inventoryTransaction.purchasesMRR.index', get_defined_vars());
    }


    public function dataProcessingpurchasesMRR(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Purchases MRR';
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesMRR.details.create');
        return view('backend.pages.inventoryTransaction.purchasesMRR.create', get_defined_vars());
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

        $result = $this->systemService->store($request);
        if (is_integer($result)){
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }

     return redirect()->route('inventoryTransaction.purchasesMRR.show',$result);
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

        $title = 'Purchases MRR Edit';
        $companyInfo =   helper::companyInfo();
        $invoiceDetails = $editInfo->orderDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesMRR.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesMRR.details.create');
        return view('backend.pages.inventoryTransaction.purchasesMRR.edit', get_defined_vars());
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }

        $title = 'Purchases MRR Details';
        $companyInfo =   helper::companyInfo();
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesMRR.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesMRR.details.create');
        return view('backend.pages.inventoryTransaction.purchasesMRR.show', get_defined_vars());
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

        $result = $this->systemService->update($request, $id);
        if (is_integer($result)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('inventoryTransaction.purchasesMRR.show',$result);
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
        $result =  $this->systemService->destroy($id);
        if ($result ===  true) {
            return response()->json($this->systemTransformer->delete($result), 200);
        }
    }
}