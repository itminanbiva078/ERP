<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\StockSummary;
use App\Models\Store;
use App\Models\Supplier;

class BranchRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Branch
     */
    private $branch;
    /**
     * CourseRepository constructor.
     * @param branch $branch
     */
    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllBranch()
    {
      return  $this->branch::company()->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.branch.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.branch.destroy') ? 1 : 0;
        $ced = $edit + $delete;

        $totalData = $this->branch::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $branchs = $this->branch::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->branch::count();
        } else {

            $search = $request->input('search.value');
            $branchs = $this->branch::select($columns)->company()->where(function ($q) use ($columns,$search) {
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

            $totalFiltered = $this->branch::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


       $columns = Helper::getQueryProperty();

        $data = array();
        if ($branchs) {
            foreach ($branchs as $key => $branch) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                        if ($branch->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('settings.branch.status', [$branch->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('settings.branch.status', [$branch->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                        $nestedData[$value] = $status;
                    else:
                        $nestedData[$value] = $branch->$value;
                    endif;
                endforeach;

                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.branch.edit', $branch->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                        
                    if ($delete != 0)
                    if($this->checkBranchByExistsStockBranch($branch->id)===false && $this->checkBranchByExistsSupplier($branch->id)===false && $this->checkBranchByExistsCustomer($branch->id)===false && $this->checkBranchByExistsStockStore($branch->id)===false && $this->checkBranchByExistsStore($branch->id)===false):
                        $delete_data = '<a delete_route="' . route('settings.branch.destroy', $branch->id) . '" delete_id="' . $branch->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $branch->id . '"><i class="fa fa-times"></i></a>';
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
    public function checkBranchByExistsStockBranch($branchId){
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
    public function checkBranchByExistsStockStore($storeId){
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
    public function checkBranchByExistsStore($id){
        $storeList = Store::where('id', $id)->count();
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
    public function checkBranchByExistsCustomer($branchId){
        $branchList = Customer::where('branch_id', $branchId)->count();
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
    public function checkBranchByExistsSupplier($supplierId){
        $supplierList = Supplier::where('branch_id', $supplierId)->count();
        if($supplierList > 0){
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
        $result = $this->branch::find($id);
        return $result;
    }

    public function store($request)
    {
        $branch = new $this->branch();
        $branch->name = $request->name;
        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->address = $request->address;
        $branch->is_default = $request->is_default;
        $branch->status = 'Approved';
        $branch->created_by = helper::userId();
        $branch->company_id = helper::companyId();
        $branch->save();
        return $branch;
    }

    public function update($request, $id)
    {
        $branch = $this->branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->address = $request->address;
        $branch->is_default = $request->is_default;
        $branch->status = 'Approved';
        $branch->updated_by = helper::userId();
        $branch->company_id = helper::companyId();
        $branch->save();
        return $branch;
    }

    public function statusUpdate($id, $status)
    {
        $branch = $this->branch::find($id);
        $branch->status = $status;
        $branch->save();
        return $branch;
    }

    public function destroy($id)
    {
        $branch = $this->branch::find($id);
        $branch->delete();
        return true;
    }
}
