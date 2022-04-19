<?php

namespace App\Http\Controllers\Backend\Usermanage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use helper;
use App\Models\Navigation;
use App\Services\Usermanage\CompanyResourceRoleService;
use App\Transformers\CompanyResourceTransformer;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class CompanyResourceController extends Controller
{

    /**
     * @var CompanyResourceRoleService
     */
    private $systemService;
    /**
     * @var UserRoleTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param CompanyResourceTransformer $systemService
     * @param CompanyResourceRoleService $systemTransformer
     */
    public function __construct(CompanyResourceRoleService $userRoleService, CompanyResourceTransformer $userRoleTransformer)
    {
        $this->systemService = $userRoleService;
        $this->systemTransformer = $userRoleTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Company Role';
        return view('backend.pages.usermanage.companyRole.index', get_defined_vars());
    }

    public function dataProcessinguserRole(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Company Resource';
        $companyCategory = $this->systemService->getCompanyCategory();
        $formProperty = $this->systemService->getFormProperty();
        return view('backend.pages.usermanage.companyRole.create', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->systemService->storeValidation($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('company.resource.index');
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
        $title = 'Edit Company Resource Info';
        $allNavigation = array();
        foreach($editInfo as $key => $value): 
          array_push($allNavigation,$value->navigation_id);
        endforeach;
        $company_id = $id;
        $companyCategory = $this->systemService->getCompanyCategory();
        return view('backend.pages.usermanage.companyRole.edit', get_defined_vars());
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadAjax(Request $request)
    {

     
        if (!is_numeric($request->company_id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($request->company_id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Edit Company Resource Info';
        $allNavigation = array();
        foreach($editInfo as $key => $value): 
          array_push($allNavigation,$value->navigation_id);
        endforeach;
        $company_id = $request->company_id;
       
        $formProperty = $this->systemService->getFormProperty($company_id);
       
        $returnHtml = view('backend.pages.usermanage.companyRole.ajax.resource', get_defined_vars())->render();
        return response()->json(array('success' => true, 'html' => $returnHtml));
       
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
            $this->validate($request, $this->systemService->updateValidation($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('company.resource.index');
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