<?php

namespace App\Repositories\Settings;
Use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Union;

class UnionRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Union
     */
    private $union;
    /**
     * UnionRepositories constructor.
     * @param Union $union
     */
    public function __construct(Union $union)
    {
        $this->union = $union;
        
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
        $edit = Helper::roleAccess('settings.union.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.union.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->union::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $unions = $this->union::select($columns)->with('upazila')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->union::count();
        } else {
            $search = $request->input('search.value');
            $unions = $this->union::select($columns)->with('upazila')->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->union::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach($unions as $key => $value ):
            if(!empty($value->upazila_id))
            $value->upazila_id = $value->upazila->name ?? '';
        endforeach;
        $columns = Helper::getTableProperty();
         $data = array();
        if ($unions) {
            foreach ($unions as $key => $union) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($union->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.union.status', [$union->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.union.status', [$union->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $union->$value;
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.union.edit', $union->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete != 0)
                $delete_data = '<a delete_route="' . route('settings.union.destroy', $union->id) . '" delete_id="' . $union->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $union->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->union::find($id);
        return $result;
    }

    public function store($request)
    {
        $union = new $this->union();
        $union->upazila_id = $request->upazila_id ;
        $union->name = $request->name;
        $union->bn_name = $request->bn_name;
        $union->url = $request->url;
        $union->status = 'Approved';
        $union->created_by =  helper::userId();
        $union->company_id =  helper::companyId();
        $union->save();
        return $union;
    }

    public function update($request, $id)
    {
        $union = $this->union::findOrFail($id);
        $union->upazila_id    = $request->upazila_id   ;
        $union->name = $request->name;
        $union->bn_name = $request->bn_name;
        $union->url = $request->url;
        $union->status = 'Approved';
        $union->updated_by =  helper::userId();
        $union->company_id = helper::companyId();
        $union->save();
        return $union;
    }

    public function statusUpdate($id, $status)
    {
        $union = $this->union::find($id);
        $union->status = $status;
        $union->save();
        return $union;
    }

    public function getUnionListByUpazilaId($upazilaId)
    {
        $unionList = $this->union::where('upazila_id',$upazilaId)->get();
        return $unionList;
    }

    public function destroy($id)
    {
        $union = $this->union::find($id);
        $union->delete();
        return true;
    }
}