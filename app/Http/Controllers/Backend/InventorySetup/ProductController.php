<?php

namespace App\Http\Controllers\Backend\InventorySetup;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Services\InventorySetup\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
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
        $companyInfo =   helper::companyInfo();
        $explodeRoute = "inventorySetup.product.explode";
        $createRoute = "inventorySetup.product.create";
        $datatableRoute = 'inventorySetup.product.dataProcessingProduct';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }
    public function dataProcessingProduct(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Product';
        $companyInfo =   helper::companyInfo();
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventorySetup.productDetails.create');
        return view('backend.pages.inventorySetup.product.create', get_defined_vars());
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
        $companyInfo =   helper::companyInfo();
        $title = 'Product Edit';
        $detailsEditInfo = $editInfo->productDetails;
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('inventorySetup.productDetails.create');
       return view('backend.pages.inventorySetup.product.edit', get_defined_vars());
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
     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request,$id="default",$viewType = null)
    {
        if(empty($id)): 
            $id = $request->id;
        else: 
            $id = $id;
        endif;

        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }
        if(!empty($viewType) && $viewType == 2){
            $returnHtml = view('backend.pages.inventorySetup.product.view', get_defined_vars())->render();
            return response()->json(array('success' => true, 'html' => $returnHtml));
        }else{
            return response()->json($this->systemTransformer->getList($details), 200);
        }
    }
     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function singleInfo(Request $request)
    {
        $id = $request->product_id;
        if (!is_numeric($id)) {
            session()->flash('error', 'Details id must be numeric!!');
            return redirect()->back();
        }
        $details =   $this->systemService->details($id);
        if (!$details) {
            session()->flash('error', 'Details info is invalid!!');
            return redirect()->back();
        }
        return response()->json($this->systemTransformer->getList($details), 200);
    }
     /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stockInfo(Request $request)
    {
        $details =   $this->systemService->productStock($request->product_id,$request->branch_id,$request->store_id,$request->batch_no);
        if (!$details) {
            return response()->json($this->systemTransformer->notFound($details), 200);
        }
        return response()->json($this->systemTransformer->getList($details), 200);
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

    public function uploadProduct(Request $request){
        return true;
    }
    public function productStock(Request $request){
        if (!is_numeric($request->id)) {
            return response()->json($this->systemTransformer->invalidId($request), 200);
        }
        $productStock =   $this->systemService->productStock($request->id);
        if (!$productStock) {
            return response()->json($this->systemTransformer->notFound($productStock), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }

    
}
