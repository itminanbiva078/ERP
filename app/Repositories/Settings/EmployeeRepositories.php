<?php

namespace App\Repositories\Settings;
Use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Exports\EmployeesExports;
use App\Imports\EmployeesImports;
use Maatwebsite\Excel\Facades\Excel;
use DB; 

class EmployeeRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Employee
     */
    private $employee;
    /**
     * CourseRepository constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
       
    }
/**
    
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.employee.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.employee.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->employee::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $employees = $this->employee::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->employee::count();
        } else {
            $search = $request->input('search.value');
            $employees = $this->employee::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->employee::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getQueryProperty();
         $data = array();
        if ($employees) {
            foreach ($employees as $key => $employee) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($employee->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.employee.status', [$employee->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.employee.status', [$employee->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $employee->$value;
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.employee.edit', $employee->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete != 0)
                $delete_data = '<a delete_route="' . route('settings.employee.destroy', $employee->id) . '" delete_id="' . $employee->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $employee->id . '"><i class="fa fa-times"></i></a>';
            else
                $delete_data = '';
                
                $nestedData['action'] = $edit_data . ' ' . $delete_data;
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
        $result = $this->employee::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeEmployee(){
        DB::beginTransaction();
        try {
            Excel::import(new EmployeesImports,request()->file('importFile'));
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
    public function explodeEmployee()
    {
        return Excel::download(new EmployeesExports, 'employee-list.xlsx');
    }
    
     /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $employee = new $this->employee();
        $employee->branch_id = $request->branch_id;
        $employee->name = $request->name;
        $employee->parent_id = $request->parent_id;
        $employee->designation = $request->designation;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->status = 'Approved';
        $employee->created_by =  helper::userId();
        $employee->company_id =  helper::companyId();
        $employee->save();
        return $employee;
    }

    public function update($request, $id)
    {
        $employee = $this->employee::findOrFail($id);
        $employee->branch_id = $request->branch_id;
        $employee->parent_id = $request->parent_id;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->designation = $request->designation;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->status = 'Approved';
        $employee->updated_by =  helper::userId();
        $employee->company_id =  helper::companyId();
        $employee->save();
        return $employee;
    }

    public function statusUpdate($id, $status)
    {
        $employee = $this->employee::find($id);
        $employee->status = $status;
        $employee->save();
        return $employee;
    }

    public function destroy($id)
    {
        $employee = $this->employee::find($id);
        $employee->delete();
        return true;
    }
}