<?php

namespace App\Repositories\ServiceSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Exports\ServiceCategoryExports;
use App\Imports\ServiceCategoryImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ServiceCategoryRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ServiceCategory
     */
    private $serviceCategory;
    /**
     * ServiceCategoryRepositories constructor.
     * @param serviceCategory $serviceCategory
     */
    public function __construct(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('serviceSetup.serviceCategory.edit') ? 1 : 0;
        $delete = Helper::roleAccess('serviceSetup.serviceCategory.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->serviceCategory::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $serviceCategorys = $this->serviceCategory::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->serviceCategory::count();
        } else {
            $search = $request->input('search.value');
            $serviceCategorys = $this->serviceCategory::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->serviceCategory::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }

        $columns = Helper::getQueryProperty();
        $data = array();
        if ($serviceCategorys) {
            foreach ($serviceCategorys as $key => $serviceCategory) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                    if ($serviceCategory->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('serviceSetup.serviceCategory.status', [$serviceCategory->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('serviceSetup.serviceCategory.status', [$serviceCategory->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $serviceCategory->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('serviceSetup.serviceCategory.edit', $serviceCategory->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';

                if ($delete != 0)
                if($this->checkServiceByExistsCategory($serviceCategory->id) === false):
                $delete_data = '<a delete_route="' . route('serviceSetup.serviceCategory.destroy', $serviceCategory->id) . '" delete_id="' . $serviceCategory->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $serviceCategory->id . '"><i class="fa fa-times"></i></a>';
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

    public function checkServiceByExistsCategory($serviceId){
        $serviceCategoryList = Service::where("service_id", $serviceId )->count();
        if($serviceCategoryList > 0){
            return true;
        }else{
            return false;

        }
 }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->serviceCategory::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeServiceCategory(){
        DB::beginTransaction();
        try {
            Excel::import(new ServiceCategoryImports,request()->file('importFile'));
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
    public function explodeServiceCategory()
    {
        return Excel::download(new ServiceCategoryExports, 'service-category-list.xlsx');

    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $serviceCategory = new $this->serviceCategory();
        $serviceCategory->name = $request->name;
        $serviceCategory->parent_id = $request->parent_id;
        $serviceCategory->status = 'Approved';
        $serviceCategory->created_by = helper::userId();
        $serviceCategory->company_id = helper::companyId();
        $serviceCategory->save();
        return $serviceCategory;
    }

    public function update($request, $id)
    {
        $serviceCategory = $this->serviceCategory::findOrFail($id);
        $serviceCategory->name = $request->name;
        $serviceCategory->parent_id = $request->parent_id;
        $serviceCategory->status = 'Approved';
        $serviceCategory->updated_by = helper::userId();
        $serviceCategory->company_id = helper::companyId();
        $serviceCategory->save();
        return $serviceCategory;
    }

    public function statusUpdate($id, $status)
    {
        $serviceCategory = $this->serviceCategory::find($id);
        $serviceCategory->status = $status;
        $serviceCategory->save();
        return $serviceCategory;
    }

    public function destroy($id)
    {
        $serviceCategory = $this->serviceCategory::find($id);
        $serviceCategory->delete();
        return true;
    }
}
