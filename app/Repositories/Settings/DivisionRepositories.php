<?php

namespace App\Repositories\Settings;
Use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Division;

class DivisionRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Division
     */
    private $division;
    /**
     * DivisionRepositories constructor.
     * @param Division $division
     */
    public function __construct(Division $division)
    {
        $this->division = $division;
        
    }
/**
    
 /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.division.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.division.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->division::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $divisions = $this->division::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->division::count();
        } else {
            $search = $request->input('search.value');
            $divisions = $this->division::select($columns)->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->division::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getTableProperty();
         $data = array();
        if ($divisions) {
            foreach ($divisions as $key => $division) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($division->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.division.status', [$division->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.division.status', [$division->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $division->$value;
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.division.edit', $division->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete != 0)
                $delete_data = '<a delete_route="' . route('settings.division.destroy', $division->id) . '" delete_id="' . $division->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $division->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->division::find($id);
        return $result;
    }

    public function store($request)
    {
        $division = new $this->division();
        $division->name = $request->name;
        $division->bn_name = $request->bn_name;
        $division->url = $request->url;
        $division->status = 'Approved';
        $division->created_by = helper::userId();
        $division->company_id = helper::companyId();
        $division->save();
        return $division;
    }

    public function update($request, $id)
    {
        $division = $this->division::findOrFail($id);
        $division->name = $request->name;
        $division->bn_name = $request->bn_name;
        $division->url = $request->url;
        $division->status = 'Approved';
        $division->updated_by = helper::userId();
        $division->company_id = helper::companyId();
        $division->save();
        return $division;
    }

    public function statusUpdate($id, $status)
    {
        $division = $this->division::find($id);
        $division->status = $status;
        $division->save();
        return $division;
    }

    public function destroy($id)
    {
        $division = $this->division::find($id);
        $division->delete();
        return true;
    }
}