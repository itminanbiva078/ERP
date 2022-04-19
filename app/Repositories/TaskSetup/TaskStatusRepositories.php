<?php

namespace App\Repositories\TaskSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskStatus;
use App\Exports\TaskstatusExports;
use App\Imports\TaskStatusImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class TaskStatusRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var TaskStatus
     */
    private $taskStatus;
    /**
     * TaskStatusRepositories constructor.
     * @param TaskStatus $taskStatus
     */
    public function __construct(TaskStatus $taskStatus)
    {
        $this->taskStatus = $taskStatus;
     
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('taskSetup.taskStatus.edit') ? 1 : 0;
        $delete = Helper::roleAccess('taskSetup.taskStatus.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->taskStatus::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $taskStatuss = $this->taskStatus::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->taskStatus::count();
        } else {
            $search = $request->input('search.value');
            $taskStatuss = $this->taskStatus::select($columns)->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->taskStatus::select($columns)->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
      


        $columns = Helper::getTableProperty();
        $data = array();
        if ($taskStatuss) {
            foreach ($taskStatuss as $key => $taskStatus) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($taskStatus->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('taskSetup.taskStatus.status', [$taskStatus->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('taskSetup.taskStatus.status', [$taskStatus->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $taskStatus->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('taskSetup.taskStatus.edit', $taskStatus->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('taskSetup.taskStatus.destroy', $taskStatus->id) . '" delete_id="' . $taskStatus->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $taskStatus->id . '"><i class="fa fa-times"></i></a>';
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
    public function getActivetaskStatus()
    {
        $result = $this->taskStatus::where('status', 'Approved')->get();
        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->taskStatus::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeTaskStatus(){
        DB::beginTransaction();
        try {
            Excel::import(new TaskStatusImports,request()->file('importFile'));
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
    public function explodeTaskStatus()
    {
        return Excel::download(new TaskstatusExports, 'task-status.xlsx');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $taskStatus = new $this->taskStatus();
        $taskStatus->name = $request->name;
        $taskStatus->status = 'Approved';
        $taskStatus->created_by = helper::userId();
        $taskStatus->company_id = helper::companyId();
        $taskStatus->save();
        return $taskStatus;
    }

    public function update($request, $id)
    {
        $taskStatus = $this->taskStatus::findOrFail($id);
        $taskStatus->name = $request->name;
        $taskStatus->status = 'Approved';
        $taskStatus->updated_by = helper::userId();
        $taskStatus->company_id = helper::companyId();
        $taskStatus->save();
        return $taskStatus;
    }

    public function statusUpdate($id, $status)
    {
        $taskStatus = $this->taskStatus::find($id);
        $taskStatus->status = $status;
        $taskStatus->save();
        return $taskStatus;
    }

    public function destroy($id)
    {
        $taskStatus = $this->taskStatus::find($id);
        $taskStatus->delete();
        return true;
    }
}
