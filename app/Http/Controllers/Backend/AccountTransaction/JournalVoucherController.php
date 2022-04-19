<?php

namespace App\Http\Controllers\Backend\AccountTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Services\AccountTransaction\JournalVoucherService;
use App\Services\InventorySetup\ProductService;
use App\Transformers\JournalVoucherTransformer;

class JournalVoucherController extends Controller
{

      /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var JournalVoucherService
     */
    private $systemService;
    /**
     * @var JournalVoucherTransformer
     */
    private $systemTransformer;

    /**
     * PaymentVoucherController constructor.
     * @param JournalVoucherService $systemService
     * @param JournalVoucherTransformer $systemTransformer
     */
    public function __construct(ProductService $productService, JournalVoucherService $journalVoucherService, JournalVoucherTransformer $journalVoucherTransformer)
    {
        $this->productService = $productService;
        $this->systemService = $journalVoucherService;
        $this->systemTransformer = $journalVoucherTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
       $title = 'Journal Voucher List';
       $datatableRoute = 'accountTransaction.journalVoucher.dataProcessingJournalVoucher';
       return view('backend.pages.accountTransaction.journalVoucher.index', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataProcessingJournalVoucher(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Journal Voucher';
        $accountLedger = helper::getLedgerHead();
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('accountTransaction.journalVoucher.details.create');
        return view('backend.pages.accountTransaction.journalVoucher.create', get_defined_vars());
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
        return redirect()->route('accountTransaction.journalVoucher.show',$result);
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
        $title = 'Journal Voucher Edit';
        $invoiceDetails = $editInfo->journalVoucherLedger;
        $activeColumn = Helper::getQueryProperty('accountTransaction.journalVoucher.details.create');
        $formInput =  helper::getFormInputByRoute();
        $formInputDetails =  helper::getFormInputByRoute('accountTransaction.journalVoucher.details.create');

        return view('backend.pages.accountTransaction.journalVoucher.edit', get_defined_vars());
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
        $title = 'Journal Voucher Details';
        $companyInfo =   helper::companyInfo();
        $activeColumn = Helper::getQueryProperty('accountTransaction.journalVoucher.details.create');
        return view('backend.pages.accountTransaction.journalVoucher.show', get_defined_vars());
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
        return redirect()->route('accountTransaction.journalVoucher.show',$result);
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
