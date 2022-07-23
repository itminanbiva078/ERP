<?php

namespace App\Http\Controllers\Backend\AccountSetup;

use App\Helpers\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Bank;
use App\Services\AccountSetup\ChartOfAccountService;
use App\Transformers\ChartOfAccountTransformer;
use Illuminate\Validation\ValidationException;
use helper;

class ChartOfAccountController extends Controller
{

    /**
     * @var ChartOfAccountService
     */
    private $systemService;
    /**
     * @var ChartOfAccountTransformer
     */
    private $systemTransformer;

    /**
     * ChartOfAccountController constructor.
     * @param ChartOfAccountService $systemService
     * @param ChartOfAccountTransformer $systemTransformer
     */
    public function __construct(ChartOfAccountService $chartOfAccountService, ChartOfAccountTransformer $chartOfAccountTransformer)
    {
        $this->systemService = $chartOfAccountService;
        $this->systemTransformer = $chartOfAccountTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $title = 'Chart Of Account List';
        $companyInfo =   helper::companyInfo();
        $datatableRoute = 'accountSetup.chartOfAccount.dataProcessingChartOfAccount';
        $columns = helper::getTableProperty();
        return view('backend.pages.accountsSetup.chartOfAccount.index', get_defined_vars());
    }


    public function dataProcessingChartOfAccount(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Account';
        $companyInfo =   helper::companyInfo();
        $categories = ChartOfAccount::where('parent_id', '=', 0)->get();
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.accountsSetup.chartOfAccount.create', get_defined_vars());
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
        return redirect()->route('accountSetup.chartOfAccount.index');
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
        $formInput =  helper::getFormInputByRoute();
        $title = 'Add New Account';
        return view('backend.pages.accountsSetup.chartOfAccount.edit', get_defined_vars());
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
        return redirect()->route('accountSetup.chartOfAccount.index');
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

    public function getAccountBalance(Request $request){

    $accountId = $request->account_id;
      $acccountBalance =   Journal::accountBalance($accountId);
      return $acccountBalance ?? 0;
    }

    public function getAccountBankBalance(Request $request){
      
        $bankId = $request->bank_id;
        $bankInfo = Bank::find($bankId);
       
        $acccountBalance =   Journal::accountBalance($bankInfo->account_id);
      
        return $acccountBalance ?? 0;
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


    public function chartListByTypeWise(Request $request)
    {

        $id = $request->payment_type;

        $chartOfAccountLedger =  $this->systemService->chartListByTypeWise($id);
        if ($chartOfAccountLedger) {
            return response()->json($this->systemTransformer->getList($chartOfAccountLedger), 200);
        }
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chartOfAccount()
    {

        $title = 'Details Chart of Account';
         $categories = ChartOfAccount::where('parent_id', '=', 0)->get();
        // $allCategories = ChartOfAccount::pluck('name','id')->all();
        return view('backend.pages.accountsSetup.chartOfAccount.show', get_defined_vars());
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccountHeadTypeWise(Request $request)
    {
        $head_type_id = $request->type_id;
        $accountHeadsLedger = helper::getLedgerHeadTypWise($head_type_id);
        $append='';
          foreach ($accountHeadsLedger as $key => $parent) :
               $parent2 =  $parent['parent']->name ?? ''; 
                $append.='<optgroup label="'.$parent2.'">';
                    foreach ($parent['parentChild'] as $child => $accountHeads) :
                        $head =  $accountHeads->name ?? '';
                        $append.='<option  value="'.$accountHeads->id.'">'.$head.'</option>';
                    endforeach;
                $append.='</optgroup>';
              endforeach;

              return response()->json($this->systemTransformer->getList($append), 200);
       
    }

    public function childView($chartOfAccount)
    {
        $html = '<ul>';
        foreach ($chartOfAccount->childs as $arr) {
            if (count($arr->childs)) {
                $html .= '<li class="tree-view"><a class="tree-name">' . $arr->name .  ' [ ' . $arr->account_code . ' ] ' . '</a>';
                $html .= $this->childView($arr);
            } else {
                $html .= '<li class="tree-view"><a class="tree-name">' . $arr->name .  ' [ ' . $arr->account_code . ' ] ' . '</a>';
                $html .= "</li>";
            }
        }

        $html .= "</ul>";
        return $html;
    }
}
