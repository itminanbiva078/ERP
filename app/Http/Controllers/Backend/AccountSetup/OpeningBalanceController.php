<?php

namespace App\Http\Controllers\Backend\AccountSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpeningBalance;
use App\Services\AccountSetup\OpeningBalanceService;
use App\Transformers\OpeningBalanceTransformer;
use Illuminate\Validation\ValidationException;
use helper;

class OpeningBalanceController extends Controller
{

    /**
     * @var OpeningBalanceService
     */
    private $systemService;
    /**
     * @var OpeningBalanceTransformer
     */
    private $systemTransformer;

    /**
     * OpeningBalanceController constructor.
     * @param OpeningBalanceService $systemService
     * @param OpeningBalanceTransformer $systemTransformer
     */
    public function __construct(OpeningBalanceService $openingBalanceService, OpeningBalanceTransformer $openingBalanceTransformer)
    {
        $this->systemService = $openingBalanceService;
        $this->systemTransformer = $openingBalanceTransformer;
    }

 
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $invoiceDetails = $this->systemService->getAccountList();
        $inventoryBalance = $this->systemService->inventoryBalance();
        $customerBalance = $this->systemService->customerBalance();
        $supplierBalance = $this->systemService->supplierBalance();
        $formInput = helper::getColumnProperty('report_models',array('date'));
        $opening = helper::getLedgerHead();
        $activeColumn = Helper::getQueryProperty('accountTransaction.journalVoucher.details.create');
        $formInputDetails =  helper::getFormInputByRoute('accountTransaction.journalVoucher.details.create');
        $companyInfo =   helper::companyInfo();

        return view('backend.pages.accountsSetup.openingBalance.edit', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $this->systemService->update($request);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('accountSetup.openingBalance.edit');
    }

   

}