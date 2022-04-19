<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;

class VehicleRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Vehicle
     */
    private $vehicle;
    /**
     * VehicleRepositories constructor.
     * @param Vehicle $vehicle
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
       
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.vehicle.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.vehicle.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->vehicle::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $vehicles = $this->vehicle::select($columns)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->vehicle::count();
        } else {
            $search = $request->input('search.value');
            $vehicles = $this->vehicle::select($columns)->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->vehicle::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getTableProperty();
        $data = array();
        if ($vehicles) {
            foreach ($vehicles as $key => $vehicle) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($vehicle->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.vehicle.status', [$vehicle->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.vehicle.status', [$vehicle->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $vehicle->$value;
            endif;
        endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.vehicle.edit', $vehicle->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                    if ($delete != 0)
                        $delete_data = '<a delete_route="' . route('settings.vehicle.destroy', $vehicle->id) . '" delete_id="' . $vehicle->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $vehicle->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->vehicle::find($id);
        return $result;
    }

    public function store($request)
    {
        $vehicle = new $this->vehicle();
        $vehicle->branch_id = $request->branch_id;
        $vehicle->brand = $request->brand;
        $vehicle->year = $request->year;
        $vehicle->registration_no = $request->registration_no;
        $vehicle->chassis_no = $request->chassis_no;
        $vehicle->status = 'Approved';
        $vehicle->created_by = Auth::user()->id;
        $vehicle->company_id = Auth::user()->company_id;
        $vehicle->save();
        return $vehicle;
    }

    public function update($request, $id)
    {
        $vehicle = $this->vehicle::findOrFail($id);
        $vehicle->branch_id = $request->branch_id;
        $vehicle->brand = $request->brand;
        $vehicle->year = $request->year;
        $vehicle->registration_no = $request->registration_no;
        $vehicle->chassis_no = $request->chassis_no;
        $vehicle->status = 'Approved';
        $vehicle->updated_by = Auth::user()->id;
        $vehicle->company_id = Auth::user()->company_id;
        $vehicle->save();
        return $vehicle;
    }

    public function statusUpdate($id, $status)
    {
        $vehicle = $this->vehicle::find($id);
        $vehicle->status = $status;
        $vehicle->save();
        return $vehicle;
    }

    public function destroy($id)
    {
        $vehicle = $this->vehicle::find($id);
        $vehicle->delete();
        return true;
    }
}