<?php

namespace App\Repositories\Usermanage;


use App\Models\CompanyCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\Navigation;
use helper;
use DB;
use phpDocumentor\Reflection\PseudoTypes\False_;

class UserRoleRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var UserRole
     */
    private $userRole;
    /**
     * CourseRepository constructor.
     * @param branch $userRole
     */
    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;
        
    }
    /**
     * @param $request
     * @return mixed
     */


    public function getAllRole()
    {
        return  $this->userRole::get();
    }

    public function getList($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
        );

        $totalData = $this->userRole::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $userRoles = $this->userRole::company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->userRole::company()->count();
        } else {
            $search = $request->input('search.value');
            $userRoles = $this->userRole::company()->where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->userRole::company()->where('name', 'like', "%{$search}%")->count();
        }
        $data = array();
        if ($userRoles) {
            foreach ($userRoles as $key => $userRole) {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $userRole->name;

                if ($userRole->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('usermanage.userRole.status', [$userRole->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('usermanage.userRole.status', [$userRole->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
                if (helper::roleAccess('usermanage.userRole.edit')) :
                    $edit_data = '<a href="' . route('usermanage.userRole.edit', $userRole->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                endif;

                // $view_data = '<a href="' . route('usermanage.userRole.show', $userRole->id) . '" class="btn btn-xs btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                // $delete_data = '<a delete_route="' . route('usermanage.userRole.destroy', $userRole->id) . '" delete_id="' . $userRole->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $userRole->id . '"><i class="fa fa-times"></i></a>';
                $nestedData['action'] = $edit_data;
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
        $result = $this->userRole::find($id);
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getNavigation()
    {
       $companyModule =  CompanyCategory::where('id',helper::companyId())->first();

       $accessModule = explode(",",$companyModule->module);

        $result = Navigation::where('parent_id', 0)->whereIn('id',$accessModule)->get();

        $allMenuList = array();
        foreach ($result as $key => $each_parent) :
            $submenuInfo = Navigation::where('parent_id', $each_parent->id)->where('active',1)->get();
            foreach ($submenuInfo as $key => $eachInfo) :
                $menuList['label'] = $each_parent->label;
                $menuList['sub_menu'] = $eachInfo->label;
                $menuList['child_menu'] =  Navigation::where('parent_id', $eachInfo->id)->where('show_status',1)->get();
                array_push($allMenuList, $menuList);
            endforeach;
        endforeach;
        return $allMenuList;
    }

    public function store($request)
    {

        DB::beginTransaction();
        try {


        $parents = array();
        foreach ($request->permission as $key => $value) :
            $parent_id = $this->getParentId($value);
            array_push($parents, $parent_id);
        endforeach;
        $userRole = new $this->userRole();
        $userRole->name = $request->name;
        $userRole->company_id = helper::companyId();;
        $userRole->parent_id = implode(",", array_unique($parents));
        $userRole->navigation_id = implode(",", $request->permission);
        $userRole->branch_id = 1;//implode(",", $request->branch);
        $userRole->status = 'Approved';
        $userRole->created_by = Auth::user()->id;
        $userRole->save();


        DB::commit();
        // all good
        return $userRole->id;
    } catch (\Exception $e) {
        DB::rollback();
        dd($e->getMessage());
        return $e->getMessage();
    }
    }

    public function getParentId($childId)
    {
        $navigationInfo =  Navigation::findOrFail($childId);
        return $navigationInfo->parent_id;
    }
    public function update($request, $id)
    {
        $parents = array();
        foreach ($request->permission as $key => $value) :
            $parent_id = $this->getParentId($value);
            array_push($parents, $parent_id);
        endforeach;
        $userRole = $this->userRole::findOrFail($id);
        $userRole->name = $request->name;
        $userRole->company_id = helper::companyId();
        $userRole->parent_id = implode(",", array_unique($parents));
        $userRole->navigation_id = implode(",", $request->permission);
        $userRole->branch_id = 1;//implode(",", $request->branch);
        $userRole->status = 'Approved';
        $userRole->created_by = Auth::user()->id;
        $userRole->save();
        return $userRole;
    }

    public function statusUpdate($id, $status)
    {
        $userRole = $this->userRole::find($id);
        $userRole->status = $status;
        $userRole->save();
        return $userRole;
    }

    public function destroy($id)
    {
        $userRole = $this->userRole::find($id);
        $userRole->delete();
        return true;
    }
}
