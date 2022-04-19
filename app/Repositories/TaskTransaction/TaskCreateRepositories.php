<?php

namespace App\Repositories\TaskTransaction;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskCreate;

class TaskCreateRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var TaskCreate
     */
    private $taskCreate;
    /**
     * TaskCreateRepositories constructor.
     * @param taskCreate $taskCreate
     */
    public function __construct(TaskCreate $taskCreate)
    {
        $this->taskCreate = $taskCreate;
       
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('taskTransaction.taskCreate.edit') ? 1 : 0;
        $delete = Helper::roleAccess('taskTransaction.taskCreate.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->taskCreate::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $taskCreates = $this->taskCreate::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->taskCreate::count();
        } else {
            $search = $request->input('search.value');
            $taskCreates = $this->taskCreate::select($columns)->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->taskCreate::select($columns)->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
      


        $columns = Helper::getTableProperty();
        $data = array();
        if ($taskCreates) {
            foreach ($taskCreates as $key => $taskCreate) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($taskCreate->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('taskTransaction.taskCreate.status', [$taskCreate->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('taskTransaction.taskCreate.status', [$taskCreate->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $taskCreate->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('taskTransaction.taskCreate.edit', $taskCreate->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('taskTransaction.taskCreate.destroy', $taskCreate->id) . '" delete_id="' . $taskCreate->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $taskCreate->id . '"><i class="fa fa-times"></i></a>';
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
    public function getActivetaskCreate()
    {
        $result = $this->taskCreate::where('status', 'Approved')->get();
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->taskCreate::find($id);
        return $result;
    }

    public function store($request)
    {
        $taskCreate = new $this->taskCreate();
        $taskCreate->name = $request->name;
        $taskCreate->project_id   = $request->project_id  ;
        $taskCreate->task_categorie_id   = $request->task_categorie_id  ;
        $taskCreate->employee_id   = $request->employee_id  ;
        $taskCreate->description  = $request->description ;
        $taskCreate->start_date  = $request->start_date ;
        $taskCreate->end_date  = $request->end_date ;
        $taskCreate->file  = $request->file ;
        $taskCreate->time  = $request->time ;
        $taskCreate->priority  = $request->priority ;
        $taskCreate->status = 'Approved';
        $taskCreate->created_by = helper::userId();
        $taskCreate->company_id = helper::companyId();
        $taskCreate->save();
        return $taskCreate;
    }

    public function update($request, $id)
    {
        $taskCreate = $this->taskCreate::findOrFail($id);
        $taskCreate->name = $request->name;
        $taskCreate->project_id   = $request->project_id  ;
        $taskCreate->task_categorie_id   = $request->task_categorie_id  ;
        $taskCreate->employee_id   = $request->employee_id  ;
        $taskCreate->description  = $request->description ;
        $taskCreate->start_date  = $request->start_date ;
        $taskCreate->end_date  = $request->end_date ;
        $taskCreate->file  = $request->file ;
        $taskCreate->time  = $request->time ;
        $taskCreate->priority  = $request->priority ;
        $taskCreate->status = 'Approved';
        $taskCreate->updated_by = helper::userId();
        $taskCreate->company_id = helper::companyId();
        $taskCreate->save();
        return $taskCreate;
    }

    public function statusUpdate($id, $status)
    {
        $taskCreate = $this->taskCreate::find($id);
        $taskCreate->status = $status;
        $taskCreate->save();
        return $taskCreate;
    }

    public function destroy($id)
    {
        $taskCreate = $this->taskCreate::find($id);
        $taskCreate->delete();
        return true;
    }
}
