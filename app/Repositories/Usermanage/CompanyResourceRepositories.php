<?php

namespace App\Repositories\Usermanage;

use App\Models\CompanyCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyResource;
use App\Models\FormInput;
use App\Models\Navigation;
use helper;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CompanyResourceRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var CompanyResource
     */
    private $companyResource;
    /**
     * CourseRepository constructor.
     * @param branch $companyResource
     */
    public function __construct(CompanyResource $companyResource)
    {
        $this->companyResource = $companyResource;
        //$this->middleware(function ($request, $next) {
        $this->user_id = 1; //auth()->user()->id;
        //  return $next($request);
        //});
    }
    /**
     * @param $request
     * @return mixed
     */


    public function getFormProperty($company_id)
    {

        if(is_null($company_id)): 
            return  FormInput::with('navigation')->get();
        else: 
            $companyResource = CompanyCategory::where('id',$company_id)->first();
           return  FormInput::with('navigation')->whereIn('navigation_id',explode(",",$companyResource->module_details))->get();

        endif;
       
    }

    public function getCompanyCategory()
    {
        return  CompanyCategory::get();
    }

    public function getList($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'company_category_id',
        );



        
        $totalData = $this->companyResource::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $companyResources = $this->companyResource::groupBy('company_resources.company_category_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered =  $this->companyResource::select('company_category_id')->groupBy('company_resources.company_category_id')->get();
          
         
        } else {
            $search = $request->input('search.value');
            $companyResources = $this->companyResource::with(['companyCategory' => function($query) use ($search){
                $query->where('role_name', 'like', "%{$search}%");
            }])
            ->groupBy('company_resources.company_category_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->companyResource::select('company_category_id')->groupBy('company_resources.company_category_id')->get();
        }
        $totalFiltered = count($totalFiltered);
        $data = array();
        if ($companyResources) {
            foreach ($companyResources as $key => $companyResource) {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $companyResource->companyCategory->name ?? '';
                if ($companyResource->companyCategory->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('company.resource.status', [$companyResource->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('company.resource.status', [$companyResource->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
                if (helper::roleAccess('company.resource.edit')) :
                    $edit_data = '<a href="' . route('company.resource.edit', $companyResource->company_category_id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                endif;

                $view_data = '<a href="' . route('company.resource.show', $companyResource->id) . '" class="btn btn-xs btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                // $delete_data = '<a delete_route="' . route('company.resource.destroy', $companyResource->id) . '" delete_id="' . $companyResource->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $companyResource->id . '"><i class="fa fa-times"></i></a>';
                $nestedData['action'] = $edit_data . ' ' . $view_data;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return $json_data;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->companyResource::where('company_category_id',$id)->get();
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getNavigation()
    {
        $result = Navigation::where('parent_id', 0)->get();
        $allMenuList = array();
        foreach ($result as $key => $each_parent) :
            $submenuInfo = Navigation::where('parent_id', $each_parent->id)->get();
            foreach ($submenuInfo as $key => $eachInfo) :
                $menuList['label'] = $each_parent->label;
                $menuList['sub_menu'] = $eachInfo->label;
                $menuList['child_menu'] =  Navigation::where('parent_id', $eachInfo->id)->get();
                array_push($allMenuList, $menuList);
            endforeach;
        endforeach;
        return $allMenuList;
    }

    public function store($request)
    {
        $permissions = $request->permission;
        if(!empty($permissions)):
        $this->companyResource::where('company_category_id', $request->company_category)->delete();
        foreach ($permissions as $key => $permission) :
            $permissions_value = array();
            foreach ($permission as $key1 => $value) :
                array_push($permissions_value, json_decode($value));
            endforeach;
            $company_resource =  new $this->companyResource();
            $company_resource->company_category_id = $request->company_category;
            $company_resource->navigation_id = $key;
            $company_resource->form_input = json_encode($permissions_value);
            $company_resource->save();
        endforeach;
    endif;
        return true;
    }

    public function getParentId($childId)
    {
        $navigationInfo =  Navigation::findOrFail($childId);
        return $navigationInfo->parent_id;
    }
    public function update($request, $id)
    {   

        

        $permissions = $request->permission;
        if(!empty($permissions)):

            $this->companyResource::where('company_category_id', $request->company_category)->delete();
        
            foreach ($permissions as $key => $permission) :
                $permissions_value = array();
                foreach ($permission as $key1 => $value) :
                    array_push($permissions_value, json_decode($value));
                endforeach;
                $company_resource =  new $this->companyResource();
                $company_resource->company_category_id = $request->company_category;
                $company_resource->navigation_id = $key;
                $company_resource->form_input = json_encode($permissions_value);
                $company_resource->save();
            endforeach;
    endif;
        return true;
    }

    public function statusUpdate($id, $status)
    {
        $companyResource = $this->companyResource::find($id);
        $companyResource->status = $status;
        $companyResource->save();
        return $companyResource;
    }

    public function destroy($id)
    {
        $companyResource = $this->companyResource::find($id);
        $companyResource->delete();
        return true;
    }
}