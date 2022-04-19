<?php

namespace App\Repositories\TaskSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskCategory;
use App\Exports\TaskCategoryExports;
use App\Imports\TaskCategoryImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class TaskCategoryRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var TaskCategory
     */
    private $taskCategory;
    /**
     * TaskCategoryRepositories constructor.
     * @param TaskCategory $taskCategory
     */
    public function __construct(TaskCategory $taskCategory)
    {
        $this->taskCategory = $taskCategory;
        
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('taskSetup.taskCategory.edit') ? 1 : 0;
        $delete = Helper::roleAccess('taskSetup.taskCategory.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->taskCategory::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $taskCategorys = $this->taskCategory::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->taskCategory::count();
        } else {
            $search = $request->input('search.value');
            $taskCategorys = $this->taskCategory::select($columns)->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->taskCategory::select($columns)->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($taskCategorys) {
            foreach ($taskCategorys as $key => $taskCategory) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($taskCategory->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('taskSetup.taskCategory.status', [$taskCategory->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('taskSetup.taskCategory.status', [$taskCategory->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $taskCategory->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('taskSetup.taskCategory.edit', $taskCategory->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('taskSetup.taskCategory.destroy', $taskCategory->id) . '" delete_id="' . $taskCategory->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $taskCategory->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->taskCategory::find($id);
        return $result;
    }

      /**
     * @param $request
     * @return mixed
     */
    public function implodeTaskCategory(){
        DB::beginTransaction();
        try {
            Excel::import(new TaskCategoryImports,request()->file('importFile'));
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
    public function explodeTaskCategory()
    {
        return Excel::download(new TaskCategoryExports, 'task-category-list.xlsx');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $taskCategory = new $this->taskCategory();
        $taskCategory->name = $request->name;
        $taskCategory->parent_id = $request->parent_id;
        $taskCategory->status = 'Approved';
        $taskCategory->created_by = helper::userId();
        $taskCategory->company_id = helper::companyId();
        $taskCategory->save();
        return $taskCategory;
    }

    public function update($request, $id)
    {
        $taskCategory = $this->taskCategory::findOrFail($id);
        $taskCategory->name = $request->name;
        $taskCategory->parent_id = $request->parent_id;
        $taskCategory->status = 'Approved';
        $taskCategory->updated_by = helper::userId();
        $taskCategory->company_id = helper::companyId();
        $taskCategory->save();
        return $taskCategory;
    }

    public function statusUpdate($id, $status)
    {
        $taskCategory = $this->taskCategory::find($id);
        $taskCategory->status = $status;
        $taskCategory->save();
        return $taskCategory;
    }

    public function destroy($id)
    {
        $taskCategory = $this->taskCategory::find($id);
        $taskCategory->delete();
        return true;
    }
}
