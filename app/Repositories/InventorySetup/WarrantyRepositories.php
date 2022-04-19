<?php

namespace App\Repositories\InventorySetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Warranty;


use DB;


class WarrantyRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Warranty
     */
    private $warranty;
    /**
     * CourseRepository constructor.
     * @param Warranty $warranty
     */
    public function __construct(Warranty $warranty)
    {
        $this->warranty = $warranty;
        //$this->middleware(function ($request, $next) {
        $this->user_id = 1; //auth()->user()->id;
        //  return $next($request);
        //});
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id"); 
        $edit = Helper::roleAccess('inventorySetup.warranty.edit') ? 1 : 0;
        $delete = Helper::roleAccess('inventorySetup.warranty.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->warranty::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $warrantys = $this->warranty::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->warranty::count();
        } else {
            $search = $request->input('search.value');
            $warrantys = $this->warranty::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->warranty::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($warrantys) {
            foreach ($warrantys as $key => $warranty) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($warranty->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('inventorySetup.warranty.status', [$warranty->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('inventorySetup.warranty.status', [$warranty->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $warranty->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('inventorySetup.warranty.edit', $warranty->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                if(1):
                    $delete_data = '<a delete_route="' . route('inventorySetup.warranty.destroy', $warranty->id) . '" delete_id="' . $warranty->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $warranty->id . '"><i class="fa fa-times"></i></a>';
                else:
                    $delete_data = '';
                endif;
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
        $result = $this->warranty::find($id);
        return $result;
    }

  
    public function store($request)
    {
        $warranty = new $this->warranty();
        $warranty->name = $request->name;
        $warranty->description = $request->description;
        $warranty->duration = $request->duration;
        $warranty->duration_type = $request->duration_type;
        $warranty->status = 'Approved';
        $warranty->created_by = Auth::user()->id;
        $warranty->company_id = Auth::user()->company_id;
        $warranty->save();
        return $warranty;
    }

    public function update($request, $id)
    {
        $warranty = $this->warranty::findOrFail($id);
        $warranty->name = $request->name;
        $warranty->description = $request->description;
        $warranty->duration = $request->duration;
        $warranty->duration_type = $request->duration_type;
        $warranty->status = 'Approved';
        $warranty->updated_by = Auth::user()->id;
        $warranty->company_id = Auth::user()->company_id;
        $warranty->save();
        return $warranty;
    }

    public function statusUpdate($id, $status)
    {
        $warranty = $this->warranty::find($id);
        $warranty->status = $status;
        $warranty->save();
        return $warranty;
    }

    public function destroy($id)
    {
        $warranty = $this->warranty::find($id);
        $warranty->delete();
        return true;
    }
}