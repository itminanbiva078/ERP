<?php

namespace App\Repositories\Settings;
Use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\District;

class DistrictRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var District
     */
    private $district;
    /**
     * DistrictRepositories constructor.
     * @param District $district
     */
    public function __construct(District $district)
    {
        $this->district = $district;
       
    }
/**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.district.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.district.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->district::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $districts = $this->district::select($columns)->with('division')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->district::count();
        } else {
            $search = $request->input('search.value');
            $districts = $this->district::select($columns)->with('division')->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->district::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        foreach($districts as $key => $value ):
            if(!empty($value->division_id))
            $value->division_id = $value->division->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
         $data = array();
        if ($districts) {
            foreach ($districts as $key => $district) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($district->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.district.status', [$district->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.district.status', [$district->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $district->$value;
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.district.edit', $district->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete != 0)
                $delete_data = '<a delete_route="' . route('settings.district.destroy', $district->id) . '" delete_id="' . $district->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $district->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->district::find($id);
        return $result;
    }

    public function store($request)
    {
        $district = new $this->district();
        $district->division_id  = $request->division_id ;
        $district->name = $request->name;
        $district->bn_name = $request->bn_name;
        $district->lat = $request->lat;
        $district->lon = $request->lon;
        $district->url = $request->url;
        $district->status = 'Approved';
        $district->created_by = helper::userId();
        $district->company_id = helper::companyId();
        $district->save();
        return $district;
    }

    public function update($request, $id)
    {
        $district = $this->district::findOrFail($id);
        $district->division_id  = $request->division_id ;
        $district->name = $request->name;
        $district->bn_name = $request->bn_name;
        $district->lat = $request->lat;
        $district->lon = $request->lon;
        $district->url = $request->url;
        $district->status = 'Approved';
        $district->updated_by = helper::userId();
        $district->company_id = helper::companyId();
        $district->save();
        return $district;
    }

    public function statusUpdate($id, $status)
    {
        $district = $this->district::find($id);
        $district->status = $status;
        $district->save();
        return $district;
    }

    public function getDistrictListByDivissionId($divissionId)
    {
        $districtList = $this->district::where('division_id',$divissionId)->get();
        return $districtList;
    }

    public function destroy($id)
    {
        $district = $this->district::find($id);
        $district->delete();
        return true;
    }
}