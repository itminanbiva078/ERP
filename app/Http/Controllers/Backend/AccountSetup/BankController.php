<?php

namespace App\Http\Controllers\Backend\AccountSetup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AccountSetup\BankService;
use App\Transformers\BankTransformer;
use Illuminate\Validation\ValidationException;
use helper;

class BankController extends Controller
{

    /**
     * @var BankService
     */
    private $systemService;
    /**
     * @var BankTransformer
     */
    private $systemTransformer;

    /**
     * BankController constructor.
     * @param BankService $systemService
     * @param BankTransformer $systemTransformer
     */
    public function __construct(BankService $bankService, BankTransformer $bankTransformer)
    {
        $this->systemService = $bankService;
        $this->systemTransformer = $bankTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $title = 'Account Setup | Bank - List';
        $explodeRoute = "accountSetup.bank.explode";
        $createRoute = "accountSetup.bank.create";
        $datatableRoute = 'accountSetup.bank.dataProcessingBank';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());
    }


    public function dataProcessingBank(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Account Setup | Add New - Bank";
        $listRoute = "accountSetup.bank.index";
        $explodeRoute = "accountSetup.bank.explode";
        $implodeModal ="'inventory-setup-load-import-form','accountSetup.bank.import','Import Bank List','/backend/assets/excelFormat/accountSetup/bank/bank.csv','2'";
        $storeRoute = "accountSetup.bank.store";
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
        return redirect()->route('accountSetup.bank.index');
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


        $title = "Account Setup | Edit - Bank";
        $listRoute = "accountSetup.bank.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "accountSetup.bank.update";
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
        return redirect()->route('accountSetup.bank.index');
    }

       /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bankImport(Request $request) {
        $statusInfo =  $this->systemService->implodeBank($request);
        if (is_integer($statusInfo)) {
            session()->flash('success', 'Bank successfully Imported!!');
        } else {
            session()->flash('error', $statusInfo);
        }
        return redirect()->route('accountSetup.bank.index');

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bankExplode() 
    {
        return  $this->systemService->explodeBank();
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