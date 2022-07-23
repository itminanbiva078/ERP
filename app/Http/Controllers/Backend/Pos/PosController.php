<?php

namespace App\Http\Controllers\Backend\Pos;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Pos\PosService;
use App\Services\InventorySetup\CategoryService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\PosTransformer;


class PosController extends Controller
{

    /**
     * @var ProductService
     */
    private $productService;
    /**


    * @var CategoryService
     */
    private $categoryService;
    /**
 
     * @var PosService
     */
    private $systemService;
    /**

    * @var PosTransformer
     */
    private $systemTransformer;

    /**
     * PosController constructor.
     * @param PosService $systemService
     * @param PosTransformer $systemTransformer
     */
    public function __construct(PosService $posService, PosTransformer $posTransformer ,CategoryService $categoryService, ProductService $productService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->systemService = $posService;
        $this->systemTransformer = $posTransformer;
    }

 /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Pos';
        $companyInfo =   helper::companyInfo();
        $datatableRoute = 'pos.pos.dataProcessingPos';
        return view('backend.pages.pos.pos.index', get_defined_vars());
    }


    public function dataProcessingPos(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Point of Sale (POS)';
        $formInput =  helper::getFormInputByRoute();
        $products = $this->productService->getActiveProduct();
        $categorys = $products->pluck('category')->unique();
        $companyInfo =   helper::companyInfo();
        $invoiceId = helper::generateInvoiceId('POS','pos',8);
        return view('backend.pages.pos.pos.create', get_defined_vars());
    }
  


    public function productFilter(Request $request){
        
        $products =   $this->systemService->getProductList($request);
        $returnHtml = view('backend.pages.pos.pos.ajax.productTemplate', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));

    }


    public function productDetails(Request $request){
       $productStatus =  $this->productService->details($request->product_id);
       return response()->json(array('success' => true, 'data' => $productStatus));
    }


    public function store(Request $request){

       $productStatus =  $this->systemService->store($request);
       
       if (is_integer($productStatus)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $productStatus);
        }
        return redirect()->route('pos.pos.index');
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

        $title = 'Sales Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('salesTransaction.sales.details.create');
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.pos.pos.show', get_defined_vars());
    }
   
}
