<?php

namespace App\Http\Controllers\Backend\InventorySetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\InventorySetup\ProductReviewService;
use App\Transformers\ProductReviewTransformer;

class ProductReviewController extends Controller
{

    /**
     * @var ProductReviewService
     */
    private $systemService;
    /**
     * @var ProductReviewTransformer
     */
    private $systemTransformer;

    /**
     * ProductReviewController constructor.
     *      
     * 
     * @param ProductReviewService $systemService
     * @param ProductReviewTransformer $systemTransformer
     */
    public function __construct(ProductReviewService $productReviewService,  ProductReviewTransformer $productReviewTransformer)

    {
        $this->systemService = $productReviewService;
        $this->systemTransformer = $productReviewTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Review List';
        $datatableRoute = 'inventorySetup.productReview.dataProcessingProductReview';
        return view('backend.pages.inventorySetup.review.index', get_defined_vars());
    }


    public function dataProcessingProductReview(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
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