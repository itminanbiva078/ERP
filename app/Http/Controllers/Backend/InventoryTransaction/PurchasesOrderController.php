<?php
namespace App\Http\Controllers\Backend\InventoryTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventoryTransaction\PurchasesOrderService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\PurchasesOrderTransformer;

class PurchasesOrderController extends Controller
{

    /**
     * @var PurchasesOrderService
     */
    private $systemService;

    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var PurchasesOrderTransformer
     */
    private $systemTransformer;

    /**
     * PurchasesOrderController constructor.
     * @param ProductService $ProductService
     * @param PurchasesOrderService $systemService
     * @param PurchasesOrderTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, PurchasesOrderService $purchasesOrderService, PurchasesOrderTransformer $purchasesOrderTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $purchasesOrderService;
        $this->systemTransformer = $purchasesOrderTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
 
    public function index(Request $request)
    {
        $title = 'Purchases Order List';
        $companyInfo =   helper::companyInfo();
        $datatableRoute = 'inventoryTransaction.purchasesOrder.dataProcessingPurchasesOrder';
        return view('backend.pages.inventoryTransaction.purchasesOrder.index', get_defined_vars());
    }


    public function dataProcessingPurchasesOrder(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }


    public function detailsInfo(Request $request)
    {
        $invoiceDetails = $this->systemService->purchasesOrderDetails($request->order_id);
        $details =   $this->systemService->details($request->order_id);
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesOrder.details.create');
        $returnHtml = view('backend.layouts.common.relationAppend', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml,'details'=>$details));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Purchases Order';
        $companyInfo =   helper::companyInfo();
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesOrder.details.create');
        return view('backend.pages.inventoryTransaction.purchasesOrder.create', get_defined_vars());
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

        $checkResult = $this->systemService->checkPendingRequisition($request);
        if($checkResult >= 1){
            session()->flash('error', $checkResult);
            return redirect()->route('inventoryTransaction.purchasesOrder.index');
        }

        $result = $this->systemService->store($request);

        if (is_integer($result)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('success', $result);
        }



     return redirect()->route('inventoryTransaction.purchasesOrder.show',$result);
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
        $companyInfo =   helper::companyInfo();
        $title = 'Purchases Order Edit';
        $invoiceDetails = $editInfo->orderDetails;
        $products = $this->productService->getActiveProduct();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesOrder.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesOrder.details.create');
        return view('backend.pages.inventoryTransaction.purchasesOrder.edit', get_defined_vars());
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

        $title = 'Purchases Order Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('inventoryTransaction.purchasesOrder.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventoryTransaction.purchasesOrder.details.create');
        return view('backend.pages.inventoryTransaction.purchasesOrder.show', get_defined_vars());
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
        return redirect()->route('inventoryTransaction.purchasesOrder.show',$result);
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
    
    public function approved(Request $request,$id, $status)
    {

        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->approved($id, $request);
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