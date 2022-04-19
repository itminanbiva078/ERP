<?php

namespace App\Http\Controllers\Backend\InventorySetup;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InventorySetup\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Validation\ValidationException;

class ProductDetailsController extends Controller
{

    /**
     * @var ProductService
     */
    private $systemService;
    /**
     * @var ProductTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param ProductService $systemService
     * @param ProductTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, ProductTransformer $productTransformer)
    {

        $this->systemService = $productService;
        $this->systemTransformer = $productTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Product Manage | Product - List';
        $explodeRoute = "inventorySetup.product.explode";
        $createRoute = "inventorySetup.product.create";
        $datatableRoute = 'inventorySetup.product.dataProcessingProduct';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());      
    }


    public function dataProcessingProductDetails(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Product Manage | Add New - Product";
        $listRoute = "inventorySetup.product.index";
        $explodeRoute = "inventorySetup.product.explode";
        $implodeModal ="'inventory-setup-load-import-form','inventorySetup.product.import','Import Product List','/backend/assets/excelFormat/inventorySetup/product/product.csv','2'";
        $storeRoute = "inventorySetup.product.store";
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
        return redirect()->route('inventorySetup.product.index');
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
        $title = "Product Manage | Edit - Product";
        $listRoute = "inventorySetup.product.index";
        $explodeRoute = "inventorySetup.product.explode";
        $implodeModal ="'inventory-setup-load-import-form','inventorySetup.product.import','Import Product List','/backend/assets/excelFormat/inventorySetup/product/product.csv','2')";
        $storeRoute = "inventorySetup.product.update";
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
        return redirect()->route('inventorySetup.product.index');
    }


    public function productImport(Request $request) {
        $statusInfo =  $this->systemService->implodeProduct($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Product successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('inventorySetup.product.index');

    }


    public function productExplode() 
    {
        return  $this->systemService->exploadProduct();
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
    public function productNameSuggestions(Request $request)
    {

        //dd($request);


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
