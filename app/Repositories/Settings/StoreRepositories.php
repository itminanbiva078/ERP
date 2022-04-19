<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Sales;
use App\Models\StockSummary;

class StoreRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Store
     */
    private $store;
    /**
     * CourseRepository constructor.
     * @param store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
       
    }
    /* @param $request
     * @return mixed
     */
    public function getStoreListByBranch($id)
    {
        return  $this->store::where('branch_id', $id)->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.store.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.store.destroy') ? 1 : 0;
        $ced = $edit + $delete;

        $totalData = $this->store::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $stores = $this->store::select($columns)->with('branch')->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->store::count();
        } else {
            $search = $request->input('search.value');
            $stores = $this->store::select($columns)->with('branch')->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->store::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getTableProperty();

        foreach($stores as $key => $value):
            if(!empty($value->branch_id))
                $value->branch_id = $value->branch->name ?? '';
        endforeach;

        $data = array();
        if ($stores) {
            foreach ($stores as $key => $store) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                
                if ($store->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.store.status', [$store->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.store.status', [$store->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $store->$value;
            endif;
            endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.store.edit', $store->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                    
                    if ($delete != 0)
                    if($this->checkBranchByExistsStock($store->id)===false && $this->checkStoreByExistsStock($store->id)===false):
                        $delete_data = '<a delete_route="' . route('settings.store.destroy', $store->id) . '" delete_id="' . $store->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $store->id . '"><i class="fa fa-times"></i></a>';
                    else:
                        $delete_data = '';
                    endif;
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
    public function checkBranchByExistsStock($branchId){
        $branchList = StockSummary::where('branch_id', $branchId)->count();
        if($branchList > 0){
            return true;
        }else{
            return false;
        }
    }
     /**
     * @param $request
     * @return mixed
     */
    public function checkStoreByExistsStock($storeId){
        $storeList = StockSummary::where('store_id', $storeId)->count();
        if($storeList > 0){
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
        $result = $this->store::find($id);
        return $result;
    }

    public function store($request)
    {
        $store = new $this->store();
        $store->branch_id = $request->branch_id;
        $store->name = $request->name;
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->is_default = $request->is_default;
        $store->status = 'Approved';
        $store->created_by = helper::userId();
        $store->company_id = helper::companyId();
        $store->save();
        return $store;
    }

    public function update($request, $id)
    {
        $store = $this->store::findOrFail($id);
        $store->name = $request->name;
        $store->branch_id = $request->branch_id;
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->is_default = $request->is_default;
        $store->status = 'Approved';
        $store->updated_by =  helper::userId();
        $store->company_id =  helper::companyId();
        $store->save();
        return $store;
    }

    public function statusUpdate($id, $status)
    {
        $store = $this->store::find($id);
        $store->status = $status;
        $store->save();
        return $store;
    }

    public function destroy($id)
    {
        $store = $this->store::find($id);
        $store->delete();
        return true;
    }
}