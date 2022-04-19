<?php

namespace App\Repositories\ServiceSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServiceInvoiceDetails;
use App\Exports\ServicesExports;
use App\Imports\ServicesImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ServiceRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Service
     */
    private $service;
    /**
     * CourseRepository constructor.
     * @param service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('serviceSetup.service.edit') ? 1 : 0;
        $delete = Helper::roleAccess('serviceSetup.service.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->service::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $services = $this->service::select($columns)->company()->with('serviceCategory')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->service::count();
        } else {
            $search = $request->input('search.value');
            $services = $this->service::select($columns)->company()->with('serviceCategory')->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->service::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
        foreach( $services as $key => $value):
            if(!empty($value->service_id))
            $value->service_id = $value->serviceCategory->name ?? '';
        endforeach;

        $columns = Helper::getTableProperty();
        $data = array();
        if ($services) {
            foreach ($services as $key => $service) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($service->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('serviceSetup.service.status', [$service->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('serviceSetup.service.status', [$service->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $service->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('serviceSetup.service.edit', $service->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                if($this->checkService($service->id) === false):
                $delete_data = '<a delete_route="' . route('serviceSetup.service.destroy', $service->id) . '" delete_id="' . $service->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $service->id . '"><i class="fa fa-times"></i></a>';
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
    public function checkService($serviceId){
        $serviceList = ServiceInvoiceDetails::where('service_id', $serviceId)->count();
        if($serviceList > 0){
            return true;
        }else{
            return false;
        }
    }


     /**
     * @param $request
     * @return mixed
     */
    public function getActiveService()
    {
        $result = $this->service::where('status', 'Approved')->get();
        return $result;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->service::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeService(){
        DB::beginTransaction();
        try {
            Excel::import(new ServicesImports,request()->file('importFile'));
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
    public function explodeService()
    {
        return Excel::download(new ServicesExports, 'service-list.xlsx');

    }

     /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $service = new $this->service();
        $service->code = $request->code;
        $service->name = $request->name;
        $service->service_id  = $request->service_id ;
        $service->price = $request->price;
        $service->status = 'Approved';
        $service->created_by = helper::userId();
        $service->company_id = helper::companyId();
        $service->save();
        return $service;
    }

    public function update($request, $id)
    {
        $service = $this->service::findOrFail($id);
        $service->code = $request->code;
        $service->name = $request->name;
        $service->service_id  = $request->service_id ;
        $service->price = $request->price;
        $service->status = 'Approved';
        $service->updated_by = helper::userId();
        $service->company_id = helper::companyId();
        $service->save();
        return $service;
    }

    public function statusUpdate($id, $status)
    {
        $service = $this->service::find($id);
        $service->status = $status;
        $service->save();
        return $service;
    }

    public function destroy($id)
    {
        $service = $this->service::find($id);
        $service->delete();
        return true;
    }
}
