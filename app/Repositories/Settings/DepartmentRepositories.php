<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Exports\DepartmentsExports;
use App\Imports\DepartmentssImports;
use Maatwebsite\Excel\Facades\Excel;
use DB; 
class DepartmentRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Department
     */
    private $department;
    /**
     * CourseRepository constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
      
    }


 /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.department.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.department.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->department::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $departments = $this->department::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->department::count();
        } else {
            $search = $request->input('search.value');
            $departments = $this->department::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->department::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($departments) {
            foreach ($departments as $key => $department) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($department->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.department.status', [$department->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.department.status', [$department->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $department->$value;
            endif;
        endforeach;
         if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.department.edit', $department->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete =! 0)
                $delete_data = '<a delete_route="' . route('settings.department.destroy', $department->id) . '" delete_id="' . $department->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $department->id . '"><i class="fa fa-times"></i></a>';
            else
                $delete_data = '';
                $nestedData['action'] = $edit_data . ' ' . $delete_data ;
        else :
                $nestedData['action'] = '';
        endif;
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
        $result = $this->department::find($id);
        return $result;
    }


     /**
     * @param $request
     * @return mixed
     */
    public function implodeDepartment(){
        DB::beginTransaction();
        try {
            Excel::import(new DepartmentssImports,request()->file('importFile'));
            DB::commit();
            // all good
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function explodeDepartment()
    {
        return Excel::download(new DepartmentsExports, 'department-list.xlsx');
    }

     /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $department = new $this->department();
        $department->name = $request->name;
        $department->status = 'Approved';
        $department->created_by = helper::userId();
        $department->company_id = helper::companyId();
        $department->save();
        return $department;
    }

    public function update($request, $id)
    {
        $department = $this->department::findOrFail($id);
        $department->name = $request->name;
        $department->status = 'Approved';
        $department->updated_by = helper::userId();
        $department->company_id = helper::companyId();
        $department->save();
        return $department;
    }

    public function statusUpdate($id, $status)
    {
        $department = $this->department::find($id);
        $department->status = $status;
        $department->save();
        return $department;
    }

    public function destroy($id)
    {
        $department = $this->department::find($id);
        $department->delete();
        return true;
    }
}