<?php

namespace App\Http\Controllers\Backend\AccountTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\AccountTransaction\ContraVoucherService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\ContraVoucherTransformer;

class ContraVoucherController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var ContraVoucherService
     */
    private $systemService;
    /**
     * @var ContraVoucherTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param ContraVoucherService $systemService
     * @param ContraVoucherTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, ContraVoucherService $contraVoucherService, ContraVoucherTransformer $contraVoucherTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $contraVoucherService;
        $this->systemTransformer = $contraVoucherTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Contra Voucher List';
       $datatableRoute = 'accountTransaction.contralVoucher.dataProcessingContralVoucher';
       $companyInfo =   helper::companyInfo();
       return view('backend.pages.accountTransaction.contralVoucher.index', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataProcessingContralVoucher(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Contra Voucher';
        $accountLedger = helper::getLedgerHead();
        $formInput =  helper::getFormInputByRoute();
        $companyInfo =   helper::companyInfo();
        $formInputDetails =  helper::getFormInputByRoute('accountTransaction.contralVoucher.details.create');
        return view('backend.pages.accountTransaction.contralVoucher.create', get_defined_vars());
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
        if (is_integer($result)) {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('accountTransaction.contralVoucher.show',$result);
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
        $title = 'Contra Voucher Edit';
        $companyInfo =   helper::companyInfo();
        $invoiceDetails = $editInfo->contraVoucherLedger;
        $activeColumn = Helper::getQueryProperty('accountTransaction.contralVoucher.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('accountTransaction.contralVoucher.details.create');

        return view('backend.pages.accountTransaction.contralVoucher.edit', get_defined_vars());
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
        $showInfo =   $this->systemService->details($id);
        if (!$showInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Contra Voucher Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('accountTransaction.contralVoucher.details.create');
        return view('backend.pages.accountTransaction.contralVoucher.show', get_defined_vars());
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
          if (is_integer($result))  {
            session()->flash('success', 'Data successfully save!!');
        } else {
            session()->flash('error', $result);
        }
        return redirect()->route('accountTransaction.contralVoucher.show',$result);
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
